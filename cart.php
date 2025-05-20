
<?php
session_start();
include('includes/header.php');
include('includes/db_connect.php');

// Handle remove, increment, decrement
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_GET['action'] === 'remove') {
        unset($_SESSION['cart'][$id]);
    } elseif ($_GET['action'] === 'inc') {
        $_SESSION['cart'][$id]['qty'] += 1;
    } elseif ($_GET['action'] === 'dec') {
        $_SESSION['cart'][$id]['qty'] -= 1;
        if ($_SESSION['cart'][$id]['qty'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: cart.php");
    exit();
}


// Get products from cart session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total = 0;
?>


<!DOCTYPE html>
<html?>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
        body {
            background:rgb(191, 175, 219);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Cart</h2>

    <?php if (count($cartItems) > 0): ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $productId => $item): 
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" width="60"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <a href="cart.php?action=dec&id=<?php echo $productId; ?>" class="btn btn-sm btn-outline-secondary">–</a>
                        <?php echo $item['qty']; ?>
                        <a href="cart.php?action=inc&id=<?php echo $productId; ?>" class="btn btn-sm btn-outline-secondary">+</a>
                    </td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td><a href="cart.php?action=remove&id=<?php echo $productId; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: $<?php echo number_format($total, 2); ?></h4>
            <a href="checkout.php" class="btn btn-primary mt-2">Proceed to Checkout</a>
        </div>

    <?php else: ?>
        <div class="alert alert-info text-center">Your cart is empty.</div>
    <?php endif; ?>
</div>
</body>
</html>
<?php include('includes/footer.php'); ?>
