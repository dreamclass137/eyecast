<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['product_id'])) {
    echo json_encode(["status" => 400, "message" => "product_id is required"]);
    exit;
}

$id = $data['product_id'];

$stmt = $conn->prepare("DELETE FROM product_tbl WHERE product_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Product deleted successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete failed"]);
}
?>
