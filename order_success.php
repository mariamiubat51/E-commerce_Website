<?php
session_start();
$order = isset($_SESSION['order_summary']) ? $_SESSION['order_summary'] : null;
if (!$order) {
    header("Location: index.php");
    exit();
}

include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: rgb(191, 175, 219);
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-success text-center">🎉 Order Placed Successfully!</h2>

    <div class="card mt-4 p-4">
        <h5>Customer Info</h5>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
        <p><strong>Currency:</strong> <?php echo $order['currency']; ?></p>
        <hr>

        <h5>Order Items</h5>
        <ul>
        <?php foreach ($order['items'] as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['name']); ?> - 
                Qty: <?php echo $item['qty']; ?> × 
                <?php echo $order['currency'] . ' ' . number_format($item['price'], 2); ?> =
                <?php echo $order['currency'] . ' ' . number_format($item['qty'] * $item['price'], 2); ?>
            </li>
        <?php endforeach; ?>
        </ul>

        <h5 class="text-end mt-3">Total: <strong>
            <?php echo $order['currency'] . ' ' . number_format($order['total'], 2); ?>
        </strong></h5>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>

