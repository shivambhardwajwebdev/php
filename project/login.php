<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require 'db.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Travel Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container_wrap">
        <div class="image_side"></div>
        <div class="form_side">
            <div class="header">
                <h3>Welcome Back</h3>
                <p>Please login to continue</p>
            </div>

            <?php if(isset($_GET['success'])) echo "<p style='color:#10b981; text-align:center;'>Registration successful! Please login.</p>"; ?>
            <?php if($error) echo "<p style='color:#ff4d4d; text-align:center;'>$error</p>"; ?>

            <form action="login.php" method="POST">
                <div class="input_group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input_group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <div class="auth-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>