<?php
$servername = "localhost"; // Change if using a remote server
$username = "Ayush";       // Your MySQL username
$password = "Ayush#1801@"; // Your MySQL password
$database = "Flexi_Recruits"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
