<?php
header("Content-Type: application/json");
include "../../connection.php";

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);

$color_name = $input['color_name'] ?? ($_POST['color_name'] ?? '');
$color_code = $input['color_code'] ?? ($_POST['color_code'] ?? '');

if ($color_name == '' || $color_code == '') {
    echo json_encode(["status" => 400, "message" => "color_name and color_code are required"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO colour_tbl (color_name, color_code) VALUES (?, ?)");
$stmt->bind_param("ss", $color_name, $color_code);

if ($stmt->execute()) {
    echo json_encode([
        "status" => 200,
        "message" => "Colour added successfully",
        "color_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["status" => 500, "message" => "Insert failed"]);
}
?>
