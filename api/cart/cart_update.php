<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$cart_id = intval($data['cart_id'] ?? 0);
$quantity = intval($data['quantity'] ?? 0);

if ($cart_id == 0 || $quantity <= 0) {
    echo json_encode([
        "status" => 400,
        "message" => "cart_id and valid quantity are required"
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

$sql = "UPDATE cart_tbl SET quantity='$quantity' WHERE cart_id='$cart_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Cart updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to update cart"
    ]);
}
?>
