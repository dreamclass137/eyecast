<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "eye_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die(json_encode(["status" => 500, "message" => "Database connection failed"]));
}
?>
