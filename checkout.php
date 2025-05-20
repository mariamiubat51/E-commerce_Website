<?php
session_start();
include('includes/header.php');
include('includes/db_connect.php');

// Get cart from session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Handle order submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $currency = $_POST['currency'];

    if ($name && $email && $address && count($cartItems) > 0) {
        // Calculate total amount
        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $total += $subtotal;
        }

        // Insert into orders table
        $orderSql = "INSERT INTO orders (customer_name, customer_email, customer_address, total_amount)
                     VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($orderSql);
        $stmt->bind_param("sssd", $name, $email, $address, $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert each item into order_items
        $itemSql = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($itemSql);
        foreach ($cartItems as $item) {
            $stmt->bind_param("isid", $order_id, $item['name'], $item['qty'], $item['price']);
            $stmt->execute();
        }
        $stmt->close();

        // Store summary in session
        $_SESSION['order_summary'] = [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'currency' => $currency,
            'total' => $total,
            'items' => $cartItems
        ];

        // Clear cart
        $_SESSION['cart'] = [];

        // Redirect to thank-you page
        header("Location: order_success.php");
        exit();

    } else {
        $message = "⚠️ Please fill out all fields and ensure your cart is not empty.";
    }
}
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

<div class="container mt-5">
    <h2 class="text-center mb-4">Checkout</h2>

    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (count($cartItems) > 0): ?>
        <h5>Order Summary:</h5>
        <table class="table table-bordered mb-4">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): 
                    $subtotal = $item['qty'] * $item['price'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['qty']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3">Total</th>
                    <th>$<?php echo number_format($total, 2); ?></th>
                </tr>
            </tbody>
        </table>

        <h5>Shipping Information:</h5>
        <form method="POST" action="checkout.php">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label>Currency</label>
                <select name="currency" class="form-control" required>
                    <option value="USD">$ USD</option>
                    <option value="BDT">৳ BDT</option>
                    <option value="EUR">€ EUR</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">Your cart is empty.</div>
    <?php endif; ?>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>
