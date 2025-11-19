<?php
header("Content-Type: application/json");
include "../../connection.php";

$input = json_decode(file_get_contents("php://input"), true);

$color_id = $input['color_id'] ?? ($_POST['color_id'] ?? 0);

if ($color_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "color_id is required"
    ]);
    exit;
}

// Convert to integer for safety
$color_id = intval($color_id);

// SQL DELETE query (no prepare)
$sql = "DELETE FROM colour_tbl WHERE color_id = $color_id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => 200, "message" => "Colour deleted successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete failed"]);
}
?>
