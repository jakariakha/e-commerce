<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $name = $firstName.' '.$lastName;
    $mobileNumber = $_POST['phone'];
    $shippingAddress = $_POST['shippingAddress'];
    $city = $_POST['city'];
    $cartItems = json_decode(json_decode($_POST['cartItems']));
    $totalPrice = 0;

    foreach($cartItems as $cartItem) {
      $totalPrice += $cartItem->price;
    }

    $customerId = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

    $orderQuery = "insert into orders(customer_id, customer_name, mobile_number, total_price, shipping_address, city) values('$customerId', '$name', '$mobileNumber', '$totalPrice', '$shippingAddress', '$city')";
    $orderInsertResult = $conn->query($orderQuery);

    if ($orderInsertResult) {
      $orderId = $conn->insert_id;
      foreach($cartItems as $cartItem) {
        $productId = $cartItem->product_id;
        $price = $cartItem->price;
        $quantity = $cartItem->quantity;
        $orderItemsQuery = "insert into order_items(order_id, product_id, price, quantity) values('$orderId ', '$productId', '$price', '$quantity')";
        $orderItemsInsertresult = $conn->query($orderItemsQuery);
      }

      if ($orderItemsInsertresult) {
        $_SESSION['flash'] = [
          'products' => $cartItems,
          'order_id' => $orderId,
          'order_status' => 'pending',
          'total_amount' => $totalPrice,
          'shipping_address' => $shippingAddress,
          'place_order' => true
        ];
      }
    }

    header('location: /order-confirmation');
    exit;
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
<div class="d-flex flex-column justify-content-center align-items-center mt-4">
  <h1 class="text-center mb-4">Checkout</h1>
  <div class="row w-100 justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <form id="createCustomerForm" action="" method="POST" enctype="multipart/form-data">

            <?php if (isset($_SESSION['product_create'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['product_create']['status'] === 'failed') ? 'danger' : $_SESSION['product_create']['status']?> alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['product_create']['message']; unset($_SESSION['product_create']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <input type="hidden" class="form-control" id="cartItems" name="cartItems">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>
            
            <div class="mb-3">
              <label for="address" class="form-label">Shipping Address</label>
              <textarea class="form-control" id="shippingAddress" name="shippingAddress" rows="2" placeholder="Enter full address" required></textarea>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <script src="assets/js/addToCart.js"></script>
    <script>
        document.getElementById('cartItems').value = JSON.stringify(localStorage.getItem('cartItems'));
    </script>
</body>
</html>