<?php
// Start the session
session_start();

// Database connection parameters
$servername = "localhost";
$dbname = "alumni"; // Replace with your database name
$dbusername = "root"; // Replace with your database username
$dbpassword = "aditya"; // Replace with your actual password

// Create connection to MySQL
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $batch_branch = $_POST['batch_branch'];
    $about = $_POST['about'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $linkedin = $_POST['linkedin'];
    $company = $_POST['company'];
    $position = $_POST['position'];
    $experience = $_POST['experience'];

    // Prepare the SQL statement for insertion
    $sql = "INSERT INTO profile (name, batch_branch, about, email, phone, linkedin, company, position, experience) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            batch_branch = VALUES(batch_branch),
            about = VALUES(about),
            email = VALUES(email),
            phone = VALUES(phone),
            linkedin = VALUES(linkedin),
            company = VALUES(company),
            position = VALUES(position),
            experience = VALUES(experience)";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssssss", $name, $batch_branch, $about, $email, $phone, $linkedin, $company, $position, $experience);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the profile page after a successful update
        header("Location: profile.html");
        exit;
    } else {
        // Handle execution errors
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
