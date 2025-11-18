<?php
header("Content-Type: application/json");
include "connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$c_name = mysqli_real_escape_string($conn, trim($data['c_name'] ?? ''));
$status = mysqli_real_escape_string($conn, trim($data['status'] ?? ''));

if ($c_name == "" || $status == "") {
    echo json_encode(["status" => 400, "message" => "c_name and status are required"]);
    exit;
}

if ($status != "Active" && $status != "Inactive") {
    echo json_encode(["status" => 400, "message" => "Invalid status"]);
    exit;
}

// duplicate check
$check = mysqli_query($conn, "SELECT * FROM category_tbl WHERE c_name='$c_name'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(["status" => 409, "message" => "Category already exists"]);
    exit;
}

$q = mysqli_query($conn, "
    INSERT INTO category_tbl (c_name, status)
    VALUES ('$c_name', '$status')
");

if ($q) {
    echo json_encode(["status" => 200, "message" => "Category added successfully"]);
} else {
    echo json_encode(["status" => 500, "message" => "Insert failed"]);
}
?>
