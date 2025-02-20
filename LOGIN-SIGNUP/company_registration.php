<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Configuration
$host = "localhost";
$user = "Ayush";
$password = "Ayush#1801@";
$db_name = "Flexi_Recruits";

// Connect to MySQL
$con = new mysqli($host, $user, $password, $db_name);

// Check Connection
if ($con->connect_error) {
    die("❌ Connection failed: " . $con->connect_error);
}

// Create Table if not exists
$table_query = "CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
$con->query($table_query);

// Check if session variables are set
if (!isset($_SESSION['company_email'], $_SESSION['company_password'], $_SESSION['company_name'], $_SESSION['company_industry'])) {
    echo "<script>alert('❌ All fields are required!'); window.history.back();</script>";
    exit;
}

// Get session values
$email = $_SESSION['company_email'];
$password = password_hash($_SESSION['company_password'], PASSWORD_BCRYPT);
$company_name = $_SESSION['company_name'];
$industry = $_SESSION['company_industry'];

// Check if Email Exists in `companies`
$stmt = $con->prepare("SELECT * FROM companies WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$num_rows_companies = $result->num_rows;
$stmt->close();

// Check if Email Exists in `jobseeker`
$stmt1 = $con->prepare("SELECT * FROM jobseeker WHERE email = ?");
$stmt1->bind_param("s", $email);
$stmt1->execute();
$result1 = $stmt1->get_result();
$num_rows_jobseeker = $result1->num_rows;
$stmt1->close();

// Debugging: Check the row counts
var_dump($num_rows_companies, $num_rows_jobseeker);

if ($num_rows_companies > 0 || $num_rows_jobseeker > 0) {
    echo "<script>alert('❌ Email already exists!');  window.location.href = 'index.html';</script>";
} else {
    // Insert Data
    $stmt2 = $con->prepare("INSERT INTO companies (company_name, industry, email, password) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $company_name, $industry, $email, $password);

    if ($stmt2->execute()) {
        echo "<script>alert('✅ Registration Successful! Redirecting to Login...'); window.location.href = 'index.html';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Error: " . $stmt2->error . "'); window.history.back();</script>";
    }
    $stmt2->close();
}
?>
