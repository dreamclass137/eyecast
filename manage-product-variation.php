<?php
include("connection.php");

// ADD PRODUCT VARIATION
if (isset($_POST['add_variation'])) {
    $product_id = intval($_POST['product_id']);
    $color_id = intval($_POST['color_id']);
    $f_image = $_POST['f_image'] ?? '';
    $b_image = $_POST['b_image'] ?? '';
    $tryon_image = $_POST['tryon_image'] ?? '';
    $stock = $_POST['stock'] ?? 'Inactive';

    mysqli_query($conn, "INSERT INTO product_colors_tbl 
        (product_id, color_id, f_image, b_image, tryon_image, stock) 
        VALUES ($product_id, $color_id, '$f_image', '$b_image', '$tryon_image', '$stock')");
    header("Location: manage-product-variation.php");
    exit;
}

// UPDATE PRODUCT VARIATION via AJAX
if (isset($_POST['update_variation'])) {
    $id = intval($_POST['pcolor_id']);
    $product_id = intval($_POST['product_id']);
    $color_id = intval($_POST['color_id']);
    $f_image = $_POST['f_image'] ?? '';
    $b_image = $_POST['b_image'] ?? '';
    $tryon_image = $_POST['tryon_image'] ?? '';
    $stock = $_POST['stock'] ?? 'Inactive';

    $update = mysqli_query($conn, "UPDATE product_colors_tbl SET
        product_id=$product_id,
        color_id=$color_id,
        f_image='$f_image',
        b_image='$b_image',
        tryon_image='$tryon_image',
        stock='$stock'
        WHERE pcolor_id=$id");

    echo json_encode(['success' => $update ? true : false]);
    exit;
}


// TOGGLE STOCK via AJAX
if (isset($_POST['toggle_stock'])) {
    $pcolor_id = intval($_POST['pcolor_id']);
    $stock = $_POST['new_stock'] ?? 'Inactive';

    $stmt = $conn->prepare("UPDATE product_colors_tbl SET stock=? WHERE pcolor_id=?");
    $stmt->bind_param("si", $stock, $pcolor_id);
    $success = $stmt->execute();
    $stmt->close();

    echo json_encode(['success'=>$success,'message'=>$success?'Stock updated':'Failed to update stock']);
    exit;
}

// DELETE PRODUCT VARIATION
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM product_colors_tbl WHERE pcolor_id=$id");
    header("Location: manage-product-variation.php");
    exit;
}


// FETCH PRODUCT VARIATIONS
$sql = "SELECT pc.*, p.title AS product_name, c.color_name 
        FROM product_colors_tbl pc
        JOIN product_tbl p ON pc.product_id = p.product_id
        JOIN colour_tbl c ON pc.color_id = c.color_id
        ORDER BY pc.pcolor_id DESC";
$result = mysqli_query($conn, $sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto | Manage Product Variation</title>
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
        <!-- Sidebar -->
        <?php include_once("sidebar.php");?>

        <!-- Header -->
        <?php include_once("header.php");?>

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

        <!-- Page Content -->
        <div class="page-content">
            <div class="page-container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom border-dashed">
                                <h4 class="header-title mb-2">Manage Product Variation</h4>
                                <p class="text-muted mb-0">
                                    The Buttons extension for DataTables provides a common set of options, API methods, 
                                    and styling to display buttons on a page that will interact with a DataTable. 
                                    The core library provides the base framework upon which plug-ins can be built.
                                </p>
                            </div>
                            <div class="card-body">
							 <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Color</th>
                                        <th>Front Image</th>
                                        <th>Back Image</th>
                                        <th>Tryon Image</th>
                                        <th>Stock Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['pcolor_id'] ?></td>
                                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                                        <td><?= htmlspecialchars($row['color_name']) ?></td>
                                        <td><?php if($row['f_image']) echo "<img src='".$row['f_image']."' />"; ?></td>
                                        <td><?php if($row['b_image']) echo "<img src='".$row['b_image']."' />"; ?></td>
                                        <td><?php if($row['tryon_image']) echo "<img src='".$row['tryon_image']."' />"; ?></td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="stockToggle" data-id="<?= $row['pcolor_id'] ?>" <?= ($row['stock']=='Active')?'checked':'' ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="#" class="edit-btn"
                                               data-id="<?= $row['pcolor_id'] ?>"
                                               data-product="<?= $row['product_id'] ?>"
                                               data-color="<?= $row['color_id'] ?>"
                                               data-f_image="<?= $row['f_image'] ?>"
                                               data-b_image="<?= $row['b_image'] ?>"
                                               data-tryon_image="<?= $row['tryon_image'] ?>"
                                               data-stock="<?= $row['stock'] ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            &nbsp; | &nbsp;
                                            <a href="#" class="delete-btn" data-id="<?= $row['pcolor_id'] ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                             
                            </div>
                        </div>
                    </div> <!-- col-12 -->
                </div> <!-- row -->
            </div> <!-- page-container -->
        </div> <!-- page-content -->

        <!-- Footer -->
        <?php include_once("footer.php");?>
		</div> 
		<!-- wrapper -->
		<!-- Edit Variation Modal -->
		<div class="modal fade" id="editVariationModal" tabindex="-1" aria-hidden="true">
		  <div class="modal-dialog">
			<form id="editVariationForm" enctype="multipart/form-data">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Edit Product Variation</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
				  <input type="hidden" id="edit_pcolor_id" name="pcolor_id">
				  <div class="mb-3">
					  <label class="form-label">Product</label>
					  <select id="edit_product_id" name="product_id" class="form-select" required>
						  <option value="">Select Product</option>
						  <?php
						  $products = mysqli_query($conn, "SELECT * FROM product_tbl WHERE status='Active'");
						  while($p = mysqli_fetch_assoc($products)){
							  echo '<option value="'.$p['product_id'].'">'.$p['title'].'</option>';
						  }
						  ?>
					  </select>
				  </div>
				  <div class="mb-3">
					  <label class="form-label">Color</label>
					  <select id="edit_color_id" name="color_id" class="form-select" required>
						  <option value="">Select Color</option>
						  <?php
						  $colors = mysqli_query($conn, "SELECT * FROM colour_tbl");
						  while($c = mysqli_fetch_assoc($colors)){
							  echo '<option value="'.$c['color_id'].'">'.$c['color_name'].'</option>';
						  }
						  ?>
					  </select>
				  </div>
				  <div class="mb-3">
					  <label class="form-label">Front Image</label>
					  <input type="file" id="edit_f_image" name="f_image" class="form-control">
					  <div id="current_f_image" class="mt-2"></div>
				  </div>
				  <div class="mb-3">
					  <label class="form-label">Back Image</label>
					  <input type="file" id="edit_b_image" name="b_image" class="form-control">
					  <div id="current_b_image" class="mt-2"></div>
				  </div>
				  <div class="mb-3">
					  <label class="form-label">Tryon Image</label>
					  <input type="file" id="edit_tryon_image" name="tryon_image" class="form-control">
					  <div id="current_tryon_image" class="mt-2"></div>
				  </div>
				  <div class="mb-3">
					  <label class="form-label">Stock Status</label>
					  <select id="edit_stock" name="stock" class="form-select">
						  <option value="Active">Active</option>
						  <option value="Inactive">Inactive</option>
					  </select>
				  </div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				  <button type="submit" class="btn btn-primary">Update Variation</button>
				</div>
			  </div>
			</form>
    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
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
	
<script>
$(document).ready(function() {

    // DELETE VARIATION
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This product variation will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "manage-product-variation.php?delete_id=" + id;
            }
        });
    });

    // STOCK TOGGLE
    $(document).on("change",".stockToggle",function(){
        let checkbox = $(this);
        let id = checkbox.data('id');
        let newStock = checkbox.is(':checked') ? "Active" : "Inactive";
        $.ajax({
            url:'manage-product-variation.php',
            type:'POST',
            data:{toggle_stock:1,pcolor_id:id,new_stock:newStock},
            dataType:'json',
            success:function(res){
                if(res.success){
                    Swal.fire({icon:"success",title:"Stock Updated",timer:800,showConfirmButton:false});
                } else {
                    Swal.fire('Error', res.message || 'Stock update failed!','error');
                    checkbox.prop('checked',!checkbox.is(':checked'));
                }
            },
            error:function(xhr){
                let msg = 'Server error!';
                try {
                    let response = JSON.parse(xhr.responseText);
                    if(response.message) msg = response.message;
                } catch(e){}
                Swal.fire('Error', msg,'error');
                checkbox.prop('checked',!checkbox.is(':checked'));
            }
        });
    });
    // OPEN EDIT MODAL
    $(document).on("click", ".edit-btn", function () {
        $("#edit_pcolor_id").val($(this).data("id"));
        $("#edit_product_id").val($(this).data("product"));
        $("#edit_color_id").val($(this).data("color"));
        $("#edit_stock").val($(this).data("stock"));

        // Show current images
        $("#current_f_image").html($(this).data("f_image") ? '<img src="'+$(this).data("f_image")+'" />' : '');
        $("#current_b_image").html($(this).data("b_image") ? '<img src="'+$(this).data("b_image")+'" />' : '');
        $("#current_tryon_image").html($(this).data("tryon_image") ? '<img src="'+$(this).data("tryon_image")+'" />' : '');

        new bootstrap.Modal(document.getElementById('editVariationModal')).show();
    });

    // UPDATE VARIATION (AJAX)
    $('#editVariationForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('update_variation', 1);

        $.ajax({
            url: 'manage-product-variation.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Variation Updated!',
                        timer: 900,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error','Update failed!','error');
                }
            }
        });
    });
 });
</script>

</body>
</html>