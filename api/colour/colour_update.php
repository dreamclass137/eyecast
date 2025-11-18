<?php
header("Content-Type: application/json");
include "../../connection.php";

// JSON + POST support
$input = json_decode(file_get_contents("php://input"), true);

$color_id   = $input['color_id'] ?? ($_POST['color_id'] ?? 0);
$color_name = $input['color_name'] ?? ($_POST['color_name'] ?? '');
$color_code = $input['color_code'] ?? ($_POST['color_code'] ?? '');

if ($color_id == 0 || $color_name == '' || $color_code == '') {
    echo json_encode([
        "status" => 400,
        "message" => "color_id, color_name and color_code are required"
    ]);
    exit;
}

$stmt = $conn->prepare("UPDATE colour_tbl SET color_name=?, color_code=? WHERE color_id=?");
$stmt->bind_param("ssi", $color_name, $color_code, $color_id);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Colour updated successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Update failed"]);
}
?>
