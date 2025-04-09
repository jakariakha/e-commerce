<?php
session_start();
require_once('../includes/cdn.php');
$_SESSION['checkout_page'] = true;
require_once('../includes/navbar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['checkout_page']);
    $name = $_POST['name'];
    $mobileNumber = $_POST['mobileNumber'];
    $shippingAddress = $_POST['shippingAddress'];
    $cartItems = json_decode($_POST['cartItems']);
    print_r($cartItems);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Checkout</h1>
        <div class="card" style="width: 25rem">
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" id="cartItems" name="cartItems">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile-number" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="description" name="mobileNumber" placeholder="Enter your mobile number" required>
                    </div>
                    <div class="mb-3">
                        <label for="shipping-address" class="form-label">Shipping Address</label>
                        <input type="text" class="form-control" id="shippingAddress" name="shippingAddress" placeholder="Enter your shipping address" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button type="submit" class="btn btn-primary w-50">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/addToCart.js"></script>
    <script>
        document.getElementById('cartItems').value = JSON.stringify(localStorage.getItem('cartItems'));
    </script>
</body>
</html>