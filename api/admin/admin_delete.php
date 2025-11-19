<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$admin_id = intval($data['admin_id'] ?? 0);

if ($admin_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "admin_id is required"
    ]);
    exit;
}

// Check if admin exists
$check = mysqli_query($conn, "SELECT * FROM admin_tbl WHERE admin_id='$admin_id'");
if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "Admin not found"
    ]);
    exit;
}

// Delete admin
$sql = "DELETE FROM admin_tbl WHERE admin_id='$admin_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Admin deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to delete admin"
    ]);
}
?>
