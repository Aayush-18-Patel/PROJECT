<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Configuration
$host = "localhost";
$user = "Ayush";
$password = "Ayush#1801@";
$db_name = "Flexi_Recruits";
// Connect to MySQL
$con = new mysqli($host, $user, $password);

// Check Connection
if ($con->connect_error) {
    die("❌ Connection failed: " . $con->connect_error);
}

// Create Database if not exists
$con->query("CREATE DATABASE IF NOT EXISTS $db_name");
$con->select_db($db_name);

// Create Table if not exists
$table_query = "CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$con->query($table_query);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = trim($_POST['company_name']);
    $industry = trim($_POST['industry']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if Email Exists
    $stmt = $con->prepare("SELECT * FROM companies WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('❌ Email already exists!'); window.history.back();</script>";
    } else {
        // Insert Data
        $stmt = $con->prepare("INSERT INTO companies (company_name, industry, email, name, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $company_name, $industry, $email, $name, $password);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Registration Successful! Redirecting to Login...'); window.location.href = 'index.html';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Error: " . $con->error . "'); window.history.back();</script>";
        }
    }
}
?>

