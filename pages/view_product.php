<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

$uri = $_SERVER['REQUEST_URI'];
$slug = basename($uri);
$sql = "select * from products where slug = '$slug'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name'] ?></title>
</head>
<body>
<div class="container p-4">
    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-md-6 col-lg-5">
            <div class="card h-100 border-0 bg-light p-3 d-flex align-items-center justify-content-center">
                <img src="../images/<?php echo $product['image'];?>" 
                     alt="<?php echo $product['name'];?>" 
                     class="img-fluid rounded" 
                     style="max-height: 400px; object-fit: contain;">
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6 col-lg-7">
            <h1 class="mb-3 fw-bold display-6"><?php echo $product['name'];?></h1>
            
            <!-- Price Section -->
            <div class="mb-4">
                <h2 class="text-danger fw-bold">৳<?php echo number_format($product['price'], 2);?></h2>
                <?php if(isset($product['quantity']) && $product['quantity'] > 0): ?>
                    <div>
                        <span class="fw-bold">Availability:</span>
                        <span class="badge bg-success ms-2">
                            In Stock
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Action Buttons -->
            <?php if (isset($product['quantity'])): ?>
            <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                <button class="<?php echo $product['quantity'] > 0 ? 'addToCart' : ''; ?> btn btn-<?php echo $product['quantity'] > 0 ? 'primary' : 'danger'; ?> btn-lg px-4 py-2 fw-bold" 
                        data-product-id="<?php echo $product['product_id'];?>">
                        <?php echo $product['quantity'] > 0 ? 'Add to Cart' : 'Out of Stock'; ?>
                </button>
            </div>
            <?php endif;?>
            <!-- Additional Info -->
            <div class="card border-0 bg-light p-3">
                <h5 class="fw-bold mb-3">Product Details</h5>
                <?php if(isset($product['description'])): ?>
                    <p class="mb-3"><?php echo $product['description'];?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/addToCart.js"></script>
</body>
</html>
