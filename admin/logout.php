<?php
require_once __DIR__ . '/../db.php';

if (isset($_GET['type'])) {

    // For user logout
    if ($_GET['type'] == 'user')
    {
        echo '1st';
        session_name('user');
        session_start();
        if (isset($_SESSION['uloggedin']) && $_SESSION['uloggedin'] == true && isset($_SESSION['user']))
        {
            echo '2nd';
            session_unset();
            session_destroy();
            header("location: ulogin.php");
            exit;
        }
    }

    // For admin logout
    elseif ($_GET['type'] == 'admin')
    {
        session_name('js239');
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
        {
            session_unset();
            session_destroy();
            header("location: login.php");
            exit;
        }
    }
}
?>
