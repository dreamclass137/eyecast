<?php
header("Content-Type: application/json");
include "../../connection.php";

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);

$shape_id = $input['shape_id'] ?? ($_POST['shape_id'] ?? 0);

if ($shape_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "shape_id is required"
    ]);
    exit;
}

// Convert to integer (security)
$shape_id = intval($shape_id);

// SQL DELETE Query (NO prepare)
$sql = "DELETE FROM shape_tbl WHERE shape_id = $shape_id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => 200, "message" => "Shape deleted successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete failed"]);
}
?>
