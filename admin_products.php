<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include('includes/db_connect.php');
include('includes/header.php');

$res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<div class="container mt-4">

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success text-center">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

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

<div class="container mt-4">
    <h3 class="mb-4">📦 All Products</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo $p['main_category']; ?></td>
                    <td><?php echo $p['sub_category']; ?></td>
                    <td>$<?php echo number_format($p['price'], 2); ?></td>
                    <td><img src="images/<?php echo $p['image']; ?>" width="60"></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

    <div class="text-end mb-3">
        <a href="add_product.php" class="btn btn-success">
            ➕ Add Product
        </a>
    </div>
    
</body>
</html>
<?php include('includes/footer.php'); ?>
