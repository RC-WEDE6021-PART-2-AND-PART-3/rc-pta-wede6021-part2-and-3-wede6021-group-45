<?php
session_start();
include 'DBConn.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    die("Access denied. <a href='admin_login.php'>Login as Admin</a>");
}

// Verify User Logic
if (isset($_GET['verify'])) {
    $id = $_GET['verify'];
    $conn->query("UPDATE tblUser SET isVerified = 1 WHERE userID = $id");
    echo "<p style='color:green;'>User ID $id verified successfully!</p>";
}

// Delete User Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tblUser WHERE userID = $id");
    echo "<p style='color:red;'>User ID $id deleted.</p>";
}

$result = $conn->query("SELECT * FROM tblUser");
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Admin Dashboard - Manage Customers</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['userID']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['isVerified'] ? "Verified" : "Pending"; ?></td>
            <td>
                <?php if ($row['isVerified'] == 0) { ?>
                    <a href="?verify=<?php echo $row['userID']; ?>">Verify</a> | 
                <?php } ?>
                <a href="?delete=<?php echo $row['userID']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>