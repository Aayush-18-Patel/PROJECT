<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database connection details
$servername = "localhost";  
$username = "Ayush";    
$password = "Ayush#1801@";     
$dbname = "Flexi_Recruits";       

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job-title']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
echo "hii";
    // Handle file upload (assuming file upload path is '/var/www/html/FLEXI-RECRUITS/LOGIN-SIGNUP/uploads/')
    $upload_dir = '/var/www/html/FLEXI-RECRUITS/LOGIN-SIGNUP/uploads/';
    $resume_path = $upload_dir . basename($_FILES['resume']['name']);
    if (move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
        // Insert data into the database
        $sql = "INSERT INTO job_applications (full_name, email, phone, location, job_title, experience, skills, resume_path) 
                VALUES ('$full_name', '$email', '$phone', '$location', '$job_title', '$experience', '$skills', '$resume_path')";

        if ($conn->query($sql) === TRUE) {
            echo "Application submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading resume.";
    }
}

// Close connection
$conn->close();
?>
