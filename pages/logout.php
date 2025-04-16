<?php
require_once('../includes/isLoggedIn.php');

if (isset($_SESSION['auth'])) {
    session_destroy();
    header('location: /login');
    exit;
}
?>