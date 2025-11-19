<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$admin_id = intval($data['admin_id'] ?? 0);
$username = mysqli_real_escape_string($conn, trim($data['username'] ?? ''));
$email = mysqli_real_escape_string($conn, trim($data['email'] ?? ''));
$password = mysqli_real_escape_string($conn, trim($data['password'] ?? ''));

if ($admin_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "admin_id is required"
    ]);
    exit;
}

// Check admin exists
$check = mysqli_query($conn, "SELECT * FROM admin_tbl WHERE admin_id='$admin_id'");
if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "Admin not found"
    ]);
    exit;
}

// Build Update Query
$update_fields = [];

if ($username != "") $update_fields[] = "username='$username'";
if ($email != "") $update_fields[] = "email='$email'";
if ($password != "") $update_fields[] = "password='$password'";

if (empty($update_fields)) {
    echo json_encode([
        "status" => 400,
        "message" => "No fields to update"
    ]);
    exit;
}

$update_sql = "UPDATE admin_tbl SET " . implode(", ", $update_fields) . " WHERE admin_id='$admin_id'";

if (mysqli_query($conn, $update_sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Admin updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to update admin"
    ]);
}
?>
