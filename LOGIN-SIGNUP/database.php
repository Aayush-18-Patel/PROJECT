<?php
$host = 'localhost';
$dbname = 'Flexi_Recruits';
$username = 'Ayush';
$password = 'Ayush#1801@';

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {       
    die("Connection failed: " . mysqli_connect_error());
}
?>