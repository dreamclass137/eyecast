<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$cart_id = intval($data['cart_id'] ?? 0);

if ($cart_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "cart_id is required"
    ]);
    exit;
}

// Check cart exists
$check = mysqli_query($conn, "SELECT * FROM cart_tbl WHERE cart_id='$cart_id'");
if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "Cart item not found"
    ]);
    exit;
}

$sql = "DELETE FROM cart_tbl WHERE cart_id='$cart_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Cart item deleted"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to delete item"
    ]);
}
?>
