<?php
header("Content-Type: application/json");
include "../../connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 0);

if ($user_id == 0) {
    echo json_encode([
        "status" => 400,
        "message" => "user_id is required"
    ]);
    exit;
}

$sql = "SELECT c.cart_id, c.quantity,
        p.product_id, p.title, p.price,
        pc.pcolor_id, pc.f_image, pc.b_image, pc.stock,
        clr.color_name, clr.color_code
        FROM cart_tbl c
        JOIN product_tbl p ON c.product_id = p.product_id
        JOIN product_colors_tbl pc ON c.pcolor_id = pc.pcolor_id
        JOIN colour_tbl clr ON pc.color_id = clr.color_id
        WHERE c.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$cart = [];

while ($row = mysqli_fetch_assoc($result)) {
    $cart[] = $row;
}

echo json_encode([
    "status" => 200,
    "message" => "Cart fetched successfully",
    "data" => $cart
]);
?>
