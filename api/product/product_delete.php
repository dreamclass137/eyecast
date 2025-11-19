<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['product_id'])) {
    echo json_encode(["status" => 400, "message" => "product_id is required"]);
    exit;
}

// Secure integer ID
$product_id = intval($data['product_id']);

// SQL DELETE query
$sql = "DELETE FROM product_tbl WHERE product_id = $product_id";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => 200, "message" => "Product deleted successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete failed"]);
}
?>
