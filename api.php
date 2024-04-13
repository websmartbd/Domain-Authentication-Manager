<?php

// Include the configuration file
include 'admin/config.php';

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve domain, message, and active status from the database using prepared statement
$sql = "SELECT domain, active, message FROM allowed_domains";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error preparing SQL statement: " . mysqli_error($conn));
}

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $domain, $active, $message);

// Create an array to store allowed domains, messages, and active status
$allowed_data = array();

// Fetch allowed domains, messages, and active status from the result set
while (mysqli_stmt_fetch($stmt)) {
    $allowed_data[] = array(
        'domain' => $domain,
        'active' => $active,
        'message' => $message
    );
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);

// Set headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Output allowed domains, messages, and active status as JSON
echo json_encode($allowed_data);
?>
