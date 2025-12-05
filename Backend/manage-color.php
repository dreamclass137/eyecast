<?php
include("connection.php");
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// ===================== DELETE =====================
if (isset($_GET['color-id'])) {
    $color_id = intval($_GET['color-id']);
    mysqli_query($conn, "DELETE FROM color_tbl WHERE color_id=$color_id");
    header('Location: manage-color.php');
    exit;
}

// ===================== FETCH =====================
$display_query = "SELECT * FROM color_tbl ORDER BY color_id ASC";
$result = mysqli_query($conn, $display_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Color</title>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		
		
</head>
<body>
             <div class="wrapper">

            <!-- Menu -->
            <!-- Sidenav Menu Start -->
          
            <?php  include_once("sidebar.php");?>

            <!-- Sidenav Menu End -->
            
            <!-- Topbar Start -->
          
            <?php include_once("header.php");?>
          
            <!-- Topbar End -->

            <!-- Search Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-transparent">
                        <form>
                            <div class="card mb-1">
                                <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                                    <i class="ri-search-line fs-22"></i>
                                    <input type="search" class="form-control border-0" id="search-modal-input"
                                        placeholder="Search for actions, people,">
                                    <button type="submit" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">[esc]</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="page-content">
                <div class="page-container">

                    
                    <!-- <h1>Manage State</h1> -->
                    <div class="row">
                    <div class="col-12">
                        <div class="card">
							<div class="card-header d-flex justify-content-between align-items-center">
								<h4>Manage Color </h4>
								<a href="add-color.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Color </a>
								<!--<p class="text-muted mb-0">Category list with edit & delete.</p>-->
							</div>
                            <div class="card-body">
							
							  <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
	
                                <thead>
                                    <tr>
                                        <th>Color ID</th>
                                        <th>Color Name</th>
                                        <th>Color Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['color_id'] ?></td>
                                        <td><?= htmlspecialchars($row['color_name']) ?></td>
                                        <td>
                                            <span style="display:inline-block;width:20px;height:20px;background:<?= $row['color_code'] ?>;border:1px solid #ccc;margin-right:5px;"></span>
                                            <?= htmlspecialchars($row['color_code']) ?>
                                        </td>
                                        <td>
                                            <!-- Edit → redirect to add-color.php -->
                                            <a href="add-color.php?edit_id=<?= $row['color_id'] ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            &nbsp; | &nbsp;
                                            <!-- Delete -->
                                            <a href="#" class="delete-btn" data-id="<?= $row['color_id'] ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div> <!-- end row-->
                   
                </div> <!-- container -->

                <!-- Footer Start -->
                <?php include_once("footer.php");?>
                <!-- end Footer -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
		
		<!-- Vendor js -->
		<script src="assets/js/vendor.min.js"></script>

		<!-- App js -->
		<script src="assets/js/app.js"></script>

		<!-- Datatables js -->
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

		<!-- Datatable Demo js -->
		<script src="assets/js/components/table-datatable.js"></script>
<script>
/* ================= DELETE CONFIRM ================= */
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.dataset.id;

        Swal.fire({
            title: "Are you sure?",
            text: "This color will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-color.php?color-id=" + id;
            }
        });
    });
});

/* ================= UPDATE SUCCESS ALERT ================= */
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('status') === 'updated') {
    Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: 'Color updated successfully.',
        showConfirmButton: false,
        timer: 2000
    });

    // URL clean karva mate
    window.history.replaceState(null, null, window.location.pathname);
}
</script>

		<!-- Vendor JS -->
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/js/app.js"></script>
</body>
</html>