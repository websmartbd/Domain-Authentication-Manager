<?php
session_start();

// Include the configuration file
include 'config.php';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user's hashed password
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if ($hashed_password !== null && password_verify($password, $hashed_password)) {
        // Authentication successful, redirect to user table page
        $_SESSION['authenticated'] = true;
        header("Location: index.php");
        exit;
    } else {
        // Authentication failed, redirect back to login page with error message
        header("Location: login.php?error=1");
        exit;
    }
}

$conn->close();
?>
