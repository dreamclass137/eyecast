<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = mysqli_real_escape_string($conn, trim($data['name'] ?? ''));
$email = mysqli_real_escape_string($conn, trim($data['email'] ?? ''));
$phone = mysqli_real_escape_string($conn, trim($data['phone'] ?? ''));
$password = mysqli_real_escape_string($conn, trim($data['password'] ?? ''));
$address = mysqli_real_escape_string($conn, trim($data['address'] ?? ''));

if ($name == "" || $email == "" || $phone == "" || $password == "" || $address == "") {
    echo json_encode([
        "status" => 400,
        "message" => "All fields are required"
    ]);
    exit;
}

// Email Exists Check
$check = mysqli_query($conn, "SELECT * FROM user_tbl WHERE email='$email' LIMIT 1");
if (mysqli_num_rows($check) > 0) {
    echo json_encode([
        "status" => 409,
        "message" => "Email already exists"
    ]);
    exit;
}

// Insert Query
$sql = "INSERT INTO user_tbl (name, email, phone, password, address, user_status)
        VALUES ('$name', '$email', '$phone', '$password', '$address', 'Active')";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Signup successful",
        "user_id" => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to signup"
    ]);
}
?>
