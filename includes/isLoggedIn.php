<?php
if (empty($_SESSION['auth'])) {
    header('location: /login');
    exit;
}
?>