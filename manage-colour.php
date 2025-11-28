<?php
include("connection.php");

// Handle Delete
if (isset($_GET['color-id'])) {
    $color_id = intval($_GET['color-id']);
    mysqli_query($conn, "DELETE FROM colour_tbl WHERE color_id=$color_id");
    header('Location: manage-colour.php');
    exit;
}

// Handle Update via POST (AJAX)
if (isset($_POST['update_color'])) {
    $color_id = intval($_POST['color_id']);
    $color_name = mysqli_real_escape_string($conn, $_POST['color_name']);
    $color_code = mysqli_real_escape_string($conn, $_POST['color_code']);

    mysqli_query($conn, "UPDATE colour_tbl SET color_name='$color_name', color_code='$color_code' WHERE color_id=$color_id");

    echo json_encode(['success' => true]);
    exit;
}

// Fetch colour table
$display_query = "SELECT * FROM colour_tbl";
$result = mysqli_query($conn, $display_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Colour</title>
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
                            <div class="card-header border-bottom border-dashed">
                                <h4 class="header-title mb-2">Manage Colour</h4>
                                <p class="text-muted mb-0">
                                </p>
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
                                        <td><?php echo $row['color_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['color_name']); ?></td>
                                        <td>
											<span style="display:inline-block;width:20px;height:20px;background:<?php echo $row['color_code']; ?>;border:1px solid #ccc;margin-right:5px;"></span>
											<?php echo htmlspecialchars($row['color_code']); ?>
										</td>

                                        <td>
                                            <a href="#" class="edit-btn" 
                                               data-id="<?php echo $row['color_id']; ?>" 
                                               data-name="<?php echo htmlspecialchars($row['color_name']); ?>" 
                                               data-code="<?php echo htmlspecialchars($row['color_code']); ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            &nbsp; | &nbsp;
                                            <a href="#" class="delete-btn" data-id="<?php echo $row['color_id']; ?>">
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
				<!-- Edit Colour Modal -->
<div class="modal fade" id="editColourModal" tabindex="-1" aria-labelledby="editColourLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editColourForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editColourLabel">Edit Colour</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="color_id" id="edit_color_id">
            <div class="mb-3">
                <label for="edit_color_name" class="form-label">Color Name</label>
                <input type="text" name="color_name" class="form-control" id="edit_color_name" required>
            </div>
            <div class="mb-3">
				<label class="form-label">Color</label>
				<div class="input-group">
					<!-- Color Picker -->
					<input type="color" class="form-control form-control-color" id="edit_color_picker" value="#000000">
					<!-- Text input for hex code -->
					<input type="text" class="form-control" id="edit_color_code_text" name="color_code" required>
				</div>
			</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Colour</button>
        </div>
      </div>
    </form>
  </div>
</div>
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
		<!-- DataTables JS -->
		<script src="assets/vendor/datatables/dataTables.min.js"></script>
		<script src="assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
		<script src="assets/vendor/datatables/dataTables.responsive.min.js"></script>
	

<script>
$(document).ready(function() {

    // Delete Colour
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This colour will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-colour.php?color-id=" + id;
            }
        });
    });

    // Edit button click
$(document).on("click", ".edit-btn", function() {
    var colorName = $(this).data('name');
    var colorCode = $(this).data('code');
    $('#edit_color_id').val($(this).data('id'));
    $('#edit_color_name').val(colorName);
    $('#edit_color_picker').val(colorCode);
    $('#edit_color_code_text').val(colorCode);
    var editModal = new bootstrap.Modal(document.getElementById('editColourModal'));
    editModal.show();
});

// Sync color picker and text input
$('#edit_color_picker').on('input', function() {
    $('#edit_color_code_text').val($(this).val());
});
$('#edit_color_code_text').on('input', function() {
    $('#edit_color_picker').val($(this).val());
});


    // Submit edit form
    $('#editColourForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'manage-colour.php',
            type: 'POST',
            data: $(this).serialize() + '&update_color=1',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Colour Updated!',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            }
        });
    });

});
</script>
		<!-- Vendor JS -->
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/js/app.js"></script>
</body>
</html>