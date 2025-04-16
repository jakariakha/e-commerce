<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../config/database.php');

$orderId = basename($_SERVER['REQUEST_URI']);

$sql = "select products.name, orders.status, orders.total_price, orders.shipping_address, orders.ordered_at, order_items.price, order_items.quantity from orders inner join order_items on orders.id = order_items.order_id inner join products on products.product_id = order_items.product_id where order_items.order_id = '$orderId'";
$result = $conn->query($sql);

$orderDetails = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row; 
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Order Confirmation Card -->
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Order Details</h3>
                    </div>
                    <div class="card-body">

                    <?php if (isset($_SESSION['flash'])): ?>
                        <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                        <!-- Order Summary -->
                    <form action="/admin/orders/update/<?php echo $orderId; ?>" method="POST">
                        <div class="mb-4">
                            <h5>Order ID: <?php echo $orderId; ?></h5>
                            <p><strong>Order Status:</strong>
                            <select class="form-select" id="orderStatus" name="orderStatus" required>
                                <option value="Pending" <?php echo $orderDetails[0]['status'] === 'Pending' ? 'selected' : ''; ?> >Pending</option>
                                <option value="Confirmed" <?php echo $orderDetails[0]['status'] === 'Confirmed' ? 'selected' : ''; ?> >Confirmed</option>
                                <option value="Canceled" <?php echo $orderDetails[0]['status'] === 'Canceled' ? 'selected' : ''; ?> >Canceled</option>
                                <option value="Delivered"  <?php echo $orderDetails[0]['status'] === 'Delivered' ? 'selected' : ''; ?> >Delivered</option>
                                <option value="Processing" <?php echo $orderDetails[0]['status'] === 'Processing' ? 'selected' : ''; ?> >Processing</option>
                                <option value="Pending Payment" <?php echo $orderDetails[0]['status'] === 'Pending Payment' ? 'selected' : ''; ?> >Pending Payment</option>
                            </select>
                            </p>
                            <p><strong>Date: </strong><?php echo date('d-m-Y', strtotime($orderDetails[0]['ordered_at']));  ?></p>
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
                                <?php if (isset($orderDetails)): ?>
                                    <?php foreach($orderDetails as $product): ?>
                                    <tr>
                                        <td><?php echo $product['name']; ?></td>
                                        <td><?php echo $product['quantity']; ?></td>
                                        <td>৳<?php echo $product['price']; ?></td>
                                        <td>৳<?php echo $product['price']*$product['quantity']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Total Amount -->
                        <div class="d-flex justify-content-between mt-4">
                            <h5>Total Amount:</h5>
                            <h5>৳<?php echo $orderDetails[0]['total_price']; ?></h5>
                        </div>

                        <!-- Address Section -->
                        <div class="mt-4">
                            <h5>Shipping Address:</h5>
                            <p><?php echo $orderDetails[0]['shipping_address']; ?></p>
                        </div>

                        <!-- Action Buttons -->
                         <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="/admin/orders" class="btn btn-warning me-2">Back</a>
                                    <button type="submit" href="" class="btn btn-primary">Update</button >
                                </div>
                            </div>
                         </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
