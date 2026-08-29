<?php
/**
 * NovaDrop Commerce OS — Enterprise Admin Layout Header v3.0
 * Provides universal session handling, auth check, database bridge,
 * premium CSS styles, fonts, and master navigation.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_name('js239');
    session_start();
}

require_once __DIR__ . '/../db.php';

// Auth check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Detect if page is being loaded standalone or included by index.php
$is_standalone = (basename($_SERVER['SCRIPT_FILENAME'] ?? '') !== 'index.php');

if ($is_standalone):
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>NovaDrop Commerce OS · Admin</title>
    <link rel="icon" href="../img/blogor.png" onerror="this.href='img/blogor.png'">

    <!-- Preconnects for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Inter + JetBrains Mono (premium SaaS typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900;1,14..32,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icons & Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Admin Design System -->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">

    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        /* Inline critical path styles for perceived performance */
        body { opacity: 0; transition: opacity 0.18s ease; }
        body.ready { opacity: 1; }
    </style>
</head>
<body class="" style="min-height: 100vh;" data-theme-pref="auto">

<script>
    // Immediately apply saved theme before paint to prevent flash
    (function() {
        var saved = localStorage.getItem('nd_theme') || 'light';
        if (saved === 'dark') document.body.classList.add('dark-mode');
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('ready');
        });
    })();
</script>

<?php include __DIR__ . '/head.php'; ?>
<?php endif; ?>
