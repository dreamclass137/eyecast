<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

// Required fields
$required = ['category_id','shape_id','title','price','status'];

foreach($required as $field){
    if(empty($data[$field])){
        echo json_encode(["status"=>400,"message"=>"$field is required"]);
        exit;
    }
}

// Escape + secure values
$category_id = intval($data['category_id']);
$shape_id    = intval($data['shape_id']);
$title       = mysqli_real_escape_string($conn, $data['title']);
$description = mysqli_real_escape_string($conn, $data['description'] ?? '');
$gender      = mysqli_real_escape_string($conn, $data['gender'] ?? '');
$price       = floatval($data['price']);
$size        = mysqli_real_escape_string($conn, $data['size'] ?? '');
$status      = mysqli_real_escape_string($conn, $data['status']);

// Check category exists
$cat = $conn->query("SELECT category_id FROM category_tbl WHERE category_id = $category_id");
if($cat->num_rows == 0){
    echo json_encode(["status"=>400,"message"=>"Invalid category_id"]);
    exit;
}

// Check shape exists
$shape = $conn->query("SELECT shape_id FROM shape_tbl WHERE shape_id = $shape_id");
if($shape->num_rows == 0){
    echo json_encode(["status"=>400,"message"=>"Invalid shape_id"]);
    exit;
}

// SQL INSERT Query
$sql = "
    INSERT INTO product_tbl 
    (category_id, shape_id, title, description, gender, price, size, status)
    VALUES (
        $category_id,
        $shape_id,
        '$title',
        '$description',
        '$gender',
        $price,
        '$size',
        '$status'
    )
";

if(mysqli_query($conn, $sql)){
    echo json_encode(["status"=>200,"message"=>"Product added successfully"]);
} else {
    echo json_encode(["status"=>500,"message"=>"Database error"]);
}
?>
