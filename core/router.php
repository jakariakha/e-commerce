<?php
$uri = $_SERVER['REQUEST_URI'];

$routes = [
    '/' => '../pages/home.php',
    '/login' => '../pages/login.php',
    '/logout' => '../pages/logout.php',
    '/register' => '../pages/register.php',
    '/profile' => '../pages/profile.php',
    '/get-product-details' => '../controllers/get-product-details.php',
    '/checkout' => '../pages/checkout.php',
    '/order-confirmation' => '../pages/order_confirmation.php',
    '/track-order' => '../pages/track_order.php',
    '/get-order-details' => '../controllers/get_order_details.php',
    '/products/'.basename($uri) => '../pages/view_product.php'
];

$adminRoutes = [
    '/admin/login' => '../admin/pages/login.php',
    '/admin/logout' => '../admin/pages/logout.php',
    '/admin/dashboard' => '../admin/pages/dashboard.php',
    '/admin/products' => '../admin/pages/products.php',
    '/admin/products/create' => '../admin/pages/create_product.php',
    '/admin/customers' => '../admin/pages/customers.php',
    '/admin/customers/create' => '../admin/pages/create_customers.php',
    '/admin/customers/edit/'.basename($uri) => '../admin/pages/edit_customer.php',
    '/admin/customers/delete/'.basename($uri) => '../admin/controllers/delete_customer.php',
    '/admin/orders' => '../admin/pages/orders.php',
    '/admin/orders/'.basename($uri) => '../admin/pages/order_details.php',
    '/admin/orders/update/'.basename($uri) => '../admin/controllers/update_order.php',
    '/admin/orders/delete/'.basename($uri) => '../admin/controllers/delete_order.php',
    '/admin/products/edit/'.basename($uri) => '../admin/pages/edit_product.php',
    '/admin/products/delete/'.basename($uri) => '../admin/pages/delete_product.php'
];

function isRouteExists($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        return require_once($routes[$uri]);
    }
    return require_once('../pages/404.php');
}

if ($uri === '/admin') {
    header('location: /admin/login');
    exit;
}

if (!strncmp('/admin', $uri, 6)) {
    isRouteExists($uri, $adminRoutes);
} else isRouteExists($uri, $routes);




?>