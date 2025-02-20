<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database conection
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Insert feedback into database
    $sql = "INSERT INTO feedback_c (rating, comment, email) VALUES ('$rating', '$comment', '$email')";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('✅ Feedback submitted successfully!'); window.location.href = 'index.html';</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close conection
    $con->close();
}
?>
