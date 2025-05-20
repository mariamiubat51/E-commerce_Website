<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db_connect.php');

// Categories for dropdowns
$mainCategories = ['Dress', 'Bag', 'Electronic Devices'];
$subCategories = [
    'Dress' => ['Male', 'Female', 'Child'],
    'Bag' => ['Handbag', 'School Bag', 'Travel Bag'],
    'Electronic Devices' => ['Phones', 'Laptops', 'Clocks']
];

$message = "";

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']);
    $main_category = $_POST['main_category'];
    $sub_category = $_POST['sub_category'];

    // Upload image
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetPath = "images/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $sql = "INSERT INTO products (name, price, main_category, sub_category, image)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsss", $name, $price, $main_category, $sub_category, $imageName);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Product added successfully!";
        header("Location: admin_products.php");
        exit();
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<?php include('includes/header.php'); ?>

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

<div class="container mt-5">
    <h3>Add New Product</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price ($)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Main Category</label>
            <select name="main_category" class="form-control" id="mainCategory" required>
                <option value="">Select...</option>
                <?php foreach ($mainCategories as $main): ?>
                    <option value="<?php echo $main; ?>"><?php echo $main; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="sub_category" class="form-control" id="subCategory" required>
                <option value="">Select Main Category First</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" required>
            <small class="text-muted">Image will be saved to /images/ folder</small>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="admin_products.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
const subCategories = <?php echo json_encode($subCategories); ?>;
const mainSelect = document.getElementById('mainCategory');
const subSelect = document.getElementById('subCategory');

mainSelect.addEventListener('change', function() {
    const main = this.value;
    subSelect.innerHTML = '<option value="">Select Subcategory</option>';

    if (subCategories[main]) {
        subCategories[main].forEach(function(sub) {
            const opt = document.createElement('option');
            opt.value = sub;
            opt.textContent = sub;
            subSelect.appendChild(opt);
        });
    }
});
</script>

</body>
</html>

<?php include('includes/footer.php'); ?>
