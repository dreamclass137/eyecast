<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
// ===================== DELETE =====================
if (isset($_GET['shape-id'])) {
    $shape_id = intval($_GET['shape-id']);
    mysqli_query($conn, "DELETE FROM shape_tbl WHERE shape_id=$shape_id");
    header('Location: manage-shape.php');
    exit;
}

// ===================== FETCH =====================
$display_query = "SELECT * FROM shape_tbl ORDER BY shape_id ASC";
$result = mysqli_query($conn, $display_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Shape</title>
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
		
    <style>
        .switch { position: relative; display: inline-block; width: 32px; height: 16px; }
        .switch input { display: none; }
        .slider { position: absolute; cursor: pointer; background: #ccc; border-radius: 20px; top: 0; left: 0; right: 0; bottom: 0; transition: .3s; }
        .slider:before { position: absolute; content: ""; width: 12px; height: 12px; left: 2px; bottom: 2px; background: white; border-radius: 50%; transition: .3s; }
        input:checked + .slider { background: #0d6efd; }
        input:checked + .slider:before { transform: translateX(16px); }
        td .fa-trash, td .fa-pen-to-square { color: #0d6efd; cursor: pointer; }
        td .fa-trash:hover { color: #d33; }
    </style>
</head>

<body>
<div class="wrapper">
    <?php include_once("sidebar.php"); ?>
    <?php include_once("header.php"); ?>

    <div class="page-content">
        <div class="page-container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
							<h4>Manage Shape </h4>
							<a href="add-shape.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Shape </a>
							<!--<p class="text-muted mb-0">Category list with edit & delete.</p>-->
						</div>
                        <div class="card-body">
                               <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Shape ID</th>
                                        <th>Shape Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['shape_id'] ?></td>
                                        <td><?= htmlspecialchars($row['s_name']) ?></td>
                                        <td>
                                            <!-- Edit icon → redirect to add-shape.php with edit_id -->
                                            <a href="add-shape.php?edit_id=<?= $row['shape_id'] ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            &nbsp; | &nbsp;
                                            <!-- Delete icon → confirmation -->
                                            <a href="#" class="delete-btn" data-id="<?= $row['shape_id'] ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("footer.php"); ?>
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
		document.querySelectorAll('.delete-btn').forEach(btn => {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				const id = this.getAttribute('data-id');
				Swal.fire({
					title: "Are you sure?",
					text: "This shape will be deleted!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d33",
					cancelButtonColor: "#3085d6",
					confirmButtonText: "Yes, delete it!"
				}).then((result) => {
					if(result.isConfirmed){
						window.location.href = "manage-shape.php?shape-id=" + id;
					}
				});
			});
		});
		</script>
	</body>
</html>
