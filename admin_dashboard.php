<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db_connect.php');
include('includes/header.php');

// Fetch stats
$orderCount = 0;
$totalRevenue = 0;
$productCount = 0;
$customerCount = 0;

// Total Orders
$res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
$row = mysqli_fetch_assoc($res);
$orderCount = $row['total'];

// Total Revenue
$res = mysqli_query($conn, "SELECT SUM(total_amount) AS revenue FROM orders");
$row = mysqli_fetch_assoc($res);
$totalRevenue = $row['revenue'] ?? 0;

// Total Products
$res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$row = mysqli_fetch_assoc($res);
$productCount = $row['total'];

// Total Customers
$res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$row = mysqli_fetch_assoc($res);
$customerCount = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgb(194, 178, 192);
        }
        a.text-decoration-none:hover .card {
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    transform: scale(1.01);
    transition: 0.3s;
}

    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-5">📈 Admin Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
    <a href="admin_orders.php" class="text-decoration-none">
        <div class="card border-primary text-center h-100">
            <div class="card-body">
                <h5 class="card-title text-primary">📦 Total Orders</h5>
                <h2><?php echo $orderCount; ?></h2>
            </div>
        </div>
    </a>
</div>


        <div class="col-md-3">
    <a href="admin_revenue.php" class="text-decoration-none">
        <div class="card border-success text-center h-100">
            <div class="card-body">
                <h5 class="card-title text-success">💵 Total Revenue</h5>
                <h2>$<?php echo number_format($totalRevenue, 2); ?></h2>
            </div>
        </div>
    </a>
</div>


        <div class="col-md-3">
    <a href="admin_products.php" class="text-decoration-none">
        <div class="card border-warning text-center h-100">
            <div class="card-body">
                <h5 class="card-title text-warning">📦 Total Products</h5>
                <h2><?php echo $productCount; ?></h2>
            </div>
        </div>
    </a>
</div>


        <div class="col-md-3">
    <a href="admin_customers.php" class="text-decoration-none">
        <div class="card border-info text-center h-100">
            <div class="card-body">
                <h5 class="card-title text-info">👥 Total Customers</h5>
                <h2><?php echo $customerCount; ?></h2>
            </div>
        </div>
    </a>
</div>

    </div>

    <div class="text-center mt-5">
        <a href="admin_orders.php" class="btn btn-outline-primary me-2">View Orders</a>
        <a href="admin_logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>
