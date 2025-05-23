<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

$sql = "select * from products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All products</title>
</head>
<body>
    <div class="p-2">
        <a class="btn btn-primary rounded-lg" href="/admin/products/create">Create Product</a>
    </div>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($products)): ?>
                        <?php foreach($products as $product): ?>
                            <tr>
                                <th scope="row"><?php echo $product['product_id']; ?></th>
                                <th scope="row">
                                    <div class="h-100" style="max-height: 50px; width: 50px; overflow: hidden;">
                                        <img src="<?php echo '../images/' . $product['image']; ?>" 
                                            class="img-fluid w-100 h-100 object-fit-cover" 
                                            alt="Product Image">
                                    </div>
                                </th>
                                <th scope="row"><?php echo $product['name']; ?></th>
                                <th scope="row"><?php echo $product['price']; ?>৳</th>
                                <th scope="row"><?php echo $product['quantity']; ?></th>
                                <th scope="row"><span class="badge text-bg-<?php echo $product['quantity'] > 0 ? 'info' : 'danger' ?>"><?php echo $product['quantity'] > 0 ? 'In stock' : 'Out of stock' ?></span></th>
                                <th scope="row">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a class="btn btn-success mb-2" href="/admin/products/edit/<?php echo $product['product_id']; ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Are you sure to delete this product?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="deleteButton" data-product-id="<?php echo $product['product_id']; ?>" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        const deleteProduct = (productId) => {
            console.log('/admin/products/delete/'+productId);
            $.ajax({
                url : '/admin/products/delete/'+productId,
                type : 'POST',
                data : {
                    'product_id' : productId
                },
                success : (response) => {
                    window.location.href = '/admin/products';
                }

            });
        }
        $('#deleteButton').off('click').click(function() {
            const productId = $(this).data('product-id');
            deleteProduct(productId);
        });
    });
</script>
</body>
</html>