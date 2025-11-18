<?php
header("Content-Type: application/json");
include "connection.php";

$name = strtolower(trim($_GET['name'] ?? ''));
$category_id = intval($_GET['category_id'] ?? 0);

if ($name == "") {
    echo json_encode(["exists" => false]);
    exit;
}

$name = mysqli_real_escape_string($conn, $name);

$sql = "SELECT category_id FROM category_tbl WHERE LOWER(c_name)='$name'";

if ($category_id > 0) {
    $sql .= " AND category_id != $category_id";
}

$sql .= " LIMIT 1";

$res = mysqli_query($conn, $sql);

echo json_encode(["exists" => mysqli_num_rows($res) > 0]);
?>
