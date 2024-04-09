<?php

// Check if accessed directly
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: index.php");
    exit;
}

// Database configuration
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'liscens';
?>
