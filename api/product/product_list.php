<?php
header('Content-Type: application/json');
include '../../connection.php';

$sql = "SELECT * FROM product_tbl ORDER BY product_id DESC";
$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "status" => 200,
    "data" => $products
]);
?>
