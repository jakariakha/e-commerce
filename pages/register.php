<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');
require_once('../config/database.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route = $_SERVER['REQUEST_URI'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $name = $firstName.' '.$lastName;
    // print_r($name);
    // return;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $isEmailExists = "select email from customers where email = '$email'";
    $isEmailExistsResult = $conn->query($isEmailExists);

    if ($isEmailExistsResult->num_rows > 0) {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Email already exists.'
        ];
        header('location: '.$route);
        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Password and confirm password not match.'
        ];
        header('location: '.$route);
        exit;
    }

    if (strlen($password) < 8 || 20 < strlen($password)) {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Password length should be between 8 and 20.'
        ];
        header('location: '.$route);
        exit;
    }

    $sql = "insert into customers(name, email, password, role) values('$name', '$email', '$password', 'customer')";
    $result = $conn->query($sql);
    if ($result) {
        $_SESSION['auth'] = true;
        header('location: /');
        exit;
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Registration failed.'
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
                    <?php if (isset($_SESSION['flash'])): ?>
                    <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="20" placeholder="Enter your password (8-20 characters)" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
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