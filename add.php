<?php
session_start();

// Include the configuration file
include 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Redirect to login page if user is not authenticated
    header("Location: index.php");
    exit;
}
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $email = $_POST['email'];
    $domain = $_POST['domain'];

    // Insert new data into the database
    $insert_sql = "INSERT INTO allowed_domains (email, domain) VALUES ('$email', '$domain')";
    if ($conn->query($insert_sql) === TRUE) {
        // Redirect to user table page after successful insertion
        header("Location: index.php");
        exit;
    } else {
        echo "Error adding record: " . $conn->error;
    }
}
?>
