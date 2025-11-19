<?php
header("Content-Type: application/json");
include "../../connection.php";

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 0);

// Validate
if ($user_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "user_id is required"
    ]);
    exit;
}

// Check if user has items in cart
$check = mysqli_query($conn, "SELECT * FROM cart_tbl WHERE user_id='$user_id'");

if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "No cart items found for this user"
    ]);
    exit;
}

// Delete items
$sql = "DELETE FROM cart_tbl WHERE user_id='$user_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => 200,
        "message" => "Cart cleared successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to clear cart"
    ]);
}
?>
