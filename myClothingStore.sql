CREATE DATABASE IF NOT EXISTS ClothingStore;
USE ClothingStore;

-- Drop tables if they exist to allow clean recreation
DROP TABLE IF EXISTS tblAorder;
DROP TABLE IF EXISTS tblClothes;
DROP TABLE IF EXISTS tblUser;
DROP TABLE IF EXISTS tblAdmin;

-- Create Base Tables
CREATE TABLE tblAdmin (
    adminID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    passwordHash VARCHAR(255) NOT NULL
);

CREATE TABLE tblUser (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    isVerified TINYINT(1) DEFAULT 0 -- 0 = Pending, 1 = Verified
);

CREATE TABLE tblClothes (
    clothID INT AUTO_INCREMENT PRIMARY KEY,
    itemName VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stockQty INT NOT NULL
);

CREATE TABLE tblAorder (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    clothID INT NOT NULL,
    orderDate DATE NOT NULL,
    FOREIGN KEY (userID) REFERENCES tblUser(userID),
    FOREIGN KEY (clothID) REFERENCES tblClothes(clothID)
);

-- Insert dummy admin (password: admin123 hashed in MD5 for this example)
INSERT INTO tblAdmin (username, passwordHash) VALUES ('admin', '0192023a7bbd73250516f069df18b500');