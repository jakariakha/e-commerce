<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

$sql = "select * from products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $_SESSION['products'] = $products;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?php if (isset($_SESSION['products'])): ?>
    <div class="container">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 p-4">
            <?php foreach ($_SESSION['products'] as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="images/<?php echo $product['image']; ?>" class="img-fluid rounded object-fit-cover" alt="...">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h6 class="card-title"><?php echo $product['name'];?></h6>
                            <p>Price: <?php echo $product['price'];?> Taka</p>
                            <div class="d-flex justify-content-center">
                                <button class="addToCart btn btn-primary" data-product-id="<?php echo $product['product_id'];?>">Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;?>

<script src="assets/js/addToCart.js"></script>

</body>
</html>