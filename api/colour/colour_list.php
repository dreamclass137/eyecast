<?php
header("Content-Type: application/json");
include "../../connection.php";

$result = $conn->query("SELECT * FROM colour_tbl ORDER BY color_id DESC");

$colours = [];
while ($row = $result->fetch_assoc()) {
    $colours[] = $row;
}

echo json_encode([
    "status" => 200,
    "data" => $colours
]);
?>
