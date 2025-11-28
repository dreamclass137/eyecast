<?php
include("connection.php");

// Handle Delete
if (isset($_GET['category-id'])) {
    $category_id = intval($_GET['category-id']);
    mysqli_query($conn, "DELETE FROM category_tbl WHERE category_id=$category_id");
    header('Location: manage-category.php');
    exit;
}

// Handle Update via POST (AJAX)
if (isset($_POST['update_category'])) {
    $cat_id = intval($_POST['category_id']);
    $cat_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $status = ($_POST['status'] === 'Active') ? 'Active' : 'Inactive';

    mysqli_query($conn, "UPDATE category_tbl 
                         SET c_name='$cat_name', status='$status' 
                         WHERE category_id=$cat_id");
    
    // Also update products using this category
    mysqli_query($conn, "UPDATE product_tbl 
                         SET category='$status' 
                         WHERE category_id=$cat_id");

    echo json_encode(['success' => true]);
    exit;
}

// Handle Status Toggle via AJAX
if (isset($_POST['toggle_status'])) {
    $category_id = intval($_POST['category_id']);
    $status = ($_POST['status'] === 'Active') ? 'Active' : 'Inactive';

    // Update category table
    mysqli_query($conn, "UPDATE category_tbl 
                         SET status='$status' 
                         WHERE category_id=$category_id");

    // Update related products
    mysqli_query($conn, "UPDATE product_tbl 
                         SET category='$status' 
                         WHERE category_id=$category_id");

    echo json_encode(['success' => true]);
    exit;
}

// Fetch category table
$display_query = "SELECT * FROM category_tbl";
$result = mysqli_query($conn, $display_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Category</title>
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
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="header-title mb-2">Manage Category</h4>
                            <p class="text-muted mb-0">Category list with edit, delete & status update.</p>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
								<thead>
									<tr>
										<th>Category ID</th>
										<th>Category Name</th>
										<th>Status</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
								<?php while ($row = mysqli_fetch_assoc($result)) { ?>
									<tr>
										<td><?php echo $row['category_id']; ?></td>
										<td><?php echo htmlspecialchars($row['c_name']); ?></td>
										<td>
											<label class="switch">
												<input type="checkbox"
													   class="statusToggle"
													   data-id="<?php echo $row['category_id']; ?>"
													   <?php echo ($row['status'] == "Active") ? 'checked' : ''; ?>>
												<span class="slider round"></span>
											</label>
										</td>
										<td>
											<a href="#" class="edit-btn"
											   data-id="<?php echo $row['category_id']; ?>"
											   data-name="<?php echo htmlspecialchars($row['c_name']); ?>"
											   data-status="<?php echo $row['status']; ?>">
												<i class="fa-solid fa-pen-to-square"></i>
											</a>
											&nbsp; | &nbsp;
											<a href="#" class="delete-btn" data-id="<?php echo $row['category_id']; ?>">
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

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editCategoryForm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="category_id" id="edit_category_id">
            <div class="mb-3">
                <label for="edit_category_name" class="form-label">Category Name</label>
                <input type="text" name="category_name" class="form-control" id="edit_category_name" required>
            </div>
            <div class="mb-3">
                <label for="edit_status" class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
    </div>
</form>

  </div>
</div>

<script>
$(document).ready(function() {

    // Delete Category
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This category will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-category.php?category-id=" + id;
            }
        });
    });

    // Update status toggle
    $(document).on("change", ".statusToggle", function () {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? "Active" : "Inactive";

        $.ajax({
            url: 'manage-category.php',
            type: 'POST',
            data: { toggle_status: 1, category_id: id, status: status },
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    Swal.fire({
                        icon: "success",
                        title: "Status Updated",
                        timer: 800,
                        showConfirmButton: false
                    });
                }
            }
        });
    });

    // Edit button click
    $(document).on("click", ".edit-btn", function() {
        $('#edit_category_id').val($(this).data('id'));
        $('#edit_category_name').val($(this).data('name'));
        $('#edit_status').val($(this).data('status'));
        var editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editModal.show();
    });

    // Submit edit form
    $('#editCategoryForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'manage-category.php',
            type: 'POST',
            data: $(this).serialize() + '&update_category=1',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Category Updated!',
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
         <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- Apex Chart js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <!-- Projects Analytics Dashboard App js -->
        <script src="assets/js/pages/dashboard.js"></script> 
</body>
</html>
