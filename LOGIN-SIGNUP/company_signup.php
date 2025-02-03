<?php
// Add this at the top to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'database.php';
    
    $name = mysqli_real_escape_string($conn, trim($_POST['company_name']));
    $industry = mysqli_real_escape_string($conn, trim($_POST['company_industry']));
    $email = mysqli_real_escape_string($conn, trim($_POST['company_email']));
    $password = password_hash($_POST['company_password'], PASSWORD_DEFAULT);

    // Check if email exists
    $checkEmail = "SELECT * FROM company WHERE LOWER(email) = LOWER('$email')";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already exists";
    } else {
        $query = "INSERT INTO company (name, industry, email, password) 
                 VALUES ('$name', '$industry', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
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
    <title>Company Signup - Flexi Recruits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php" class="back-btn"></a>
    
    <div class="container">
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <h1>Create Company Account</h1>
                
                <div class="input-row">
                    <input type="text" placeholder="Company Name" name="company_name" required />
                    <input type="text" placeholder="Industry" name="company_industry" required />
                </div>
                <input type="email" placeholder="Email" name="company_email" required />
                <input type="password" placeholder="Password" name="company_password" required />
                
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
