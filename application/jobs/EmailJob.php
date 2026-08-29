<?php
namespace App\Jobs;

use PDO;
use Throwable;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * EmailJob
 * Sends transactional order confirmation and tracking emails with PHPMailer
 */
class EmailJob
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    public function handle(array $payload): bool
    {
        $order_id = (int)($payload['order_id'] ?? 0);
        $template = $payload['template'] ?? 'order_confirmed';

        if (!$order_id) return true;

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        if (!$order || empty($order['guest_email'])) {
            return true;
        }

        $to = $order['guest_email'];
        $subject = "Order {$order['order_number']} Confirmed — NovaDrop";
        $body = "<h2>Thank you for your order!</h2><p>Your order <strong>{$order['order_number']}</strong> has been received and is being processed.</p><p>Total: ₹" . number_format($order['total'], 2) . "</p>";

        if ($template === 'order_shipped') {
            $tracking = $payload['tracking'] ?? '';
            $carrier  = $payload['carrier'] ?? 'Courier';
            $subject  = "Your Order {$order['order_number']} has shipped! 🚚";
            $body     = "<h2>Great news! Your package is on the way.</h2><p>Carrier: <strong>$carrier</strong><br>Tracking #: <strong>$tracking</strong></p>";
        }

        // Try PHPMailer if SMTP configured
        try {
            if (class_exists('\PHPMailer\PHPMailer\PHPMailer') && !empty(env('MAIL_USERNAME'))) {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
                $mail->SMTPAuth   = true;
                $mail->Username   = env('MAIL_USERNAME');
                $mail->Password   = env('MAIL_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = (int)env('MAIL_PORT', 587);
                $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@novadrop.in'), env('MAIL_FROM_NAME', 'NovaDrop'));
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->send();
            }
        } catch (Throwable $e) {
            // Non-fatal, log and proceed
        }

        return true;
    }
}
