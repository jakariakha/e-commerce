<?php
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route = $_SERVER['REQUEST_URI'];
    $customerId = $_POST['customer_id'];
    $sql = "delete from customers where id = '$customerId'";
    $result = $conn->query($sql);
    if ($result) {
        $_SESSION['flash'] = [
          'status' => 'success',
          'message' => 'Customer deleted successfully.'
        ];
        echo 1;
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Customer delete failed.'
        ];
        echo 0;
    }
}
?>