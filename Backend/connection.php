<?php
        
// Database configuration
$host = "127.0.0.1";     // Server name or IP
$db_username = "root";      // Database username
$password = "";          // Database password
$database = "speczo_db"; // Change to your DB name

// Create connection
$conn = mysqli_connect($host, $db_username, $password, $database);
$time = date("Y-m-d H:i:s");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>