<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$host = 'localhost';
$dbname = 'Flexi_Recruits';
$username = 'Ayush';
$password = 'Ayush#1801@';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Handle company registration
 if (isset($_POST['signup-company-btn'])) 
{
    $name = mysqli_real_escape_string($conn, trim($_POST['company_name']));
    $industry = mysqli_real_escape_string($conn, trim($_POST['company_industry']));
    $email = mysqli_real_escape_string($conn, trim($_POST['company_email']));
    $password = password_hash($_POST['company_password'], PASSWORD_DEFAULT);
    // Check if the email is empty
    if (empty($email)) {
        echo "Error: Email field is empty.";
        exit();
    }

    // Make the email check case-insensitive and remove leading/trailing spaces
    $checkEmailQuery = "SELECT * FROM company WHERE LOWER(email) = LOWER('$email')";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) 
    {
        echo "Error: Email already exists.";
    } else 
    {
        // Proceed with the insertion
        $query = "INSERT INTO company (name, industry, email, password) VALUES ('$name', '$industry', '$email', '$password')";

        if (mysqli_query($conn, $query)) 
        {
            echo "Company registered successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


 
    // Handle job seeker registration
    elseif (isset($_POST['signup-jobseeker-btn'])) 
    {
        $j_username = mysqli_real_escape_string($conn, trim($_POST['jobseeker_username']));
        $j_preferences = mysqli_real_escape_string($conn, trim($_POST['jobseeker_preferences']));
        $j_email = mysqli_real_escape_string($conn, trim($_POST['jobseeker_email']));
        $j_password = password_hash($_POST['jobseeker_password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO jobseeker (username, preferences, email, password) VALUES ('$j_username', '$j_preferences', '$j_email', '$j_password')";

        if (mysqli_query($conn, $query)) 
        {
            echo "Job seeker registered successfully.";
        } 
        else 
        {
            echo "Error: " . mysqli_error($conn);
        }

        // Handle file upload
        if (isset($_FILES['jobseeker_resume'])) 
        {
            $PATH = "/var/www/html/FLEXI-RECRUITS/LOGIN-SIGNUP/uploads/";
            $PATH = $PATH . basename($_FILES['jobseeker_resume']['name']);
    
            if (move_uploaded_file($_FILES['jobseeker_resume']['tmp_name'], $PATH)) 
            {
                echo "Resume uploaded successfully.";
            } 
            else 
            {
                echo "Error uploading resume.";
            }
        }
    } 
    else 
    {
        echo "Invalid account type.";
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}

mysqli_close($conn);
?>
