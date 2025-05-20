<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include('includes/db_connect.php');
include('includes/header.php');

$res = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
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
    <h3 class="mb-4">👥 Registered Customers</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo htmlspecialchars($u['name']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo $u['created_at'] ?? 'N/A'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php include('includes/footer.php'); ?>
