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
if ($con->connect_error) {
    die("❌ Connection failed: " . $con->connect_error);
}

// Create Table if not exists
$table_query = "CREATE TABLE IF NOT EXISTS jobseeker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    file VARCHAR(255) NOT NULL
)";
$con->query($table_query);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if Email Exists
    $stmt = $con->prepare("SELECT * FROM jobseeker WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("<script>alert('❌ Email already exists!'); window.history.back();</script>");
    }

    $stmt1 = $con->prepare("SELECT * FROM companies WHERE email = ?");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        die("<script>alert('❌ Email already exists!'); window.history.back();</script>");
    }

    // File Upload Handling
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['resume']['name']);
        $file_tmp = $_FILES['resume']['tmp_name'];

        // Upload Directory (relative path)
        $upload_dir = "upload/";
        $file_destination = $upload_dir . $file_name;

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($file_tmp, $file_destination)) {
            echo "<p style='color: green;'>✅ File uploaded successfully!</p>";
        } else {
            die("<p style='color: red;'>❌ Failed to upload file. Check folder permissions.</p>");
        }
    } else {
        die("<p style='color: red;'>❌ No file uploaded or file error occurred.</p>");
    }

    // Insert Data into Database
    $stmt = $con->prepare("INSERT INTO jobseeker (name, email, password, file) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $file_destination);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registration Successful! Redirecting to Login...'); window.location.href = 'index.html';</script>";
        exit;
    } else {
        die("❌ Error: " . $con->error);
    }
}
?>
