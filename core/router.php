<?php
$uri = $_SERVER['REQUEST_URI'];

switch($uri) {
    case $uri === '/':
        require_once('../pages/home.php');
        break;
    case $uri === '/admin':
        header('location: /admin/login');
        break;
    case $uri === '/admin/login':
        require_once('../admin/pages/login.php');
        break;
    case $uri === '/admin/dashboard':
        require_once('../admin/pages/dashboard.php');
        break;
    case $uri === '/admin/products':
        require_once('../admin/pages/products.php');
        break;
    case $uri === '/admin/products/create':
        require_once('../admin/pages/create_product.php');
        break;
    case $uri === '/get-product-details':
        require_once('../controllers/get-product-details.php');
        break;
    case $uri === '/checkout':
        require_once('../pages/checkout.php');
        break;
    case $uri === '/register':
        require_once('../pages/register.php');
        break;
    default:
        require_once('../pages/404.php');
}

?>