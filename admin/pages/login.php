<?php 
require_once('../includes/cdn.php');
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
                <h4 class="text-center">Welcome back!</h4>
                <form action="">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-outline-primary w-100">Login</button>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>