<?php
include 'database.php';  // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_type = $_POST['account_type'];
    
    if ($account_type === 'company') {
        // Handle company signup
        $name = mysqli_real_escape_string($conn, trim($_POST['company_name']));
        $industry = mysqli_real_escape_string($conn, trim($_POST['company_industry']));
        $email = mysqli_real_escape_string($conn, trim($_POST['company_email']));
        $password = password_hash($_POST['company_password'], PASSWORD_DEFAULT);

        // Check if email exists
        $checkEmail = "SELECT * FROM company WHERE LOWER(email) = LOWER('$email')";
        $result = mysqli_query($conn, $checkEmail);

        if (mysqli_num_rows($result) > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            exit();
        }

        $query = "INSERT INTO company (name, industry, email, password) 
                 VALUES ('$name', '$industry', '$email', '$password')";

    } else {
        // Handle jobseeker signup
        $username = mysqli_real_escape_string($conn, trim($_POST['jobseeker_username']));
        $preferences = mysqli_real_escape_string($conn, trim($_POST['jobseeker_preferences']));
        $email = mysqli_real_escape_string($conn, trim($_POST['jobseeker_email']));
        $password = password_hash($_POST['jobseeker_password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO jobseeker (username, preferences, email, password) 
                 VALUES ('$username', '$preferences', '$email', '$password')";
        
        // Handle resume upload
        if (isset($_FILES['jobseeker_resume'])) {
            $upload_dir = "uploads/";
            $file_name = basename($_FILES['jobseeker_resume']['name']);
            $target_path = $upload_dir . $file_name;
            
            if (!move_uploaded_file($_FILES['jobseeker_resume']['tmp_name'], $target_path)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload resume']);
                exit();
            }
        }
    }

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . mysqli_error($conn)]);
    }
}
?>
