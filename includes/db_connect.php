<?php
// Database connection variables
$servername = "localhost";  // Always localhost in XAMPP
$username = "root";          // Default username in XAMPP
$password = "";              // No password by default
$database = "ecommerce_db";  // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
