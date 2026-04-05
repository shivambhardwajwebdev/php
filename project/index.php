<?php
session_start();
require 'db.php';

// 1. Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = false;

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];

    // Secure Prepared Statement for Insertion
    $stmt = $con->prepare("INSERT INTO trip_applications (user_id, age, gender, phone, other_info) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $age, $gender, $phone, $desc);
    
    if ($stmt->execute()) {
        $success = true;
    }
    $stmt->close();
}

// 3. Check if user has already filled the form (using Prepared Statement)
$check_stmt = $con->prepare("SELECT id FROM trip_applications WHERE user_id = ?");
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$already_filled = ($result->num_rows > 0);
$check_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container_wrap">
        <div class="image_side"></div>
        <div class="form_side">
            <div class="header">
                <img src="images/logo.png" width="50" alt="Logo">
                <h3>US Trip Form</h3>
                <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong> | <a href="logout.php" style="color:#ff4d4d">Logout</a></p>
            </div>

            <?php if($success || $already_filled): ?>
                <div style="text-align:center; padding: 20px;">
                    <p style="color: #10b981; font-size: 1.1rem; margin-bottom: 10px;">✓ Thank you for filling the form!</p>
                    <p style="color: var(--text-dim);">Your application is confirmed. See you at the trip!</p>
                </div>
            <?php else: ?>
                <form action="index.php" method="POST">
                    <div class="row">
                        <div class="input_group">
                            <label>Age</label>
                            <input type="number" name="age" required min="18" max="99">
                        </div>
                        <div class="input_group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" required placeholder="+91 ...">
                    </div>
                    <div class="input_group">
                        <label>Additional Queries</label>
                        <textarea name="desc" rows="4" placeholder="Anything else we should know?"></textarea>
                    </div>
                    <button type="submit" class="btn">Submit Application</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>