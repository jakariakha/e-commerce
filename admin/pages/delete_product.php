<?php
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    $sql = "delete from products where product_id = $product_id";
    $result = $conn->query($sql);

    if ($result) {
        $_SESSION['flash'] = [
            'status' => 'success',
            'message' => 'Product deleted successfully.'
        ];
        echo json_encode($_SESSION['flash']);
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Product delete failed.'
        ];
        echo json_encode($_SESSION['flash']);
    }
}

?>