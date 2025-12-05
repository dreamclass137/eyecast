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
    <title>Adminto | Manage Addresses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Theme Config Js -->
        <script src="assets/js/config.js"></script>

        <!-- Vendor css -->
        <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- Datatables css -->
        <link href="assets/vendor/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/vendor/datatables/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/vendor/datatables/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/vendor/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/vendor/datatables/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awseome cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">>
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
                            <h4 class="header-title mb-2">Manage Addresses</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>address id</th>
                                        <th>User</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Pincode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $res = $conn->query("SELECT a.*, u.name AS username FROM address_tbl a JOIN user_tbl u ON a.user_id = u.user_id");
                                $i=1;
                                while($row = $res->fetch_assoc()){
                                    echo "<tr>
                                        <td>{$i}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['address']}</td>
                                        <td>{$row['city']}</td>
                                        <td>{$row['state']}</td>
                                        <td>{$row['pincode']}</td>
                                    </tr>";
                                    $i++;
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


<script>
$(document).ready(function() {
    $('#datatable-buttons').DataTable({
        responsive: true
    });
});
</script>
 <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- Apex Chart js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <!-- Projects Analytics Dashboard App js -->
        <script src="assets/js/pages/dashboard.js"></script>
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
