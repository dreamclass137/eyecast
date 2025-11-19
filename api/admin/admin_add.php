<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = mysqli_real_escape_string($conn, trim($data['username'] ?? ''));
$email = mysqli_real_escape_string($conn, trim($data['email'] ?? ''));
$password = mysqli_real_escape_string($conn, trim($data['password'] ?? ''));

// Required field check
if ($username == "" || $email == "" || $password == "") {
    echo json_encode([
        "status" => 400,
        "message" => "username, email and password are required"
    ]);
    exit;
}

// Check if email already exists
$check_sql = "SELECT * FROM admin_tbl WHERE email='$email' LIMIT 1";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode([
        "status" => 409,
        "message" => "Email already exists"
    ]);
    exit;
}

// Insert admin (your table uses plain password)
$insert_sql = "INSERT INTO admin_tbl (username, email, password) 
               VALUES ('$username', '$email', '$password')";

if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Admin added successfully",
        "admin_id" => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to add admin"
    ]);
}
?>
