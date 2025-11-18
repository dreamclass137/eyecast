<?php
header("Content-Type: application/json");
include "../../connection.php";

$result = $conn->query("SELECT * FROM shape_tbl ORDER BY shape_id DESC");
$shapes = [];

while ($row = $result->fetch_assoc()) {
    $shapes[] = $row;
}

echo json_encode([
    "status" => 200,
    "data" => $shapes
]);
?>
