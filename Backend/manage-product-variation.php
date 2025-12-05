<?php
include "connection.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

/* ================= DELETE VARIATION ================= */
if (isset($_GET['variation-id'])) {
    $id = intval($_GET['variation-id']);
    mysqli_query($conn, "DELETE FROM product_variation_tbl WHERE pvariation_id = $id");
    header("Location: manage-product-variation.php");
    exit;
}

/* ================= TOGGLE STATUS ================= */
if (isset($_POST['toggle_status'])) {
    $id = intval($_POST['variation_id']);
    $status = $_POST['status'] == 'Active' ? '1' : '0';

    $update = mysqli_query(
        $conn,
        "UPDATE product_variation_tbl 
         SET v_status = '$status' 
         WHERE pvariation_id = $id"
    );

    // simple response: 1 = success, 0 = fail
    echo $update ? '1' : '0';
    exit;
}

/* ================= GET PRODUCT TITLE IF PRODUCT_ID PASSED ================= */
$product_title = '';
$pid = 0;
if(isset($_GET['product_id'])){
    $pid = intval($_GET['product_id']);
    $res = mysqli_query($conn, "SELECT title FROM product_tbl WHERE product_id='$pid'");
    if($row = mysqli_fetch_assoc($res)){
        $product_title = $row['title'];
    }
}

/* ================= FETCH VARIATIONS WITH PRODUCT TITLES ================= */
$sql = "
SELECT v.*, p.title AS product_title
FROM product_variation_tbl v
LEFT JOIN product_tbl p ON v.product_id = p.product_id
" . ($pid ? "WHERE v.product_id = $pid" : "") . "
ORDER BY v.pvariation_id DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Product Variations</title>
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
.switch{position:relative;display:inline-block;width:32px;height:16px;}
.switch input{display:none;}
.slider{position:absolute;cursor:pointer;background:#ccc;border-radius:20px;top:0;left:0;right:0;bottom:0;transition:.3s;}
.slider:before{position:absolute;content:"";width:12px;height:12px;left:2px;bottom:2px;background:white;border-radius:50%;transition:.3s;}
input:checked + .slider{background:#0d6efd;}
input:checked + .slider:before{transform:translateX(16px);}
.fa-trash,.fa-pen-to-square{cursor:pointer;color:#0d6efd;}
.fa-trash:hover{color:#d33;}
.desc-readmore{cursor:pointer;color:#0d6efd;font-weight:600;}
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
    <h4 class="header-title">
        Manage Product Variations
        <?php if($pid): ?>
            <small class="text-muted">| Product: <?= htmlspecialchars($product_title) ?></small>
        <?php endif; ?>
    </h4>
    <a href="add-product-variation.php<?= $pid ? "?product_id=$pid" : "" ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Add Variation
    </a>
</div>
<!--<div class="card-header d-flex justify-content-between align-items-center">
<h4>Manage Product Variation</h4>
<a href="add-product-variation.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Manage Product Variation</a>
</div>-->
<div class="card-body">
<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
<thead>
<tr>
    <th>ID</th>
    <th>Product</th>
    <th>Size</th>
    <th>Price</th>
    <th>Description</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($v = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $v['pvariation_id'] ?></td>
    <td><?= htmlspecialchars($v['product_title'] ?? 'Product Removed') ?></td>
    <td><?= htmlspecialchars($v['size']) ?></td>
    <td>₹<?= htmlspecialchars($v['price']) ?></td>
    <td>
        <?= strlen($v['description']) > 40 ? substr($v['description'],0,40).'...' : $v['description']; ?>
        <?php if(strlen($v['description']) > 40){ ?>
            <span class="desc-readmore" data-desc="<?= htmlspecialchars($v['description']) ?>">Read more</span>
        <?php } ?>
    </td>
    <td>
        <label class="switch">
            <input type="checkbox" class="statusToggle"
                data-id="<?= $v['pvariation_id'] ?>"
                <?= $v['v_status'] == 1 ? 'checked' : '' ?>>
            <span class="slider"></span>
        </label>
    </td>
    <td>
        <a href="add-product-variation.php?edit_id=<?= $v['pvariation_id'] ?>">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        &nbsp; | &nbsp;
        <a href="#" class="delete-btn" data-id="<?= $v['pvariation_id'] ?>">
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

    /* DELETE */
    $(document).on("click", ".delete-btn", function(e){
        e.preventDefault();
        let id = $(this).data("id");

        Swal.fire({
            title: "Delete variation?",
            //text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete"
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = "manage-product-variation.php?variation-id=" + id;
            }
        });
    });

    /* STATUS TOGGLE (AJAX, NO JSON) */
    $(document).on("change", ".statusToggle", function(){
        let id = $(this).data("id");
        let status = $(this).is(":checked") ? "Active" : "Inactive";
        let checkbox = $(this);

        $.ajax({
            url: "manage-product-variation.php",
            type: "POST",
            data: {
                toggle_status: 1,
                variation_id: id,
                status: status
            },
            success: function(response){
                if(response == '1'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        //text: 'Product variation status has been updated to ' + status,
                        timer: 1200,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Could not update status.'
                    });
                    checkbox.prop('checked', !checkbox.is(":checked"));
                }
            },
            error: function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong.'
                });
                checkbox.prop('checked', !checkbox.is(":checked"));
            }
        });
    });

    /* DESCRIPTION MODAL */
    $(document).on("click", ".desc-readmore", function(){
        $("#descModalBody").text($(this).data("desc"));
        $("#descModal").modal("show");
    });

});
</script>

<!-- DESCRIPTION MODAL -->
<div class="modal fade" id="descModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="descModalBody"></div>
    </div>
  </div>
</div>

</body>
</html>
