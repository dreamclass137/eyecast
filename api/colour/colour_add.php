<?php
header("Content-Type: application/json");
include "../../connection.php";

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);

$color_name = $input['color_name'] ?? ($_POST['color_name'] ?? '');
$color_code = $input['color_code'] ?? ($_POST['color_code'] ?? '');

if ($color_name == '' || $color_code == '') {
    echo json_encode(["status" => 400, "message" => "color_name and color_code are required"]);
    exit;
}

// Escape values to avoid SQL injection
$color_name = mysqli_real_escape_string($conn, $color_name);
$color_code = mysqli_real_escape_string($conn, $color_code);

// SQL INSERT query (no prepare)
$sql = "INSERT INTO colour_tbl (color_name, color_code) 
        VALUES ('$color_name', '$color_code')";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Colour added successfully",
        "color_id" => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode(["status" => 500, "message" => "Insert failed"]);
}
?>
