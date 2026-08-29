<?php
require_once __DIR__ . '/layout_header.php';

require_once __DIR__ . '/../application/core/agents/EmailMarketingAgent.php';
require_once __DIR__ . '/../application/core/agents/AiOrchestratorAgent.php';

use App\Agents\EmailMarketingAgent;
use App\Agents\AiOrchestratorAgent;

$pdo_adm = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'novadrop'),
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') ?: '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$email_agent = new EmailMarketingAgent($pdo_adm, 1);
$ai_agent = new AiOrchestratorAgent($pdo_adm, 1);

$studio_msg = null;

// Handle 1-Click AI Orchestration Run
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_run_ai_orchestration'])) {
    $orch_res = $ai_agent->run_orchestration_cycle();
    if ($orch_res['success']) {
        $studio_msg = "<div class='alert alert-success shadow-sm'>âœ“ Autonomous Orchestration Cycle Completed! " . htmlspecialchars($orch_res['summary']) . "</div>";
    }
}

// Handle Generate Newsletter Draft
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_generate_newsletter'])) {
    $nl_res = $email_agent->generate_weekly_newsletter();
    if ($nl_res['success']) {
        $studio_msg = "<div class='alert alert-success shadow-sm'>âœ“ Weekly Innovation Newsletter Draft #{$nl_res['campaign_id']} compiled successfully!</div>";
    }
}

// Handle Create Campaign POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_create_campaign'])) {
    $name = trim($_POST['campaign_name'] ?? 'Campaign');
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body_html'] ?? '');

    if ($name && $subject && $body) {
        $pdo_adm->prepare("
            INSERT INTO email_campaigns (store_id, name, subject, body_html, status, created_at)
            VALUES (1, ?, ?, ?, 'draft', NOW())
        ")->execute([$name, $subject, $body]);
        $studio_msg = "<div class='alert alert-success shadow-sm'>âœ“ Campaign '$name' saved as draft!</div>";
    }
}

// Handle Send Campaign POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_send_campaign'])) {
    $camp_id = (int)$_POST['campaign_id'];
    $stmt_c = $pdo_adm->prepare("SELECT * FROM email_campaigns WHERE id = ?");
    $stmt_c->execute([$camp_id]);
    $campaign = $stmt_c->fetch();

    if ($campaign) {
        // Fetch all active subscribers
        $subscribers = $pdo_adm->query("SELECT email FROM email_subscribers WHERE subscribed = 1")->fetchAll(PDO::FETCH_COLUMN);
        $sent_count = 0;
        foreach ($subscribers as $sub_email) {
            $pdo_adm->prepare("
                INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
                VALUES (1, 'send_email', ?, 'pending', NOW(), NOW())
            ")->execute([
                json_encode(['job' => 'send_email', 'to' => $sub_email, 'subject' => $campaign['subject'], 'body_html' => $campaign['body_html']])
            ]);
            $sent_count++;
        }
        $pdo_adm->prepare("UPDATE email_campaigns SET status = 'sent', sent_count = ?, scheduled_at = NOW() WHERE id = ?")->execute([$sent_count, $camp_id]);
        $studio_msg = "<div class='alert alert-success shadow-sm'>âœ“ Campaign #$camp_id dispatched to $sent_count active subscribers!</div>";
    }
}

// Fetch Metrics
$total_subs = (int)$pdo_adm->query("SELECT COUNT(*) FROM email_subscribers WHERE subscribed = 1")->fetchColumn();
$total_campaigns = (int)$pdo_adm->query("SELECT COUNT(*) FROM email_campaigns")->fetchColumn();
$attributed_rev = (float)$pdo_adm->query("SELECT COALESCE(SUM(revenue_attributed), 0) FROM email_campaigns")->fetchColumn();
$ai_runs_count = (int)$pdo_adm->query("SELECT COUNT(*) FROM ai_orchestrator_runs")->fetchColumn();

// Fetch Campaigns
$campaigns = $pdo_adm->query("SELECT * FROM email_campaigns ORDER BY id DESC LIMIT 50")->fetchAll();

// Fetch Segments
$segments = $pdo_adm->query("SELECT * FROM email_segments ORDER BY id DESC")->fetchAll();

// Fetch Latest AI Run
$latest_ai_run = $pdo_adm->query("SELECT * FROM ai_orchestrator_runs ORDER BY id DESC LIMIT 1")->fetch();
$latest_decisions = $latest_ai_run ? (json_decode($latest_ai_run['decisions_json'], true) ?: []) : [];
?>

<div class="container-fluid py-4 cont">
    <?= $studio_msg ?>

    <!-- Studio Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="font-weight-bold text-dark mb-1"><i class="fas fa-brain text-primary mr-2"></i> Email Marketing &amp; AI Orchestration Studio</h3>
            <p class="text-muted small mb-0">Manage lifecycle email automations, customer segmentation rules, and autonomous AI decision intelligence.</p>
        </div>
        <div class="d-flex gap-2">
            <form method="POST" style="margin:0;">
                <input type="hidden" name="action_generate_newsletter" value="1">
                <button type="submit" class="btn btn-outline-primary btn-sm font-weight-bold">
                    <i class="fas fa-newspaper mr-1"></i> Compile Newsletter Draft
                </button>
            </form>
            <form method="POST" style="margin:0;">
                <input type="hidden" name="action_run_ai_orchestration" value="1">
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold">
                    <i class="fas fa-bolt mr-1"></i> Run AI Orchestrator
                </button>
            </form>
        </div>
    </div>

    <!-- 4 KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Email Subscribers</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_subs) ?></h3>
                        <span class="text-success small font-weight-bold"><i class="fas fa-check-circle mr-1"></i> 100% Opt-in Compliant</span>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-envelope-open-text"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Campaigns Built</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($total_campaigns) ?></h3>
                        <span class="text-muted small">Broadcasts &amp; Drafts</span>
                    </div>
                    <div class="icon-capsule purple" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-bullhorn"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Attributed Revenue</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">â‚¹<?= number_format($attributed_rev, 2) ?></h3>
                        <span class="text-success small font-weight-bold"><i class="fas fa-arrow-up mr-1"></i> Last-Click Tracking</span>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-rupee-sign"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">AI Orchestrator Cycles</div>
                        <h3 class="font-weight-bold text-warning mb-0 mt-1"><?= number_format($ai_runs_count) ?></h3>
                        <span class="text-muted small">Self-Tuning Engine</span>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-robot"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4" id="emailAiTabNav" style="gap: 8px;">
        <li class="nav-item"><a class="nav-link active font-weight-bold" data-toggle="pill" href="#campaignsTab"><i class="fas fa-paper-plane mr-1"></i> Email Campaigns</a></li>
        <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#segmentsTab"><i class="fas fa-users-cog mr-1"></i> Dynamic Segments</a></li>
        <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#orchestratorTab"><i class="fas fa-brain mr-1"></i> AI Decision Telemetry</a></li>
    </ul>

    <div class="tab-content">
        <!-- â”€â”€ TAB 1: EMAIL CAMPAIGNS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
        <div class="tab-pane fade show active" id="campaignsTab">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="font-weight-bold text-dark"><i class="fas fa-envelope mr-2 text-primary"></i> Lifecycle &amp; Broadcast Email Campaigns</span>
                    <button type="button" class="btn btn-sm btn-primary font-weight-bold" data-toggle="modal" data-target="#newCampaignModal">
                        <i class="fas fa-plus mr-1"></i> Create Email Campaign
                    </button>
                </div>

                <!-- Create Campaign Modal -->
                <div class="modal fade" id="newCampaignModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">Create Email Campaign</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form method="POST">
                                <input type="hidden" name="action_create_campaign" value="1">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted">Campaign Name</label>
                                        <input type="text" name="campaign_name" class="form-control" required placeholder="e.g. Ergonomic Keyboard Launch Announcement">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted">Subject Line</label>
                                        <input type="text" name="subject" class="form-control" required placeholder="e.g. âš¡ Upgrade Your Workflow: Wireless Split Ergo Keyboard is Here">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted">Email HTML Content</label>
                                        <textarea name="body_html" rows="6" class="form-control" required placeholder="<h2>Special Announcement</h2><p>Here is your exclusive access...</p>"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary font-weight-bold">Save as Draft</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Campaign Name</th>
                                    <th>Subject Line</th>
                                    <th>Status</th>
                                    <th>Recipients</th>
                                    <th>Opened</th>
                                    <th>Clicked</th>
                                    <th>Date</th>
                                    <th style="text-align:right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


if (empty($campaigns)): ?>
                                <tr><td colspan="8" class="text-center py-4 text-muted">No campaigns created yet. Click "Compile Newsletter Draft" or "+ Create Email Campaign" above.</td></tr>
                                <?php


else: foreach ($campaigns as $c): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                                    <td><small><?= htmlspecialchars($c['subject']) ?></small></td>
                                    <td>
                                        <?php


if ($c['status'] === 'sent'): ?>
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> SENT</span>
                                        <?php


else: ?>
                                        <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> DRAFT</span>
                                        <?php


endif; ?>
                                    </td>
                                    <td><strong><?= (int)$c['sent_count'] ?></strong></td>
                                    <td><?= (int)$c['open_count'] ?></td>
                                    <td><?= (int)$c['click_count'] ?></td>
                                    <td><small class="text-muted"><?= date('d M Y', strtotime($c['created_at'])) ?></small></td>
                                    <td style="text-align:right;">
                                        <?php


if ($c['status'] !== 'sent'): ?>
                                        <form method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="action_send_campaign" value="1">
                                            <input type="hidden" name="campaign_id" value="<?= $c['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-primary font-weight-bold"><i class="fas fa-paper-plane mr-1"></i> Dispatch Broadcast</button>
                                        </form>
                                        <?php


else: ?>
                                        <span class="text-success small font-weight-bold">Completed âœ“</span>
                                        <?php


endif; ?>
                                    </td>
                                </tr>
                                <?php


endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- â”€â”€ TAB 2: DYNAMIC SEGMENTS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
        <div class="tab-pane fade" id="segmentsTab">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark"><i class="fas fa-filter mr-2 text-primary"></i> Real-Time Customer Audience Segments</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Segment Name</th>
                                    <th>Dynamic Rule JSON</th>
                                    <th>Cross-Channel Fatigue Guard</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


if (empty($segments)): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No dynamic segments configured yet.</td></tr>
                                <?php


else: foreach ($segments as $s): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($s['rule_json']) ?></code></td>
                                    <td><span class="badge badge-success px-2 py-1"><i class="fas fa-shield-alt mr-1"></i> Active (24h WhatsApp Dedup)</span></td>
                                    <td><small class="text-muted"><?= date('d M Y', strtotime($s['created_at'])) ?></small></td>
                                </tr>
                                <?php


endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- â”€â”€ TAB 3: AI ORCHESTRATOR TELEMETRY â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
        <div class="tab-pane fade" id="orchestratorTab">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark"><i class="fas fa-microchip mr-2 text-warning"></i> Latest AI Autonomous Orchestration Cycle</span>
                    <?php


if ($latest_ai_run): ?>
                    <small class="text-muted">Last Run: <?= date('d M Y H:i:s', strtotime($latest_ai_run['run_at'])) ?></small>
                    <?php


endif; ?>
                </div>
                <div class="card-body">
                    <?php


if (empty($latest_decisions)): ?>
                    <div class="text-center py-4 text-muted">No AI orchestration cycle run yet. Click "Run AI Orchestrator" above to analyze store metrics.</div>
                    <?php


else: ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded border">
                                <h6 class="font-weight-bold text-primary mb-2"><i class="fas fa-clock mr-1"></i> Send-Time Optimization</h6>
                                <p class="small text-muted mb-1"><strong>Recommendation:</strong> <?= htmlspecialchars($latest_decisions['send_time_optimization']['action'] ?? 'N/A') ?></p>
                                <small class="text-muted">Reason: <?= htmlspecialchars($latest_decisions['send_time_optimization']['reason'] ?? '') ?></small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded border">
                                <h6 class="font-weight-bold text-success mb-2"><i class="fas fa-shield-alt mr-1"></i> Autonomous Pricing &amp; Guardrails</h6>
                                <p class="small text-muted mb-1"><strong>Status:</strong> <span class="badge badge-success"><?= strtoupper($latest_decisions['pricing_promotion']['status'] ?? 'AUTO_APPROVED') ?></span></p>
                                <small class="text-muted">Reason: <?= htmlspecialchars($latest_decisions['pricing_promotion']['reason'] ?? '') ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h6 class="font-weight-bold text-dark">Raw Decision Log:</h6>
                        <pre class="bg-dark text-success p-3 rounded small" style="max-height: 250px; overflow-y:auto;"><?= htmlspecialchars(json_encode($latest_decisions, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                    </div>
                    <?php


endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
