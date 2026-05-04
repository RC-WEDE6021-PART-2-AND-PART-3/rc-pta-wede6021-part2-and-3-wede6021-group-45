<?php
session_start();
include 'DBConn.php';

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST['admin_username'];
    // Using md5 to match the dummy admin insertion script
    $inputPass = md5($_POST['admin_password']);

    // Prepare statement to prevent SQL injection
    $sql = "SELECT * FROM tblAdmin WHERE username = ? AND passwordHash = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $inputUser, $inputPass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login success
        $_SESSION['admin_logged_in'] = $inputUser;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $loginError = "Invalid admin username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrator Login</title>
</head>
<body>
    <h2>Admin Login Portal</h2>
    
    <?php if ($loginError) { echo "<p style='color:red;'>$loginError</p>"; } ?>

    <form method="POST" action="">
        <label>Admin Username:</label><br>
        <input type="text" name="admin_username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="admin_password" required><br><br>

        <button type="submit">Login</button>
    </form>
    
    <br>
    <a href="login.php">Back to Customer Login</a>
</body>
</html>