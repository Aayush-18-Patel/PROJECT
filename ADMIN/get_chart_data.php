<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "Ayush"; // Your MySQL username
$password = "Ayush#1801@"; // Your MySQL password
$dbname = "Flexi_Recruits"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Query to fetch data separately
$jobSeekerQuery = "SELECT COUNT(*) AS job_seekers_count FROM jobseeker";
$companyQuery = "SELECT COUNT(*) AS company_count FROM companies";
$totalUsersQuery = "SELECT 
                        (SELECT COUNT(*) FROM jobseeker) + 
                        (SELECT COUNT(*) FROM companies) AS total_users";

$jobSeekerResult = $conn->query($jobSeekerQuery);
$companyResult = $conn->query($companyQuery);
$totalUsersResult = $conn->query($totalUsersQuery);

// Check if query execution failed
if (!$jobSeekerResult || !$companyResult || !$totalUsersResult) {
    die(json_encode(["error" => "SQL Error: " . $conn->error]));
}

$jobSeekers = ($jobSeekerResult->num_rows > 0) ? $jobSeekerResult->fetch_assoc()['job_seekers_count'] : 0;
$companies = ($companyResult->num_rows > 0) ? $companyResult->fetch_assoc()['company_count'] : 0;
$totalUsers = ($totalUsersResult->num_rows > 0) ? $totalUsersResult->fetch_assoc()['total_users'] : 0;

// Send JSON response
header('Content-Type: application/json');
echo json_encode([
    'users' => $totalUsers,
    'companies' => $companies,
    'job_seekers' => $jobSeekers
]);

$conn->close();
?>
