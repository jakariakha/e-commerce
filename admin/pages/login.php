<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../includes/cdn.php');
require_once('../config/database.php');

if (isset($_SESSION['logged_in']) && $_SESSION['role'] === 'admin') {
    header('location: /admin/dashboard');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "select * from admin where email = '$email' and password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = 'admin';
        header('location: /admin/dashboard');
        exit;
    }
    $_SESSION['flash'] = [
        'status' => 'failed',
        'message' => 'Invalid email or password.'
    ];
    header('location: /admin/login');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <div class="d-flex justify-content-center items-center mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center">Welcome</h4>
                <form action="" method="POST">
                    <?php if (isset($_SESSION['flash'])): ?>
                        <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>