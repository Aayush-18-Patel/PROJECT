<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$con = new mysqli("localhost", "Ayush", "Ayush#1801@", "Flexi_Recruits");

if ($con->connect_error) {
    die("❌ Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Check if user exists in 'companies' table
    $query = "SELECT * FROM companies WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            $_SESSION['user_type'] = "company"; // Store user type
            echo "<script>window.location.href = '../COMPANY/index.html';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Incorrect Password!'); window.location.href = 'index.html';</script>";
            exit;
        }
    }

    // If not found in 'companies', check in 'jobseeker' table
    $query = "SELECT * FROM jobseeker WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            $_SESSION['user_type'] = "jobseeker"; // Store user type
            echo "<script>alert('✅ Jobseeker Login Successful!'); window.location.href = '../JOB-SEEKER/index.html';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Incorrect Password!'); window.location.href = 'index.html';</script>";
            exit;
        }
    }


    $query = "SELECT * FROM adminn WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            $_SESSION['user_type'] = "admin"; // Store user type
            echo "<script>alert('✅ Admin Login Successful!'); window.location.href = '../ADMIN/index.html';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Incorrect Password!'); window.location.href = 'index.html';</script>";
            exit;
        }
    }





    // If no match in both tables
    echo "<script>alert('❌ User not found!'); window.location.href = 'index.html';</script>";
    exit;
}
?>
