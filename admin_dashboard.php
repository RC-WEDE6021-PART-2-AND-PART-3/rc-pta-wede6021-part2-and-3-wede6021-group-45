<?php
session_start();
include 'DBConn.php';

// Protect the dashboard: Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Verification
if (isset($_GET['verify'])) {
    $userId = intval($_GET['verify']);
    $updateSql = "UPDATE tblUser SET isVerified = 1 WHERE userID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $msg = "User successfully verified.";
}

// Handle Deletion
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $deleteSql = "DELETE FROM tblUser WHERE userID = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $msg = "User successfully deleted.";
}

// Fetch all users to display on the dashboard
$result = $conn->query("SELECT * FROM tblUser");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard: Customer Verification</h2>
    <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_logged_in']); ?></strong> | <a href="logout.php">Logout</a></p>
    
    <hr>

    <?php if (!empty($msg)) { echo "<p style='color:green;'>$msg</p>"; } ?>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; max-width: 800px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['userID']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <?php 
                    if ($row['isVerified'] == 1) {
                        echo "<span style='color:green;'>Verified</span>";
                    } else {
                        echo "<span style='color:orange; font-weight:bold;'>Pending Verification</span>";
                    }
                    ?>
                </td>
                <td>
                    <?php if ($row['isVerified'] == 0) { ?>
                        <a href="admin_dashboard.php?verify=<?php echo $row['userID']; ?>">Verify</a> | 
                    <?php } ?>
                    <a href="admin_dashboard.php?delete=<?php echo $row['userID']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>
    <a href="login.php">Return to Main Site</a>
</body>
</html>