<?php
$host = "localhost";
$username = "Ayush";  // Your MySQL username
$password = "Ayush#1801@";  // Your MySQL password
$database = "Flexi_Recruits";  // Your database name

$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
