<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (strlen($password) < 8 || 20 < strlen($password)) {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Password length should be between 8 and 20.'
        ];
        header('location: /login');
        exit;
    }

    $sql = "select email, password from customers where email = '$email' and password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['auth'] = true;
        header('location: /');
        exit;
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Invalid email or password.'
        ];
        header('location: /login');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Login</h1>
        <div class="card" style="width: 25rem">
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" id="cartItems" name="cartItems">
                    <?php if (isset($_SESSION['flash'])): ?>
                        <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" minlength="8" maxlength="20" placeholder="Enter your email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="20" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button type="submit" class="btn btn-primary w-50">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>