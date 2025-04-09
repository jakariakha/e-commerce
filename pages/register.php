<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $mobileNumber = $_POST['mobileNumber'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confrimPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['password_mismatch'] = [
            'status' => 'failed',
            'message' => 'Password and confirm password not match.'
        ];
        header('location: /register');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Registration</h1>
        <div class="card" style="width: 25rem">
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" id="cartItems" name="cartItems">
                    <?php if (isset($_SESSION['password_mismatch'])): ?>
                    <div class="alert alert-<?php echo ($_SESSION['password_mismatch']['status'] === 'failed') ? 'danger' : $_SESSION['password_mismatch']['status']?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['password_mismatch']['message']; unset($_SESSION['password_mismatch']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile-number" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="mobileNumber" name="mobileNumber" minlength="11" maxlength="11" placeholder="Enter your mobile number (11 digits)" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="20" placeholder="Enter your password (8-10 characters)" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter your confirm password" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button type="submit" class="btn btn-primary w-50">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>