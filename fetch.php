<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];


$stmt = $conn->prepare("SELECT file_path FROM user_files JOIN user_details ON user_files.user_id = user_details.id WHERE user_details.email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($filePath);
$stmt->fetch();
$stmt->close();


header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=health_report.pdf");
readfile($filePath);

$conn->close();
?>
