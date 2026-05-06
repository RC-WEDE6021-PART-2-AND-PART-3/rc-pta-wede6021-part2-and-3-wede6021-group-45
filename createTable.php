<?php
include 'DBConn.php';

// Drop and Recreate tblUser
$sqlDrop = "DROP TABLE IF EXISTS tblUser";
$conn->query($sqlDrop);

$sqlCreate = "CREATE TABLE tblUser (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    isVerified TINYINT(1) DEFAULT 1
)";
if ($conn->query($sqlCreate) === TRUE) {
    echo "Table tblUser created successfully.<br>";
}

// Read from userData.txt and insert
$file = fopen("userData.txt", "r");
if ($file) {
    while (($line = fgets($file)) !== false) {
        $data = explode(",", trim($line));
        if (count($data) == 3) {
            $user = $conn->real_escape_string($data[0]);
            $email = $conn->real_escape_string($data[1]);
            $hash = $conn->real_escape_string($data[2]);
            
            $sqlInsert = "INSERT INTO tblUser (username, email, passwordHash, isVerified) VALUES ('$user', '$email', '$hash', 1)";
            $conn->query($sqlInsert);
        }
    }
    fclose($file);
    echo "Data loaded from userData.txt successfully.<br>";
} else {
    echo "Error opening userData.txt.";
}
$conn->close();
?>