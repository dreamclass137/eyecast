<?php
header("Content-Type: application/json");
include "connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$category_id = intval($data['category_id'] ?? 0);
$c_name = mysqli_real_escape_string($conn, trim($data['c_name'] ?? ''));
$status = mysqli_real_escape_string($conn, trim($data['status'] ?? ''));

if ($category_id == 0 || $c_name == "" || $status == "") {
    echo json_encode(["status" => 400, "message" => "All fields required"]);
    exit;
}

if ($status != "Active" && $status != "Inactive") {
    echo json_encode(["status" => 400, "message" => "Invalid status"]);
    exit;
}

// duplicate check
$check = mysqli_query($conn, "
    SELECT * FROM category_tbl 
    WHERE c_name='$c_name' AND category_id!=$category_id
");

if (mysqli_num_rows($check) > 0) {
    echo json_encode(["status" => 409, "message" => "Category name already exists"]);
    exit;
}

$q = mysqli_query($conn, "
    UPDATE category_tbl SET 
        c_name='$c_name',
        status='$status'
    WHERE category_id=$category_id
");

if ($q) {
    echo json_encode(["status" => 200, "message" => "Category updated successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Update failed"]);
}
?>
