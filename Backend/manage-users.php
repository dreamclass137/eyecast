<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
// Toggle status
if(isset($_POST['toggle_user_id'])){
    $id = $_POST['toggle_user_id'];
    $status = $_POST['current_status'] == "1" ? "0" : "1"; // 1=Active, 0=Blocked

    $sql = "UPDATE user_tbl SET u_status='$status' WHERE user_id='$id'";
    if(mysqli_query($conn, $sql)){
        echo $status;
    } else {
        echo "error";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Manage Users</title>
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

<style>
.toggle-btn {
    width: 35px; 
    height: 18px; 
    background: #ccc; /* inactive gray */
    border-radius: 20px; 
    cursor: pointer; 
    position: relative;
}

.toggle-btn.active-toggle { 
    background: #007bff; /* blue color when active */
}

.toggle-circle { 
    width: 16px; 
    height: 16px; 
    background: #fff; 
    border-radius: 50%; 
    position: absolute; 
    top: 1px; 
    left: 1px; 
    transition: 0.3s; 
}

.toggle-btn.active-toggle .toggle-circle { 
    left: 18px; 
}
</style>
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
                        <h4 class="header-title mb-2">Manage Users</h4>
                    </div>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Registered at</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM user_tbl ORDER BY user_id DESC";
                                $res = mysqli_query($conn, $sql);
                                $i = 1;
                                while($row = mysqli_fetch_assoc($res)){
                                    $active = ($row['u_status']=="1") ? "active-toggle" : ""; // 1 = Active

                                    echo "<tr data-id='{$row['user_id']}'>
                                            <td>{$i}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['phone']}</td>
                                            <td>
                                                <div class='toggle-btn {$active}' data-status='{$row['u_status']}'>
                                                    <div class='toggle-circle'></div>
                                                </div>
                                            </td>
                                            <td>{$row['created_at']}</td>
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
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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



<script>
$(document).ready(function(){
    $(".toggle-btn").click(function(){
        var btn = $(this);
        var tr = btn.closest("tr");
        var id = tr.data("id");
        var status = btn.data("status"); // 1=Active, 0=Inactive

        $.post("", {toggle_user_id: id, current_status: status}, function(response){
            if(response=="1" || response=="0"){
                btn.data("status", response);
                if(response=="1"){
                    btn.addClass("active-toggle"); // visually active
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Active',
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    btn.removeClass("active-toggle"); // visually inactive
                    Swal.fire({
                        icon: 'error',
                        title: 'Status Inactive',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    showConfirmButton: false,
                    timer: 1200
                });
            }
        });
    });
});
</script>
</body>
</html>