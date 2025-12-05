<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto | WishList</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="assets/images/favicon.ico">

<script src="assets/js/config.js"></script>
<link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
    <?php include_once("sidebar.php");?>
    <?php include_once("header.php");?>

    <div class="page-content">
        <div class="page-container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="header-title mb-2">Manage Wishlist</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Colour</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php
                                    $sql = "
                                        SELECT w.wishlist_id, w.product_id, w.pvariation_id, w.pimage_id,
                                               u.name AS user_name,
                                               p.title AS product_name,
                                               pi.f_image, pi.b_image,
                                               c.color_name, c.color_code
                                        FROM wishlist_tbl w
                                        INNER JOIN user_tbl u ON u.user_id = w.user_id
                                        INNER JOIN product_tbl p ON p.product_id = w.product_id
                                        INNER JOIN product_variation_tbl pv ON pv.pvariation_id = w.pvariation_id
                                        INNER JOIN product_image_tbl pi ON pi.image_id = w.pimage_id
                                        LEFT JOIN color_tbl c ON c.color_id = pi.color_id
                                        WHERE w.w_status = 1
                                          AND p.p_status = '1'
                                          AND pv.v_status = '1'
                                          AND pi.i_status = '1'
                                        ORDER BY w.wishlist_id DESC
                                    ";

                                    $result = mysqli_query($conn, $sql);
                                    $sn = 1;

                                    if($result && mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                            <tr data-id="<?= $row['wishlist_id'] ?>">
                                                <td><?= $sn ?></td>
                                                <td><?= htmlspecialchars($row['user_name']) ?></td>
                                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                                <td><?= !empty($row['color_name']) ? htmlspecialchars($row['color_name']) : 'No Colour' ?></td>
                                            </tr>
                                            <?php
                                            $sn++;
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" class="text-center">No wishlist items found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("footer.php");?>
    </div>
</div>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>

<!-- Datatables -->
<script src="assets/vendor/datatables/dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables/responsive.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/fixedColumns.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/dataTables.fixedHeader.min.js"></script>
<script src="assets/vendor/datatables/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables/buttons.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/buttons.html5.min.js"></script>
<script src="assets/vendor/datatables/buttons.print.min.js"></script>
<script src="assets/vendor/datatables/jszip.min.js"></script>
<script src="assets/vendor/datatables/pdfmake.min.js"></script>
<script src="assets/vendor/datatables/vfs_fonts.js"></script>
<script src="assets/vendor/datatables/dataTables.keyTable.min.js"></script>
<script src="assets/vendor/datatables/dataTables.select.min.js"></script>
<script src="assets/js/components/table-datatable.js"></script>

</body>
</html>
