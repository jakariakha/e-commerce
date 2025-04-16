<?php

if (isset($_SESSION['logged_in'])) {
    session_destroy();
    header('location: /admin/login');
    exit;
}
if (empty($_SESSION['logged_in'])) {
    header('location: /admin/login');
    exit;
}
?>