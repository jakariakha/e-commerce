<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

$product_id = basename($_SERVER['REQUEST_URI']);
$sql = "select * from products where product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $slug = strtolower(str_replace(' ', '-', $name));

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpName =$_FILES['image']['tmp_name'];
            $imageType = ($_FILES['image']['type']);
            $supportedImageType = [
                'image/png' => '.png',
                'image/jpg' => '.jpg'
            ];

            $imageExtension = (isset($supportedImageType[$imageType]) ? $supportedImageType[$imageType] : null );
            if (!$imageExtension) {
                $_SESSION['product_create'] = [
                    'status' => 'failed',
                    'message' => 'Image extension not allowed. Supported image extensions are png, jpg.'
                ];
                header('location: /admin/products/edit/'.$product_id);
                exit;
            }
            $imageName = time().$imageExtension;
            $imageMoveLocation = '/var/www/html/e-commerce/public/images/'.$imageName;

            if (!(move_uploaded_file($imageTmpName, $imageMoveLocation))) {
                $_SESSION['product_create'] = [
                    'status' => 'failed',
                    'message' => 'Image move failed!'
                ];
                header('location: /admin/products/edit/'.$product_id);
                exit;
            }
            
        } else {
            $_SESSION['product_create'] = [
                'status' => 'failed',
                'message' => 'Image upload failed!'
            ];
            header('location: /admin/products/edit/'.$product_id);
            exit;
        }
    }

    if (isset($imageName)) {
        $sql = "update products set name = '$name', description = '$description', image = '$imageName', category = '$category', quantity = '$quantity', price = '$price', slug = '$slug' where product_id = $product_id";
    } else {
        $sql = "update products set name = '$name', description = '$description', category = '$category', quantity = '$quantity', price = '$price', slug = '$slug' where product_id = $product_id";
    }

    if ($conn->query($sql)) {
        $_SESSION['product_update'] = [
            'status' => 'success',
            'message' => 'Product updated successfully!'
        ];
    } else {
        $_SESSION['product_update'] = [
            'status' => 'failed',
            'message' => 'Product update failed!'
        ];
    }

    header('location: /admin/products');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Edit Product</h1>
        <div class="card" style="max-width: 40rem">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                <?php if (isset($_SESSION['product_create'])): ?>
                    <div class="alert alert-<?php echo ($_SESSION['product_create']['status'] === 'failed') ? 'danger' : $_SESSION['product_create']['status']?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['product_create']['message']; unset($_SESSION['product_create']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo $product['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" value="<?php echo $product['category']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button type="submit" class="btn btn-primary w-25">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>