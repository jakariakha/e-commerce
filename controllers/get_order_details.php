<?php
require_once('../config/database.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $mobileNumber = $_POST['mobile_number'];

    $sql = "select products.name, orders.id, orders.status, orders.total_price, orders.shipping_address, orders.ordered_at, order_items.price, order_items.quantity from orders inner join order_items on orders.id = order_items.order_id inner join products on products.product_id = order_items.product_id where order_items.order_id = '$orderId'";
    $result = $conn->query($sql);
    
    $orderDetails = [];

    if ($result->num_rows > 0) {
        $_SESSION['flash'];
        
        while ($row = $result->fetch_assoc()) {
            $orderDetails [] = $row;
        }

        $_SESSION['flash'] = $orderDetails;

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'failed']);
    }
} else {
    header('location: /');
    exit;
}

?>