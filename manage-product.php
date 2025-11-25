<?php
include("connection.php");

// ADD PRODUCT
if (isset($_POST['add_product'])) {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $shape_id = $_POST['shape_id'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'] ?? '';

    mysqli_query($conn, "INSERT INTO product_tbl (title, category_id, shape_id, gender, size, price, status, description)  VALUES ('$title', $category_id, $shape_id, '$gender', '$size', $price, '$status', '$description')");
    header("Location: manage-product.php");
    exit;
}

// UPDATE PRODUCT via AJAX
if (isset($_POST['update_product'])) {
    $id = intval($_POST['product_id']);
    $title = $_POST['title'];
    $category_id = intval($_POST['category_id']);
    $shape_id = intval($_POST['shape_id']);
    $description = $_POST['description'] ?? '';
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $price = floatval($_POST['price']);
    $status = $_POST['status'];

    $update = mysqli_query($conn, "UPDATE product_tbl SET 
        title='$title', 
        category_id=$category_id, 
        shape_id=$shape_id, 
        description='$description', 
        gender='$gender', 
        size='$size', 
        price=$price, 
        status='$status' 
        WHERE product_id=$id");

    echo json_encode(['success' => $update ? true : false]);
    exit;
}

// TOGGLE STATUS via AJAX
if (isset($_POST['toggle_status'])) {
    $id = intval($_POST['product_id']);
    $status = $_POST['status'];
    $update = mysqli_query($conn, "UPDATE product_tbl SET status='$status' WHERE product_id=$id");
    echo json_encode(['success' => $update ? true : false]);
    exit;
}

// DELETE PRODUCT
if (isset($_GET['product-id'])) {
    $id = intval($_GET['product-id']);
    mysqli_query($conn, "DELETE FROM product_tbl WHERE product_id=$id");
    header("Location: manage-product.php");
    exit;
}

// FETCH PRODUCTS
$sql="SELECT * FROM product_tbl";
$product_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto | Manage Product</title>
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
                            <h4 class="header-title mb-2">Manage Product</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Shape</th>
                                        <th>Description</th>
                                        <th>Gender</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($p = mysqli_fetch_assoc($product_result)) { 
                                    $cat_name = "";
                                    if (!empty($p['category_id'])) {
                                        $c = mysqli_query($conn, "SELECT c_name FROM category_tbl WHERE category_id={$p['category_id']}");
                                        $cat_row = mysqli_fetch_assoc($c);
                                        $cat_name = $cat_row['c_name'];
                                    }
                                    $shape_name = "";
                                    if (!empty($p['shape_id'])) {
                                        $s = mysqli_query($conn, "SELECT s_name FROM shape_tbl WHERE shape_id={$p['shape_id']}");
                                        $sh_row = mysqli_fetch_assoc($s);
                                        $shape_name = $sh_row['s_name'];
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $p['product_id']; ?></td>
                                    <td><?php echo htmlspecialchars($p['title']); ?></td>
                                    <td><?php echo $cat_name; ?></td>
                                    <td><?php echo $shape_name; ?></td>
                                    <td><?php echo htmlspecialchars($p['description']); ?></td>
                                    <td><?php echo $p['gender']; ?></td>
                                    <td><?php echo $p['size']; ?></td>
                                    <td>₹<?php echo number_format($p['price'], 2); ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="statusToggle" data-id="<?php echo $p['product_id']; ?>" <?php echo ($p['status']=="Active") ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="#" class="edit-btn"
                                           data-id="<?php echo $p['product_id']; ?>"
                                           data-title="<?php echo htmlspecialchars($p['title']); ?>"
                                           data-category="<?php echo $p['category_id']; ?>"
                                           data-shape="<?php echo $p['shape_id']; ?>"
                                           data-description="<?php echo htmlspecialchars($p['description']); ?>"
                                           data-gender="<?php echo trim($p['gender']); ?>"
                                           data-size="<?php echo trim($p['size']); ?>"
                                           data-price="<?php echo $p['price']; ?>"
                                           data-status="<?php echo $p['status']; ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        &nbsp; | &nbsp;
                                        <a href="#" class="delete-btn" data-id="<?php echo $p['product_id']; ?>">
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

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editProductForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_product_id" name="product_id">

          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="edit_title" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea id="edit_description" name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Category</label>
            <select id="edit_category" name="category_id" class="form-select" required>
              <option value="">Select Category</option>
              <?php
              $categories = mysqli_query($conn, "SELECT * FROM category_tbl WHERE status='Active'");
              while($cat = mysqli_fetch_assoc($categories)){
                  echo '<option value="'.$cat['category_id'].'">'.$cat['c_name'].'</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Shape</label>
            <select id="edit_shape" name="shape_id" class="form-select" required>
              <option value="">Select Shape</option>
              <?php
              $shapes = mysqli_query($conn, "SELECT * FROM shape_tbl WHERE status='Active'");
              while($sh = mysqli_fetch_assoc($shapes)){
                  echo '<option value="'.$sh['shape_id'].'">'.$sh['s_name'].'</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Gender</label>
            <select id="edit_gender" name="gender" class="form-select" required>
              <option value="Men">Men</option>
              <option value="Women">Women</option>
              <option value="Kids">Kids</option>
              <option value="All">All</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Size</label>
            <select id="edit_size" name="size" class="form-select" required>
              <option>Extra Narrow</option>
              <option>Narrow</option>
              <option>Regular</option>
              <option>Medium</option>
              <option>Wide</option>
              <option>Extra Wide</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" id="edit_price" name="price" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select id="edit_status" name="status" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Product</button>
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

    // TOGGLE STATUS
    $(document).on("change", ".statusToggle", function () {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? "Active" : "Inactive";

        $.ajax({
            url: 'manage-product.php',
            type: 'POST',
            data: { toggle_status: 1, product_id: id, status: status },
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

    // OPEN EDIT MODAL
    $(document).on("click", ".edit-btn", function () {
        $("#edit_product_id").val($(this).data("id"));
        $("#edit_title").val($(this).data("title"));
        $("#edit_category").val($(this).data("category"));
        $("#edit_shape").val($(this).data("shape"));
        $("#edit_description").val($(this).data("description"));
        $("#edit_gender").val($(this).data("gender"));
        $("#edit_size").val($(this).data("size"));
        $("#edit_price").val($(this).data("price"));
        $("#edit_status").val($(this).data("status"));

        new bootstrap.Modal(document.getElementById('editProductModal')).show();
    });

    // UPDATE PRODUCT (AJAX)
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'manage-product.php',
            type: 'POST',
            data: $(this).serialize() + '&update_product=1',
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Product Updated!',
                        timer: 900,
                        showConfirmButton: false
                    });

                    let id = $('#edit_product_id').val();
                    let row = $(`tr td:first-child:contains(${id})`).closest("tr");

                    row.find('td:nth-child(2)').text($('#edit_title').val());
                    row.find('td:nth-child(3)').text($('#edit_category option:selected').text());
                    row.find('td:nth-child(4)').text($('#edit_shape option:selected').text());
                    row.find('td:nth-child(5)').text($('#edit_description').val());
                    row.find('td:nth-child(6)').text($('#edit_gender').val());
                    row.find('td:nth-child(7)').text($('#edit_size').val());
                    row.find('td:nth-child(8)').text("₹" + parseFloat($('#edit_price').val()).toFixed(2));

                    let newStatus = $('#edit_status').val();
                    let toggle = row.find('.statusToggle');
                    toggle.prop("checked", newStatus === "Active");

                    row.find('.edit-btn')
                        .data("title", $('#edit_title').val())
                        .data("category", $('#edit_category').val())
                        .data("shape", $('#edit_shape').val())
                        .data("description", $('#edit_description').val())
                        .data("gender", $('#edit_gender').val())
                        .data("size", $('#edit_size').val())
                        .data("price", $('#edit_price').val())
                        .data("status", newStatus);

                    $('#editProductModal').modal('hide');
                }
            }
        });
    });

});
</script>

</body>
</html>
