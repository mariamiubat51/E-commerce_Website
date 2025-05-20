<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include('includes/db_connect.php');
include('includes/header.php');

$res = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
?>

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
    <h3 class="mb-4">💵 Total Revenue Breakdown</h3>
    <canvas id="revenueChart" height="100"></canvas>
<hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total ($)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            while ($row = mysqli_fetch_assoc($res)): 
                $total += $row['total_amount'];
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer_email']); ?></td>
                    <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="text-end">Total Revenue: <span class="text-success">$<?php echo number_format($total, 2); ?></span></h4>
</div>

<?php
// Group revenue by date
$dateLabels = [];
$revenueData = [];

$chartRes = mysqli_query($conn, "
    SELECT DATE(order_date) as order_day, SUM(total_amount) as daily_total
    FROM orders GROUP BY DATE(order_date) ORDER BY order_day ASC
");

while ($row = mysqli_fetch_assoc($chartRes)) {
    $dateLabels[] = $row['order_day'];
    $revenueData[] = $row['daily_total'];
}
?>

<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dateLabels); ?>,
        datasets: [{
            label: 'Daily Revenue ($)',
            data: <?php echo json_encode($revenueData); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: '#198754',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>

<?php include('includes/footer.php'); ?>
