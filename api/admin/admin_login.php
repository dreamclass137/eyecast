<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = mysqli_real_escape_string($conn, trim($data['username'] ?? ''));
$password = mysqli_real_escape_string($conn, trim($data['password'] ?? ''));

if ($username == "" || $password == "") {
    echo json_encode([
        "status" => 400,
        "message" => "username and password are required"
    ]);
    exit;
}

$sql = "SELECT * FROM admin_tbl WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "Admin not found"
    ]);
    exit;
}

$row = mysqli_fetch_assoc($result);

// Normal text password check (your table stores plain password)
if ($row['password'] !== $password) {
    echo json_encode([
        "status" => 401,
        "message" => "Invalid password"
    ]);
    exit;
}

// SUCCESS
echo json_encode([
    "status" => 200,
    "message" => "Login successful",
    "admin" => [
        "admin_id" => $row['admin_id'],
        "username" => $row['username'],
        "email" => $row['email']
    ]
]);
?>
