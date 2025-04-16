<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');


$sql = "select (select count(id) from customers) as total_customers,
        (select count(product_id) from products) as total_products,
        (select count(id) from orders) as total_orders,
        (select sum(total_price) from orders where status = 'Delivered') as total_revenue";

$result = $conn->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        $data = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<div class="container p-4">
    <div class="row text-center">
        <!-- Revenue -->
        <div class="col-12 col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-trend-up fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text">৳<?php echo $data['total_revenue'] == 0 ? 0 : $data['total_revenue']; ?></p>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-12 col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-box-open fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Products</h5>
                    <p class="card-text"><?php echo $data['total_products']; ?></p>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-12 col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-cart-shopping fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text"><?php echo $data['total_orders']; ?></p>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="col-12 col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-users fa-2x text-info mb-2"></i>
                    <h5 class="card-title">Total Cutomers</h5>
                    <p class="card-text"><?php echo $data['total_customers']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>