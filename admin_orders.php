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

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<?php if (isset($_SESSION['admin_logged_in'])): ?>
    <div class="text-end me-4 mt-2">
        <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
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

<div class="container mt-5">
    <h2 class="mb-4 text-center">All Orders</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total ($)</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_email']); ?></td>
                        <td><?php echo number_format($row['total_amount'], 2); ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td>
                            <a href="view_order.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">No orders found.</div>
    <?php endif; ?>
</div>

    </body>
    </html>
<?php include('includes/footer.php'); ?>
