<?php
session_start();

// Database Connection
$host = 'localhost';
$dbname = 'Flexi_Recruits';
$username = 'Ayush';
$password = 'Ayush#1801@';
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form fields are set
$account_type = isset($_POST['account_type']) ? strtolower(trim($_POST['account_type'])) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;

// Validate input
if (!$account_type || !$email || !$password) {
    die("Error: Missing required fields.");
}

// Sanitize input
$email = mysqli_real_escape_string($conn, $email);

// Select table based on account type
if ($account_type === "admin") {
    $query = "SELECT * FROM admin WHERE username='$email'";
} elseif ($account_type === "company") {
    $query = "SELECT * FROM company WHERE email='$email'";
} elseif ($account_type === "jobseeker") {
    $query = "SELECT * FROM jobseekers WHERE email='$email'";
} else {
    die("Invalid account type.");
}

// Execute query
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if user exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Verify password (if stored using password_hash)
    if (password_verify($password, $row['password'])) {  
        $_SESSION['user'] = $row;
        echo "Login successful!";
    } else {
        echo "Invalid credentials.";
    }
} else {
    echo "Invalid credentials.";
}

// Close connection
mysqli_close($conn);
?>
