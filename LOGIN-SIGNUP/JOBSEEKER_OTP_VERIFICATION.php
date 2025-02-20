<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('config.php');
    $action = $_POST['action'];
    $email = $_POST['js_email'] ?? '';  // Fix: Use null-coalescing to avoid undefined error
    $password = $_POST['js_password'] ?? '';
    $name = $_POST['js_name'] ?? '';
    
    if (empty($email)) {
        echo "<span style='color:red;'>Please enter your email.</span>";
        exit;
    }

    if ($action == "generate" || $action == "resend") {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ayushkpatel1801@gmail.com';
            $mail->Password = 'vmowdoidexkeyzlp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ayushkpatel1801@gmail.com', 'Aayush');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Your OTP Verification Code";
            $mail->Body = "<p>Your OTP is: <strong>$otp</strong></p>";

            $mail->send();
            echo ($action == "resend") ? "OTP Resent" : "OTP Sent";
        } catch (Exception $e) {
            echo "<span style='color:red;'>Error sending email: {$mail->ErrorInfo}</span>";
        }
        exit;
    }

    if ($action == "verify") {
        $entered_otp = $_POST['otp'];

        if ($_SESSION['otp'] == $entered_otp && $_SESSION['otp_email'] == $email) {
            unset($_SESSION['otp']);
            unset($_SESSION['otp_email']);
            echo "success";
        } else {
            echo "<span style='color:red;'>Invalid OTP! Please try again.</span>";
        }
        exit;
    }
}

// Set session variables after form submission
$_SESSION['js_name'] = $_POST['js_name'];
$_SESSION['js_email'] = $_POST['js_email'];
$_SESSION['js_password'] = $_POST['js_password'];
$_SESSION['js_preference'] = $_POST['js_preference'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        * { box-sizing: border-box; }
        body {
            background: #f6f5f7;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
        }
        h2 { color: #333; }
        input {
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            margin-bottom: 15px;
        }
        button {
            padding: 12px;
            background-color: #005F69;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        button:hover { background: #004A52; }
        .otp-input, #resend-otp { display: none; }
        .message { font-weight: bold; margin-top: 10px; color: red; }
        #resend-otp {
            color: #007BFF;
            cursor: pointer;
            margin-top: 10px;
        }
        #resend-otp:hover { text-decoration: underline; }
    </style>
    <script>
        function sendOTP(action = "generate") {
            let email = document.getElementById("email").value;
            let generateButton = document.getElementById("generate-otp");

            if (!email) {
                document.getElementById("message").innerText = "Please enter your email.";
                return;
            }
            generateButton.disabled = true;
            generateButton.innerText = "Please wait...";

            let formData = new FormData();
            formData.append("action", action);
            formData.append("js_email", email);

            fetch("", { method: "POST", body: formData })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "OTP Sent") {
                        document.getElementById("generate-otp").style.display = "none";
                        document.getElementById("otp").style.display = "block";
                        document.getElementById("verify-btn").style.display = "block";
                        document.getElementById("resend-otp").style.display = "block";
                        document.getElementById("message").innerText = "OTP has been sent to your email.";
                        document.getElementById("message").style.color = "green";
                    } else {
                        document.getElementById("message").innerHTML = data;
                    }
                })
                .finally(() => {
                    setTimeout(() => {
                        generateButton.disabled = false;
                        generateButton.innerText = "Generate OTP";
                    }, 5000);
                });
        }
        function verifyOTP() {
            let email = document.getElementById("email").value;
            let otp = document.getElementById("otp").value;

            if (!otp) {
                document.getElementById("message").innerText = "Please enter the OTP.";
                return;
            }

            let formData = new FormData();
            formData.append("action", "verify");
            formData.append("js_email", email);
            formData.append("otp", otp);

            fetch("", { method: "POST", body: formData })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        alert("Verification Completed!");
                        window.location.href = "../LOGIN-SIGNUP/jobseeker_registration.php";
                    } else {
                        document.getElementById("message").innerHTML = data;
                    }
                });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <input type="email" id="email"
            value="<?php echo isset($_POST['js_email']) ? $_POST['js_email'] : ''; ?>" readonly>
        <button id="generate-otp" type="button" onclick="sendOTP()">Generate OTP</button>
        <input type="text" id="otp" class="otp-input" placeholder="Enter OTP">
        <button type="button" id="verify-btn" class="otp-input" onclick="verifyOTP()">Verify OTP</button>
        <p id="resend-otp" onclick="sendOTP('resend')">Didn't receive OTP? Send again</p>
        <p id="message" class="message"></p>
    </div>
</body>
</html>