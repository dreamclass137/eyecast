<?php
header("Content-Type: application/json");
include "../../connection.php";

$input = json_decode(file_get_contents("php://input"), true);

$color_id = $input['color_id'] ?? ($_POST['color_id'] ?? 0);

if ($color_id == 0) {
    echo json_encode(["status" => 400, "message" => "color_id is required"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM colour_tbl WHERE color_id=?");
$stmt->bind_param("i", $color_id);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Colour deleted successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete failed"]);
}
?>
