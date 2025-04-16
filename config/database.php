<?php
$serverName = 'localhost';
$userName = 'e-commerce_user';
$password = '';
$databaseName = 'e_commerce';

$conn = new mysqli($serverName, $userName, $password, $databaseName);

if ($conn->connect_error) {
    die("Database Connection Failed". $conn->connect_error);
}

?>