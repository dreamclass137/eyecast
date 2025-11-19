<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 0);
$product_id = intval($data['product_id'] ?? 0);
$pcolor_id = intval($data['pcolor_id'] ?? 0);
$quantity = intval($data['quantity'] ?? 1);

if ($user_id == 0 || $product_id == 0 || $pcolor_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "user_id, product_id, pcolor_id are required"
    ]);
    exit;
}

// 🔍 Step 1: Check product_color exists
$checkColor = mysqli_query($conn, 
    "SELECT * FROM product_colors_tbl 
     WHERE pcolor_id='$pcolor_id' AND product_id='$product_id' LIMIT 1");

if (mysqli_num_rows($checkColor) == 0) {
    echo json_encode([
        "status" => 404,
        "message" => "Invalid pcolor_id: No such product color found"
    ]);
    exit;
}

// 🔍 Step 2: Check if same product/color already in cart
$checkCart = mysqli_query($conn, 
    "SELECT * FROM cart_tbl 
     WHERE user_id='$user_id' AND product_id='$product_id' AND pcolor_id='$pcolor_id' LIMIT 1");

if (mysqli_num_rows($checkCart) > 0) {
    // increase quantity
    $row = mysqli_fetch_assoc($checkCart);
    $newQty = $row['quantity'] + $quantity;

    mysqli_query($conn, 
        "UPDATE cart_tbl SET quantity='$newQty' WHERE cart_id='".$row['cart_id']."'");

    echo json_encode([
        "status" => 200,
        "message" => "Quantity updated",
        "quantity" => $newQty
    ]);
    exit;
}

// 🔍 Step 3: Insert item into cart
$insert = "INSERT INTO cart_tbl (user_id, product_id, pcolor_id, quantity)
           VALUES ('$user_id', '$product_id', '$pcolor_id', '$quantity')";

if (mysqli_query($conn, $insert)) {
    echo json_encode([
        "status" => 200,
        "message" => "Added to cart successfully",
        "cart_id" => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to add to cart"
    ]);
}
?>
