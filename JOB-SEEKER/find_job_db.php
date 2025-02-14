<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php'); // Ensure this contains the correct database connection ($con)

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    echo "Form received via POST request.<br>";

    // Check if database connection exists
    if (!isset($con) || !$con) {
        die("❌ Database connection failed. Please check config.php.");
    }

    // Sanitize input data
    $full_name = mysqli_real_escape_string($con, $_POST['full-name'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($con, $_POST['phone'] ?? '');
    $location = mysqli_real_escape_string($con, $_POST['location'] ?? ''); // Fixed variable name
    $job_title = mysqli_real_escape_string($con, $_POST['job-title'] ?? '');
    $experience = mysqli_real_escape_string($con, $_POST['experience'] ?? '');
    $skills = mysqli_real_escape_string($con, $_POST['skills'] ?? '');

    echo "Full Name: $full_name, Email: $email, Phone: $phone<br>";

    // File Upload Handling
    $resume_path = ''; // Default empty resume path

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['resume']['name']);
        $file_tmp = $_FILES['resume']['tmp_name'];

        // Upload Directory
        $upload_dir = "/var/www/html/FLEXI-RECRUITS/JOB-SEEKER/upload/";
        $file_destination = $upload_dir . $file_name;

        // Move uploaded file
        if (move_uploaded_file($file_tmp, $file_destination)) {
            echo "<p style='color: green;'>✅ File uploaded successfully!</p>";
            $resume_path = $file_destination; // Save the path for database entry
        } else {
            die("<p style='color: red;'>❌ Failed to upload file. Check folder permissions.</p>");
        }
    } else {
        die("<p style='color: red;'>❌ No file uploaded or file error occurred.</p>");
    }

    // Insert Data into Database
    $stmt = $con->prepare("INSERT INTO job_applications (full_name, email, phone, location, job_title, experience, skills, resume_path) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $full_name, $email, $phone, $location, $job_title, $experience, $skills, $resume_path);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registration Successful! Redirecting to Home...'); window.location.href = 'index.html';</script>";
        exit;
    } else {
        die("❌ Error: " . $con->error);
    }
}
?>
