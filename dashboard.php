<?php
session_start();

// Check if the user is actually logged in, if not, redirect to login
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data stored in the session during login
$userData = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard - Clothing Store</title>
</head>
<body>
    <h2>User <?php echo htmlspecialchars($_SESSION['logged_in_user']); ?> is logged in.</h2>

    <hr>

    <h3>Welcome to your Account Dashboard</h3>
    
    <p><strong>Your Profile Details:</strong></p>
    <ul>
        <li><strong>User ID:</strong> <?php echo htmlspecialchars($userData['userID']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></li>
        <li><strong>Account Status:</strong> Verified</li>
    </ul>

    <hr>
    
    <h4>Store Options</h4>
    <ul>
        <li><a href="#">Browse Clothing Catalog</a> <em>(To be implemented)</em></li>
        <li><a href="#">View My Orders</a> <em>(To be implemented)</em></li>
    </ul>
    
    <br><br>
    <a href="logout.php"><button>Logout</button></a>

</body>
</html>