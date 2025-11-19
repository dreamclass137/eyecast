<?php
header("Content-Type: application/json");
include "../../connection.php";

// Accept JSON input
$input = json_decode(file_get_contents("php://input"), true);

$s_name = $input['s_name'] ?? ($_POST['s_name'] ?? '');
$status = $input['status'] ?? ($_POST['status'] ?? 'Active');

// Validation
if ($s_name == '') {
    echo json_encode([
        "status" => 400,
        "message" => "s_name is required"
    ]);
    exit;
}

// DIRECT SQL INSERT (NO PREPARE)
$sql = "INSERT INTO shape_tbl (s_name, status) VALUES ('$s_name', '$status')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode([
        "status" => 200,
        "message" => "Shape added successfully",
        "shape_id" => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Insert failed"
    ]);
}
?>
