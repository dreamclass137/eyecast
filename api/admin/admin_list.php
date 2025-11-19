<?php
header("Content-Type: application/json");
include "../../connection.php";

$sql = "SELECT admin_id, username, email FROM admin_tbl ORDER BY admin_id DESC";
$result = mysqli_query($conn, $sql);

$admins = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $admins[] = $row;
    }

    echo json_encode([
        "status" => 200,
        "message" => "Admin list fetched successfully",
        "data" => $admins
    ]);
} else {
    echo json_encode([
        "status" => 404,
        "message" => "No admins found"
    ]);
}
?>
