<?php
header('Content-Type: application/json');
include('../../connection.php');

$data = json_decode(file_get_contents("php://input"), true);

$category_id = $data['category_id'] ?? '';

if ($category_id == '') {
    echo json_encode(["status" => 400, "message" => "category_id missing"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM category_tbl WHERE category_id=?");
$stmt->bind_param("i", $category_id);

if ($stmt->execute()) {
    echo json_encode(["status" => 200, "message" => "Category Deleted"]);
} else {
    echo json_encode(["status" => 500, "message" => "Delete Failed"]);
}
?>
