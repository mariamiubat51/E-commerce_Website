<?php
session_start();
include('includes/db_connect.php');

// Registration logic
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirm_password) {
        // 1. Check if email already exists
        $check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            $message = "Email already registered. Please login or use another email.";
        } else {
            // 2. Email is new, Insert user into database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $sql)) {
                $message = "Registration successful! You can now login.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    } else {
        $message = "Passwords do not match!";
    }
}?>

<?php include('includes/header.php'); ?>


<?php if ($message) { echo '<div class="alert alert-info text-center">' . $message . '</div>'; } ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgb(194, 178, 192);
        }
        .login-box {
            margin-top: 100px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
 
<div class="row justify-content-center">
    <div class="col-md-6 login-box">
        <h2 class="text-center">Register</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>
