<?php
        
// Database configuration
$host = "127.0.0.1";     // Server name or IP
$username = "root";      // Database username
$password = "";          // Database password
$database = "eye_db"; // Change to your DB name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);
$time = date("Y-m-d H:i:s");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>