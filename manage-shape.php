<?php
include("connection.php");

// Handle Delete
if (isset($_GET['shape-id'])) {
    $shape_id = intval($_GET['shape-id']);
    mysqli_query($conn, "DELETE FROM shape_tbl WHERE shape_id=$shape_id");
    header('Location: manage-shape.php');
    exit;
}

// Handle Update via POST (AJAX)
if (isset($_POST['update_shape'])) {
    $shp_id = intval($_POST['shape_id']);
    $shp_name = mysqli_real_escape_string($conn, $_POST['shape_name']);
    $status = ($_POST['status'] === 'Active') ? 'Active' : 'Inactive';

    mysqli_query($conn, "UPDATE shape_tbl SET s_name='$shp_name', status='$status' WHERE shape_id=$shp_id");
    
    // Also update products using this shape
    mysqli_query($conn, "UPDATE product_tbl SET shape='$status' WHERE shape_id=$shp_id");

    echo json_encode(['success' => true]);
    exit;
}

// Handle Status Toggle via AJAX
if (isset($_POST['toggle_status'])) {
    $shape_id = intval($_POST['shape_id']);
    $status = ($_POST['status'] === 'Active') ? 'Active' : 'Inactive';

    // Update shape table
    mysqli_query($conn, "UPDATE shape_tbl SET status='$status' WHERE shape_id=$shape_id");

    // Update related products
    mysqli_query($conn, "UPDATE product_tbl SET shape='$status' WHERE shape_id=$shape_id");

    echo json_encode(['success' => true]);
    exit;
}

// Fetch shape table
$display_query = "SELECT * FROM shape_tbl";
$result = mysqli_query($conn, $display_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Adminto | Manage Shape</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme CSS -->
    <script src="assets/js/config.js"></script>
    <link href="assets/css/vendor.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />

    <!-- Datatables -->
    <link href="assets/vendor/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <h4 class="header-title mb-2">Manage Shape</h4>
                            <p class="text-muted mb-0">Shape list with edit, delete & status update.</p>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Shape ID</th>
                                    <th>Shape Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['shape_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['s_name']); ?></td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox"
                                                       class="statusToggle"
                                                       data-id="<?php echo $row['shape_id']; ?>"
                                                       <?php echo ($row['status'] == "Active") ? 'checked' : ''; ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="#" class="edit-btn" 
                                               data-id="<?php echo $row['shape_id']; ?>" 
                                               data-name="<?php echo htmlspecialchars($row['s_name']); ?>" 
                                               data-status="<?php echo $row['status']; ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            &nbsp; | &nbsp;
                                            <a href="#" class="delete-btn" data-id="<?php echo $row['shape_id']; ?>">
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

<!-- Edit Shape Modal -->
<div class="modal fade" id="editShapeModal" tabindex="-1" aria-labelledby="editShapeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editShapeForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editShapeLabel">Edit Shape</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="shape_id" id="edit_shape_id">
            <div class="mb-3">
                <label for="edit_shape_name" class="form-label">Shape Name</label>
                <input type="text" name="shape_name" class="form-control" id="edit_shape_name" required>
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
          <button type="submit" class="btn btn-primary">Update Shape</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Vendor JS -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>

<!-- DataTables JS -->
<script src="assets/vendor/datatables/dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {

    // Delete Shape
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This shape will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-shape.php?shape-id=" + id;
            }
        });
    });

    // Update status toggle
    $(document).on("change", ".statusToggle", function () {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? "Active" : "Inactive";

        $.ajax({
            url: 'manage-shape.php',
            type: 'POST',
            data: { toggle_status: 1, shape_id: id, status: status },
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
        $('#edit_shape_id').val($(this).data('id'));
        $('#edit_shape_name').val($(this).data('name'));
        $('#edit_status').val($(this).data('status'));
        var editModal = new bootstrap.Modal(document.getElementById('editShapeModal'));
        editModal.show();
    });

    // Submit edit form
    $('#editShapeForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'manage-shape.php',
            type: 'POST',
            data: $(this).serialize() + '&update_shape=1',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Shape Updated!',
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

</body>
</html>
