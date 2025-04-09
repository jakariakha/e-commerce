<?php
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    $sql = "select product_id, name, price from products where product_id='$product_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product_details = $result->fetch_assoc();
        echo json_encode($product_details);
    } else return 0;
}

?>