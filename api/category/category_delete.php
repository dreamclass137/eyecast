<?php
header("Content-Type: application/json");
include('../../connection.php');  // your MySQL connection

// Read JSON Input
$data = json_decode(file_get_contents("php://input"), true);

$category_id = $data['category_id'] ?? '';

if ($category_id == "") {
    echo json_encode([
        "status" => 400,
        "message" => "category_id missing"
    ]);
    exit;
}

// DELETE Query (NO PREPARE)
$sql = "DELETE FROM category_tbl WHERE category_id = $category_id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode([
        "status" => 200,
        "message" => "Category Deleted Successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Delete Failed"
    ]);
}
?>
