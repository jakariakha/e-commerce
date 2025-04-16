<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!(isset($_SESSION['logged_in']) && $_SESSION['role'] === 'admin')) {
    header('location: /admin/login');
    exit;
}

?>