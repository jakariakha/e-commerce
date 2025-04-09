<?php
session_start();
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

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
            header('location: /admin/products/create');
            exit;
        }
        $imageName = time().$imageExtension;
        $imageMoveLocation = '/var/www/html/e-commerce/public/images/'.$imageName;

        if (!(move_uploaded_file($imageTmpName, $imageMoveLocation))) {
            $_SESSION['product_create'] = [
                'status' => 'failed',
                'message' => 'Image move failed!'
            ];
            header('location: /admin/products/create');
            exit;
        }
        
    } else {
        $_SESSION['product_create'] = [
            'status' => 'failed',
            'message' => 'Image upload failed!'
        ];
        header('location: /admin/products/create');
        exit;
    }

    $sql = "insert into products(name, description, category, image, quantity, price) values('$name', '$description', '$category', '$imageName', '$quantity', '$price')";
    if ($conn->query($sql)) {
        $_SESSION['product_create'] = [
            'status' => 'success',
            'message' => 'Product created successfully!'
        ];
    } else {
        $_SESSION['product_create'] = [
            'status' => 'failed',
            'message' => 'Product create failed!'
        ];
    }

    header('location: /admin/products/create');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create product</title>
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Create Product</h1>
        <div class="card" style="width: 40rem">
            <div class="card-body">
                <form id="createProductForm" action="" method="POST" enctype="multipart/form-data">
                    <?php if (isset($_SESSION['product_create'])): ?>
                    <div class="alert alert-<?php echo ($_SESSION['product_create']['status'] === 'failed') ? 'danger' : $_SESSION['product_create']['status']?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['product_create']['message']; unset($_SESSION['product_create']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter product description" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter product category" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" placeholder="Upload product image" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter product quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button type="submit" class="btn btn-primary w-25">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
         window.onload = () => {
            document.getElementById('createProductForm').reset();
        }
    </script>
</body>
</html>