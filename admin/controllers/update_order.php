<?php
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = basename($_SERVER['REQUEST_URI']);
    $orderStatus = $_POST['orderStatus'];

    $sql = "update orders set status = '$orderStatus' where id = '$orderId'";
    $result = $conn->query($sql);

    if ($result) {
        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Order updated successfully.'
        ];
        header('location: /admin/orders/'.$orderId);
        exit;
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Order update failed.'
        ];
        header('location: /admin/orders/'.$orderId);
        exit;
    }
}


?>