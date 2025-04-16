<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

$customerId = basename($_SERVER['REQUEST_URI']);

$sql = "select * from customers where id = '$customerId'";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();
$parts = explode(' ', $customer['name']);
$firtName = $parts[0];
$lastName = $parts[1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route = $_SERVER['REQUEST_URI'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $name = $firstName.' '.$lastName;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($customer['email'] !== $email) {
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
  
    $sql = "update customers set name = '$name', email = '$email', password = '$password' where id = '$customerId'";
    $result = $conn->query($sql);
    if ($result) {
        $_SESSION['flash'] = [
          'status' => 'success',
          'message' => 'Customer updated successfully.'
        ];
        header('location: '.$route);
        exit;
    } else {
        $_SESSION['flash'] = [
            'status' => 'failed',
            'message' => 'Registration failed.'
        ];
        header('location: '.$route);
        exit;
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center mt-4">
  <h1 class="text-center mb-4">Update Customer</h1>
  <div class="row w-100 justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <form id="createCustomerForm" action="/admin/customers/edit/<?php echo $customerId; ?>" method="POST">
            <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firtName; ?>" placeholder="Enter first name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" placeholder="Enter last name" required>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer['email']; ?>" placeholder="Enter email address" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" value="<?php echo $customer['password']; ?>" minlength="8" maxlength="20" placeholder="Enter password (8-20 characters)" required>
            </div>
            
            <div class="mb-3">
              <label for="confirm-password" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" value="<?php echo $customer['password']; ?>" minlength="8" maxlength="20" placeholder="Enter confirm password" required>
            </div>
            
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary btn-lg">Update Customer</button>
            </div>
            <div class="d-grid">
              <a class="btn btn-warning btn-lg" href="/admin/customers">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- <script>
         window.onload = () => {
            document.getElementById('createProductForm').reset();
        }
    </script> -->
</body>
</html>