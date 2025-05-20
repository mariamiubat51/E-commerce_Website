<!DOCTYPE html>
<html?>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
        body {
            background:rgb(182, 192, 194);
        }
    </style>
</head>
<body>
    <?php
session_start();
include('includes/db_connect.php');

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Get product from DB
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($res);

    if ($product) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty' => 1
            ];
        } else {
            $_SESSION['cart'][$id]['qty']++;
        }
    }
}

header('Location: cart.php');
exit();
