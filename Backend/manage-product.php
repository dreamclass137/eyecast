<?php
include "connection.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
// ------------------- DELETE PRODUCT -------------------
if (isset($_GET['product-id'])) {
    $id = intval($_GET['product-id']);
    $stmt = $conn->prepare("DELETE FROM product_tbl WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage-product.php");
    exit;
}

// ------------------- TOGGLE PRODUCT STATUS -------------------
if (isset($_POST['toggle_status'], $_POST['product_id'], $_POST['status'])) {
    $id = intval($_POST['product_id']);
    $status = intval($_POST['status']); // 0 or 1

    $stmt = $conn->prepare("UPDATE product_tbl SET p_status = ? WHERE product_id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'status' => $status]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit;
}

// ------------------- FETCH PRODUCTS -------------------
$product_result = mysqli_query($conn, "SELECT * FROM product_tbl ORDER BY product_id DESC");

// ------------------- FETCH CATEGORIES -------------------
$categories = [];
$category_result = mysqli_query($conn, "SELECT * FROM category_tbl ORDER BY c_name ASC");
if ($category_result) {
    while ($row = mysqli_fetch_assoc($category_result)) {
        $categories[$row['category_id']] = $row['c_name'];
    }
}

// ------------------- FETCH SHAPES -------------------
$shapes = [];
$shape_result = mysqli_query($conn, "SELECT * FROM shape_tbl ORDER BY s_name ASC");
if ($shape_result) {
    while ($row = mysqli_fetch_assoc($shape_result)) {
        $shapes[$row['shape_id']] = $row['s_name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Adminto | Manage Product</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="assets/images/favicon.ico">
<script src="assets/js/config.js"></script>

<!-- Vendor & App CSS -->
<link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="assets/vendor/datatables/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.header-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
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
						<h4>Manage Product </h4>
						<a href="add-product.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Product </a>
					</div>
                    <div class="card-body pt-0">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Shape</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($p = mysqli_fetch_assoc($product_result)) { ?>
                                <tr>
                                    <td><?= $p['product_id'] ?></td>
                                    <td><?= htmlspecialchars($p['title']) ?></td>
                                    <td><?= $categories[$p['category_id']] ?? '' ?></td>
                                    <td><?= $shapes[$p['shape_id']] ?? '' ?></td>
                                    <td><?= $p['gender'] ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="statusToggle" data-id="<?= $p['product_id'] ?>" <?= $p['p_status']==1?'checked':'' ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="add-product.php?edit_id=<?= $p['product_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                        &nbsp; | &nbsp;
                                        <a href="#" class="delete-btn" data-id="<?= $p['product_id'] ?>"><i class="fa-solid fa-trash"></i></a>
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
$(document).ready(function() {
    $('#datatable-buttons').DataTable();

    // DELETE PRODUCT
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "This product will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-product.php?product-id=" + id;
            }
        });
    });

    // STATUS TOGGLE
    $(document).on("change", ".statusToggle", function () {
        let checkbox = $(this);
        let id = checkbox.data('id');
        let status = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: 'manage-product.php',
            type: 'POST',
            data: { toggle_status: 1, product_id: id, status: status },
            dataType: 'json',
            success: function(response){
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        //text: status ? 'Product is Active' : 'Product is Inactive',
                        timer: 1000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Update Failed' });
                    checkbox.prop('checked', !checkbox.is(':checked'));
                }
            },
            error: function(){
                Swal.fire({ icon: 'error', title: 'AJAX Error' });
                checkbox.prop('checked', !checkbox.is(':checked'));
            }
        });
    });
});
</script>
</body>
</html>
