<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'database.php';
    
    $username = mysqli_real_escape_string($conn, trim($_POST['jobseeker_username']));
    $preferences = mysqli_real_escape_string($conn, trim($_POST['jobseeker_preferences']));
    $email = mysqli_real_escape_string($conn, trim($_POST['jobseeker_email']));
    $password = password_hash($_POST['jobseeker_password'], PASSWORD_DEFAULT);

    // Check if email exists
    $checkEmail = "SELECT * FROM jobseeker WHERE LOWER(email) = LOWER('$email')";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already exists";
    } else {
        $query = "INSERT INTO jobseeker (username, preferences, email, password) 
                 VALUES ('$username', '$preferences', '$email', '$password')";
        
        // Handle resume upload
        if (isset($_FILES['jobseeker_resume'])) {
            $upload_dir = "uploads/";
            $file_name = basename($_FILES['jobseeker_resume']['name']);
            $target_path = $upload_dir . $file_name;
            
            if (!move_uploaded_file($_FILES['jobseeker_resume']['tmp_name'], $target_path)) {
                $error = "Failed to upload resume";
            }
        }
        
        if (!isset($error) && mysqli_query($conn, $query)) {
            header("Location: index.php?success=1");
            exit();
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Seeker Signup - Flexi Recruits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php" class="back-btn">Back</a>
    
    <div class="container">
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <h1>Create Job Seeker Account</h1>
                
                <div class="input-row">
                    <input type="text" placeholder="Username" name="jobseeker_username" required />
                    <input type="text" placeholder="Job Preferences" name="jobseeker_preferences" required />
                </div>
                <input type="email" placeholder="Email" name="jobseeker_email" required />
                <input type="password" placeholder="Password" name="jobseeker_password" required />
                
                <div class="file-input-container">
                    <label for="jobseeker-resume">Upload Resume (PDF or Word document)</label>
                    <input type="file" id="jobseeker-resume" name="jobseeker_resume" accept=".pdf,.doc,.docx" required>
                </div>
                
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
