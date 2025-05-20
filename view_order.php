<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include('includes/db_connect.php');
include('includes/header.php');

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$orderSql = "SELECT * FROM orders WHERE id = $order_id";
$orderResult = $conn->query($orderSql);
$order = $orderResult->fetch_assoc();

$itemSql = "SELECT * FROM order_items WHERE order_id = $order_id";
$itemResult = $conn->query($itemSql);
?>

<?php if (isset($_SESSION['admin_logged_in'])): ?>
    <div class="text-end me-4 mt-2">
        <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h2 class="mb-4">🧾 Order #<?php echo $order['id']; ?> Details</h2>

    <div class="mb-3">
        <strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?><br>
        <strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?><br>
        <strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['customer_address'])); ?><br>
        <strong>Order Date:</strong> <?php echo $order['order_date']; ?><br>
        <strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?><br>
    </div>

    <h5>Order Items</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price ($)</th>
                <th>Subtotal ($)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $itemResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
