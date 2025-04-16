<?php
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];

    $deleteOrderItems = "delete from order_items where order_id = $orderId";
    $deleteOrderItemsResult = $conn->query($deleteOrderItems);
    if ($deleteOrderItemsResult) {
        $sql = "delete from orders where id = $orderId";
        $result = $conn->query($sql);
        if ($result) {
            $_SESSION['flash'] = [
                'status' => 'success',
                'message' => 'Order deleted successfully.'
            ];
            echo 1;
        } else {
            $_SESSION['flash'] = [
                'status' => 'failed',
                'message' => 'Order delete failed.'
            ];
            echo 0;
        }
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Order delete failed.'
        ];
        echo 0;
    }
    
} else {
    header('location: /admin/dashboard');
    exit;
}
?>