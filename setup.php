<?php
require_once 'database.php';

try {
    // Create company table
    $pdo->exec("CREATE TABLE IF NOT EXISTS company (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        industry VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");

    // Create jobseeker table
    $pdo->exec("CREATE TABLE IF NOT EXISTS jobseeker (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        preferences VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        resume_path VARCHAR(255)
    )");

    // Create admin table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");

    echo "Tables created successfully";
} catch(PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
}
?>
