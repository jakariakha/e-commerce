<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../config/database.php');

$sql = "select * from products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $_SESSION['products'] = $products;
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
    <div class="card">
        <div class="card-body">
            <form action="">
                
            </form>
        </div>
    </div>
</body>
</html>