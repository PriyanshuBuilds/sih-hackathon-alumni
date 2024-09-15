<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = 'aditya';
$db_name = 'alumni';

// Connect to database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email and password from form submission
$email = $_POST['email'];
$password = $_POST['password'];

// Query to check if email and password are correct
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if query returned any results
if ($result->num_rows > 0) {
    // Email and password are correct, log in user
    session_start();
    $_SESSION['user_email'] = $email;
    header('Location: loggedpage.html');
    exit;
} else {
    header('Location: logError.html');
}

// Close database connection
$conn->close();
?>