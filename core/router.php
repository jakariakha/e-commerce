<?php
$uri = $_SERVER['REQUEST_URI'];

switch($uri) {
    case '/':
        return require_once('../pages/home.php');
        break;
    default:
        return require_once('../pages/404.php');
}

?>