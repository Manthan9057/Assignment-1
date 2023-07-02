<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];
$healthReport = $_FILES['healthReport'];


$stmt = $conn->prepare("INSERT INTO user_details (name, age, weight, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $name, $age, $weight, $email);
$stmt->execute();


$userID = $stmt->insert_id;


$uploadDir = "uploads/";
$uploadedFile = $uploadDir . basename($healthReport['name']);
move_uploaded_file($healthReport['tmp_name'], $uploadedFile);


$stmt = $conn->prepare("INSERT INTO user_files (user_id, file_path) VALUES (?, ?)");
$stmt->bind_param("is", $userID, $uploadedFile);
$stmt->execute();

$stmt->close();
$conn->close();
?>
