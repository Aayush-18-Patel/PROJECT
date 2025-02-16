<?php
// Include database conection
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Insert feedback into database
    $sql = "INSERT INTO feedback (rating, comment, email) VALUES ('$rating', '$comment', '$email')";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('❌ Incorrect Password!'); window.location.href = 'index.html';</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close conection
    $con->close();
}
?>
