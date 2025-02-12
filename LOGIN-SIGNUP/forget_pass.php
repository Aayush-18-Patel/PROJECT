<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="form-gap"></div>
<div class="container" style="margin-top: 200px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Forgot Password?</h2>
                        <p>You can reset your password here.</p>
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="email address" class="form-control"
                                            type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block"
                                        value="Reset Password" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

 -->







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SHREEJI ENTERPRISE</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
</head>
<body>

    <main>
        <!-- Forgot Password Section -->
        <section id="forgot-password" class="forgot-password-section">
            <div class="container">
                <br>
                <h2>Forgot Password</h2>
                <div class="forgot-password-content">
                    <form id="forgot-password-form" action="#" method="POST">
                        <input type="email" name="email" placeholder="Enter your email address" required>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                    <div class="back-to-login">
                        <p>Remember your password? <a href="index.html">Login here</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html> 



















<?php
session_start();

include('config.php'); // Ensure this file contains database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (!isset($_POST['email']) || empty($_POST['email'])) 
    {
        die("<script>alert('No Email Found ! Plz enter your email ');;</script>");
    }

    $email = $_POST['email'];

    // jobseeker 
    $query = "SELECT * FROM jobseeker WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) 
    {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) 
    {
        die("Query execution failed: " . $conn->error);
    }


    //company
    $query1 = "SELECT * FROM companies WHERE email = ?";
    $stmt1 = $conn->prepare($query1);
    if (!$stmt1) 
    {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if (!$result1) 
    {
        die("Query execution failed: " . $conn->error);
    }

 //admin
    $query2 = "SELECT * FROM adminn WHERE email = ?";
    $stmt2 = $conn->prepare($query2);
    if (!$stmt2) 
    {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if (!$result2) 
    {
        die("Query execution failed: " . $conn->error);
    }



    if ($result->num_rows == 1) 
    {
        // Generate a new random password
        $new_password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*"), 0, 10);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the new password in the database
        $update_query = "UPDATE jobseeker SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        if (!$stmt) {
            die("Update query failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Send the new password via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
           // $mail->SMTPDebug = 2; // Debug mode enabled

            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ayushkpatel1801@gmail.com'; // Your email
            $mail->Password = 'vmowdoidexkeyzlp'; // Use App Password if 2FA enabled
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ayushkpatel@gmail.com', 'Aayush');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "<p>Your new password is: <strong>$new_password</strong></p>";

            $mail->send();
            echo "New password has been sent to your email.";
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    else if($result1->num_rows == 1)
    {
        // Generate a new random password
        $new_password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*"), 0, 10);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the new password in the database
        $update_query = "UPDATE companies SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        if (!$stmt) 
        {
            die("Update query failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Send the new password via email
        $mail = new PHPMailer(true);
        try 
        {
            $mail->isSMTP();
           // $mail->SMTPDebug = 2; // Debug mode enabled

            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ayushkpatel1801@gmail.com'; // Your email
            $mail->Password = 'vmowdoidexkeyzlp'; // Use App Password if 2FA enabled
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ayushkpatel@gmail.com', 'Aayush');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "<p>Your new password is: <strong>$new_password</strong></p>";

            $mail->send();
            echo "New password has been sent to your email.";
        } 
        catch (Exception $e) 
        {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    else if($result2->num_rows == 1)
    {
        // Generate a new random password
        $new_password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*"), 0, 10);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the new password in the database
        $update_query = "UPDATE adminn SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        if (!$stmt) 
        {
            die("Update query failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Send the new password via email
        $mail = new PHPMailer(true);
        try 
        {
            $mail->isSMTP();
           // $mail->SMTPDebug = 2; // Debug mode enabled

            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ayushkpatel1801@gmail.com'; // Your email
            $mail->Password = 'vmowdoidexkeyzlp'; // Use App Password if 2FA enabled
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ayushkpatel@gmail.com', 'Aayush');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "<p>Your new password is: <strong>$new_password</strong></p>";

            $mail->send();
            echo "New password has been sent to your email.";
        } 
        catch (Exception $e) 
        {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    else 
    {
        echo "Email not found!";
    }
    
}
?>