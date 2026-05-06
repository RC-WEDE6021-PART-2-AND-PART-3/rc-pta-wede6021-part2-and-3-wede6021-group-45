<?php
include 'DBConn.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // Using MD5 as per the assignment's hash example

    $sql = "INSERT INTO tblUser (username, email, passwordHash, isVerified) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $email, $pass);
    
    if ($stmt->execute()) {
        $msg = "Registration successful! Status: Pending until Administrator verification.";
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Register New Customer</h2>
    <p style="color:green;"><?php echo $msg; ?></p>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <br><a href="login.php">Back to Login</a>
</body>
</html>