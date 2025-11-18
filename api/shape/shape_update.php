<?php
header("Content-Type: application/json");
include "../../connection.php";

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);

$shape_id = $input['shape_id'] ?? ($_POST['shape_id'] ?? 0);
$s_name   = $input['s_name'] ?? ($_POST['s_name'] ?? '');
$status   = $input['status'] ?? ($_POST['status'] ?? 'Active');

if ($shape_id == 0 || $s_name == '') {
    echo json_encode([
        "status" => 400,
        "message" => "shape_id and s_name are required"
    ]);
    exit;
}

$stmt = $conn->prepare("UPDATE shape_tbl SET s_name = ?, status = ? WHERE shape_id = ?");
$stmt->bind_param("ssi", $s_name, $status, $shape_id);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Shape updated successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Update failed"]);
}
?>
