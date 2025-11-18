<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['product_id'])) {
    echo json_encode(["status" => 400, "message" => "product_id is required"]);
    exit;
}

$product_id = $data['product_id'];
unset($data['product_id']);

$fields = "";
$params = [];
$types = "";

foreach ($data as $key => $value) {
    $fields .= "$key = ?, ";
    $params[] = $value;
    $types .= "s"; // all string type
}

$fields = rtrim($fields, ", ");
$sql = "UPDATE product_tbl SET $fields WHERE product_id = ?";
$params[] = $product_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Update failed"]);
}
?>
