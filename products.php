
<?php
session_start();
include('includes/db_connect.php');
include('includes/header.php');

// Step 1: Get distinct categories for dynamic filter dropdowns
$mainCategories = [];
$subCategories = [];

$mainRes = mysqli_query($conn, "SELECT DISTINCT main_category FROM products ORDER BY main_category");
while ($row = mysqli_fetch_assoc($mainRes)) {
    $mainCategories[] = $row['main_category'];
}

$subRes = mysqli_query($conn, "SELECT DISTINCT sub_category FROM products ORDER BY sub_category");
while ($row = mysqli_fetch_assoc($subRes)) {
    $subCategories[] = $row['sub_category'];
}

// Step 2: Read filter input
$filterMain = isset($_GET['main_category']) ? $_GET['main_category'] : '';
$filterSub = isset($_GET['sub_category']) ? $_GET['sub_category'] : '';

// Step 3: Build dynamic WHERE clause
$conditions = [];
if ($filterMain !== '') {
    $conditions[] = "LOWER(TRIM(main_category)) = '" . strtolower(trim($filterMain)) . "'";
}
if ($filterSub !== '') {
    $conditions[] = "LOWER(TRIM(sub_category)) = '" . strtolower(trim($filterSub)) . "'";
}
$whereClause = count($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Step 4: Fetch filtered products and group
$sql = "SELECT * FROM products $whereClause ORDER BY main_category, sub_category, name";
$result = mysqli_query($conn, $sql);

$groupedProducts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $groupedProducts[$row['main_category']][$row['sub_category']][] = $row;
}
?>

<!DOCTYPE html>
<html?>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
        body {
            background:rgb(191, 175, 219);
        }
        .picture{
            height: 300px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Product Catalog</h2>

    <!-- Filter Form (Dynamic Dropdowns) -->
    <form method="GET" action="products.php" class="mb-5">
        <div class="row">
            <div class="col-md-4">
                <label>Main Category</label>
                <select name="main_category" class="form-control">
                    <option value="">All</option>
                    <?php foreach ($mainCategories as $main): ?>
                        <option value="<?php echo $main; ?>" <?php if ($filterMain == $main) echo 'selected'; ?>>
                            <?php echo $main; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <label>Sub Category</label>
                <select name="sub_category" class="form-control">
                    <option value="">All</option>
                    <?php foreach ($subCategories as $sub): ?>
                        <option value="<?php echo $sub; ?>" <?php if ($filterSub == $sub) echo 'selected'; ?>>
                            <?php echo $sub; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Product Display Section -->
    <?php if (!empty($groupedProducts)): ?>
        <?php foreach ($groupedProducts as $main => $subs): ?>
            <h2 class="mt-5"><?php echo htmlspecialchars($main); ?></h2>

            <?php foreach ($subs as $sub => $products): ?>
                <h4 class="mt-3 mb-3"><?php echo htmlspecialchars($sub); ?></h4>
                <div class="row">
                    <?php 
                    $count = 0;
                    foreach ($products as $product): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img class="picture" src="images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body bottom-0 text-center">
                                    <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                                    <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                    <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-success">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $count++;
                        if ($count % 4 === 0) echo '</div><div class="row">';
                    endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No products found for selected filter.</p>
    <?php endif; ?>
</div>

    </body>
    </html>
<?php include('includes/footer.php'); ?>
