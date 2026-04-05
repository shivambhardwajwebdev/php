\<?php
require 'db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = $con->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $message = "<p style='color: #ff4d4d;'>Email already registered!</p>";
    } else {
        $stmt = $con->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $full_name, $email, $password);
        if ($stmt->execute()) {
            header("Location: login.php?success=1");
            exit();
        } else {
            $message = "<p style='color: #ff4d4d;'>Registration failed. Try again.</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Travel Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container_wrap">
        <div class="image_side"></div>
        <div class="form_side">
            <div class="header">
                <h3>Create Account</h3>
                <p>Join the IIT Kharagpur US Trip</p>
            </div>
            <?php echo $message; ?>
            <form action="register.php" method="POST">
                <div class="input_group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required placeholder="John Doe">
                </div>
                <div class="input_group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="name@email.com">
                </div>
                <div class="input_group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn">Register Now</button>
            </form>
            <div class="auth-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>
</body>
</html>