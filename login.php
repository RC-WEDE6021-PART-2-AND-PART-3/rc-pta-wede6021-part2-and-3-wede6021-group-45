<?php
session_start();
include 'DBConn.php';

$loginError = "";
$inputUser = "";
$inputEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST['username'];
    $inputEmail = $_POST['email'];
    // For educational matching to the assignment's MD5 example. 
    // Real world note: ALWAYS use password_hash() and password_verify() instead of MD5.
    $inputPass = md5($_POST['password']); 

    $sql = "SELECT * FROM tblUser WHERE username = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $inputUser, $inputEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Associative read
        
        if ($row['passwordHash'] === $inputPass) {
            if ($row['isVerified'] == 1) {
                $_SESSION['logged_in_user'] = $row['username'];
                $_SESSION['user_data'] = $row;
                // Add this redirect line right here:
                header("Location: dashboard.php");
                exit();
            } else {
                $loginError = "Account pending verification by Administrator.";
            }
        } else {
            $loginError = "Incorrect password.";
        }
    } else {
        $loginError = "User does not exist. Please <a href='register.php'>register here</a>.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Clothing Store Login</title></head>
<body>
  
    ?>
        <h2>Login</h2>
        <?php if($loginError) echo "<p style='color:red;'>$loginError</p>"; ?>
        
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required value="<?php echo htmlspecialchars($inputUser); ?>"><br><br>
            
            <label>Email:</label>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($inputEmail); ?>"><br><br>
            
            <label>Password:</label>
            <input type="password" name="password" required><br><br>
            
            <button type="submit">Login</button>
        </form>
        <br>
        <a href="admin_login.php">Admin Login</a> | <a href="register.php">Register</a>
  
</body>
</html>