<?php
// Start the session
session_start();

// Database connection parameters
$servername = "localhost";
$dbname = "alumni";
$dbusername = "root";
$dbpassword = "aditya"; // Replace with your actual password

// Create connection to MySQL
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    echo("Not connected!!");
    die("Connection failed: " . $conn->connect_error);
}
echo("Connected!!");

// Function to validate input data
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $Name = validate_input($_POST['name']);
    $email = validate_input($_POST['Email']);
    $Password = validate_input($_POST['Password']);

    // Check if any field is empty
    if (empty($Name) || empty($email) || empty($Password)) {
        echo "All fields are required.";
    } else {
        // Check if user is already registered
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // User is already registered, display popup message
            echo "<script>alert('User already registered!');</script>";
        } else {
            // Hash the password for security
            //$hashed_password = password_hash($Password, PASSWORD_DEFAULT);

            // Insert user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $Name, $email, $Password);

            if ($stmt->execute()) {
                echo "Registration successful!";
                // Redirect to login page after successful registration
                http_response_code(302);
                header("Location: index.html");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>