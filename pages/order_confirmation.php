<?php
require_once('../includes/cdn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Order Confirmation Card -->
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Order Confirmation</h3>
                    </div>
                    <div class="card-body">
                        <!-- Order Summary -->
                        <div class="mb-4">
                            <h5>Order ID: <?php echo $_SESSION['flash']['order_id']; ?></h5>
                            <p><strong>Order Status:</strong> <span class="badge bg-secondary"><?php echo $_SESSION['flash']['order_status']; ?></span></p>
                            <p><strong>Date:</strong><?php echo date('d-m-Y') ?></p>
                        </div>

                        <!-- Product List -->
                        <h5 class="mt-4">Products Ordered:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION['flash']['order_id'])): ?>
                                    <?php foreach($_SESSION['flash']['products'] as $product): ?>
                                    <tr>
                                        <td><?php echo $product->name; ?></td>
                                        <td><?php echo $product->quantity; ?></td>
                                        <td>৳<?php echo $product->price; ?></td>
                                        <td>৳<?php echo $product->price*$product->quantity; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Total Amount -->
                        <div class="d-flex justify-content-between mt-4">
                            <h5>Total Amount:</h5>
                            <h5>৳<?php echo $_SESSION['flash']['total_amount']; ?></h5>
                        </div>

                        <!-- Address Section -->
                        <div class="mt-4">
                            <h5>Shipping Address:</h5>
                            <p><?php echo $_SESSION['flash']['shipping_address']; unset($_SESSION['flash']);?></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 text-center">
                            <a href="/" class="btn btn-primary">Go to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        localStorage.removeItem('cartItems');
    </script>
</body>
</html>
