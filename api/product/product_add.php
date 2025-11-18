<?php
header('Content-Type: application/json');
include '../../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$required = ['category_id','shape_id','title','price','status'];

foreach($required as $field){
    if(empty($data[$field])){
        echo json_encode(["status"=>400,"message"=>"$field is required"]);
        exit;
    }
}

// Check category exists
$cat = $conn->query("SELECT category_id FROM category_tbl WHERE category_id = ".$data['category_id']);
if($cat->num_rows == 0){
    echo json_encode(["status"=>400,"message"=>"Invalid category_id"]);
    exit;
}

// Check shape exists
$shape = $conn->query("SELECT shape_id FROM shape_tbl WHERE shape_id = ".$data['shape_id']);
if($shape->num_rows == 0){
    echo json_encode(["status"=>400,"message"=>"Invalid shape_id"]);
    exit;
}


$stmt = $conn->prepare("
    INSERT INTO product_tbl 
    (category_id, shape_id, title, description, gender, price, size, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("iisssdss",
    $data['category_id'],
    $data['shape_id'],
    $data['title'],
    $data['description'],
    $data['gender'],
    $data['price'],
    $data['size'],
    $data['status']
);



if($stmt->execute()){
    echo json_encode(["status"=>200,"message"=>"Product added successfully"]);
} else {
    echo json_encode(["status"=>500,"message"=>"Database error"]);
}
?>
