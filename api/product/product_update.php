<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['product_id'])) {
    echo json_encode(["status" => 400, "message" => "product_id is required"]);
    exit;
}

$product_id = intval($data['product_id']);
unset($data['product_id']);

if (empty($data)) {
    echo json_encode(["status" => 400, "message" => "No fields to update"]);
    exit;
}

$updateFields = [];

// Escape + prepare dynamic SQL fields
foreach ($data as $key => $value) {
    $safeKey = mysqli_real_escape_string($conn, $key);
    $safeValue = mysqli_real_escape_string($conn, $value);
    $updateFields[] = "$safeKey = '$safeValue'";
}

$updateSQL = implode(", ", $updateFields);

$sql = "UPDATE product_tbl SET $updateSQL WHERE product_id = $product_id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => 200, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Update failed"]);
}
?>
