<?php
header("Content-Type: application/json");
include "../../connection.php";

// Accept JSON input
$input = json_decode(file_get_contents("php://input"), true);

$s_name = $input['s_name'] ?? ($_POST['s_name'] ?? '');
$status = $input['status'] ?? ($_POST['status'] ?? 'Active');

if ($s_name == '') {
    echo json_encode(["status" => 400, "message" => "s_name is required"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO shape_tbl (s_name, status) VALUES (?, ?)");
$stmt->bind_param("ss", $s_name, $status);

if ($stmt->execute()) {
    echo json_encode([
        "status" => 200,
        "message" => "Shape added successfully",
        "shape_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["status" => 500, "message" => "Insert failed"]);
}
?>
