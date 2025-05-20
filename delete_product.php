<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include('includes/db_connect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    $_SESSION['message'] = "🗑️ Product deleted successfully!";
    header("Location: admin_products.php");
    exit();

}

header("Location: admin_products.php");
exit();
