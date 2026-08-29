<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AgentJob — Base class for all background agent tasks.
 * Mirrors the pattern from Automation/agents/AgentJob.php.
 * All jobs must be idempotent — safe to retry without side effects.
 */
abstract class AgentJob
{
    protected CI_Controller $CI;
    protected int $store_id = 1;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->store_id = (int)(config_item('store_id') ?? 1);
    }

    /**
     * Implement the job logic.
     * @param  array  $payload  Decoded from jobs_queue.payload JSON
     * @return bool   true = done, false = should retry
     */
    abstract public function handle(array $payload): bool;

    /**
     * Called by JobWorker — wraps handle() with retry tracking and error logging.
     * @param  int    $job_id   jobs_queue.id
     * @param  array  $payload
     */
    final public function run(int $job_id, array $payload): void
    {
        $this->_mark_running($job_id);

        try {
            $success = $this->handle($payload);
            if ($success) {
                $this->_mark_done($job_id);
            } else {
                $this->_mark_retry($job_id, 'Job returned false');
            }
        } catch (Throwable $e) {
            $msg = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
            log_message('error', '[AgentJob::run] job_id=' . $job_id . ' ' . get_class($this) . ': ' . $msg . "\n" . $e->getTraceAsString());
            $this->_log_error($e, get_class($this));
            $this->_mark_retry($job_id, $msg);
        }
    }

    // ─── Gemini AI helper ─────────────────────────────────────

    /**
     * Call Gemini API with a prompt. Returns the text response or null on failure.
     * NEVER throws — always returns null on error.
     */
    protected function gemini(string $prompt, string $system_hint = ''): ?string
    {
        $api_key = env('GEMINI_API_KEY', '');
        $model   = env('GEMINI_MODEL', 'gemini-1.5-flash');

        if (empty($api_key) || $api_key === 'REPLACE_ME') {
            log_message('warning', '[AgentJob::gemini] GEMINI_API_KEY not configured');
            return null;
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$api_key";

        $parts = [];
        if ($system_hint) {
            $parts[] = ['text' => "System context: $system_hint\n\n$prompt"];
        } else {
            $parts[] = ['text' => $prompt];
        }

        $body = json_encode([
            'contents' => [['parts' => $parts]],
            'generationConfig' => [
                'temperature'   => 0.7,
                'maxOutputTokens' => 2048,
            ],
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 30,
        ]);
        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $err) {
            log_message('error', "[AgentJob::gemini] curl error: $err");
            return null;
        }

        $decoded = json_decode($raw, true);
        return $decoded['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }

    /**
     * Send an email using PHPMailer.
     * Never throws — logs on failure.
     */
    protected function send_email(string $to, string $subject, string $html_body, string $name = ''): bool
    {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME', '');
            $mail->Password   = env('MAIL_PASSWORD', '');
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)env('MAIL_PORT', 587);
            $mail->CharSet    = 'UTF-8';
            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@novadrop.in'), env('MAIL_FROM_NAME', 'NovaDrop'));
            $mail->addAddress($to, $name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html_body;
            $mail->send();
            return true;
        } catch (Throwable $e) {
            log_message('error', "[AgentJob::send_email] to=$to subject=$subject: " . $e->getMessage());
            return false;
        }
    }

    // ─── Job queue helpers ────────────────────────────────────

    protected function enqueue(string $queue, array $payload, int $delay_seconds = 0): int
    {
        $available_at = date('Y-m-d H:i:s', time() + $delay_seconds);
        $this->CI->db->insert('jobs_queue', [
            'store_id'     => $this->store_id,
            'queue'        => $queue,
            'payload'      => json_encode($payload),
            'available_at' => $available_at,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
        return $this->CI->db->insert_id();
    }

    // ─── Private ─────────────────────────────────────────────

    private function _mark_running(int $job_id): void
    {
        $this->CI->db->where('id', $job_id)->update('jobs_queue', [
            'status'     => 'running',
            'started_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function _mark_done(int $job_id): void
    {
        $this->CI->db->where('id', $job_id)->update('jobs_queue', [
            'status'      => 'done',
            'finished_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function _mark_retry(int $job_id, string $error): void
    {
        $job = $this->CI->db->where('id', $job_id)->get('jobs_queue')->row_array();
        $attempts    = (int)($job['attempts'] ?? 0) + 1;
        $max_attempts = (int)($job['max_attempts'] ?? 3);

        if ($attempts >= $max_attempts) {
            $this->CI->db->where('id', $job_id)->update('jobs_queue', [
                'status'        => 'failed',
                'attempts'      => $attempts,
                'finished_at'   => date('Y-m-d H:i:s'),
                'error_message' => substr($error, 0, 65535),
            ]);
        } else {
            // Exponential back-off: 60s, 300s, 900s
            $delay = min(60 * pow(5, $attempts - 1), 900);
            $this->CI->db->where('id', $job_id)->update('jobs_queue', [
                'status'        => 'pending',
                'attempts'      => $attempts,
                'available_at'  => date('Y-m-d H:i:s', time() + $delay),
                'error_message' => substr($error, 0, 65535),
            ]);
        }
    }

    private function _log_error(Throwable $e, string $context): void
    {
        try {
            $this->CI->db->insert('error_log', [
                'store_id'   => $this->store_id,
                'severity'   => 'error',
                'context'    => $context,
                'message'    => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $inner) {
            log_message('error', '[AgentJob::_log_error] secondary failure: ' . $inner->getMessage());
        }
    }
}
