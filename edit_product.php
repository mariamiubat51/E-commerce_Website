<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db_connect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product = null;
if ($id > 0) {
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($res);
    if (!$product) {
        die("Product not found!");
    }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']);
    $main_category = $_POST['main_category'];
    $sub_category = $_POST['sub_category'];
    $image = $_POST['image']; // or use upload in future

    $sql = "UPDATE products SET 
                name = ?, 
                price = ?, 
                main_category = ?, 
                sub_category = ?, 
                image = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsssi", $name, $price, $main_category, $sub_category, $image, $id);
    $stmt->execute();

    $_SESSION['message'] = "✅ Product updated successfully!";
    header("Location: admin_products.php");
    exit();

}
?>

<?php include('includes/header.php'); ?>

<div class="container mt-5">
    <h3>Edit Product</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Price ($)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Main Category</label>
            <input type="text" name="main_category" class="form-control" value="<?php echo $product['main_category']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <input type="text" name="sub_category" class="form-control" value="<?php echo $product['sub_category']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Image Filename</label>
            <input type="text" name="image" class="form-control" value="<?php echo $product['image']; ?>" required>
            <small>Current image: <strong><?php echo $product['image']; ?></strong></small>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="admin_products.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
