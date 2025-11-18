<?php
header("Content-Type: application/json");
include "../../connection.php";

$result = mysqli_query($conn, "SELECT category_id, c_name, status FROM category_tbl ORDER BY category_id DESC");

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => 200,
    "categories" => $data
]);
?>
