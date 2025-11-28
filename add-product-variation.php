<?php
include("connection.php");

// Initialize variables
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$product_id = $color_id = $stock = "";
$f_image = $b_image = $tryon_image = "";

// Message variables
$message = "";
$message_type = "";

// Fetch products and colors for dropdown
$productQuery = mysqli_query($conn, "SELECT * FROM product_tbl WHERE status='Active'");
$colorQuery = mysqli_query($conn, "SELECT * FROM colour_tbl ORDER BY color_name ASC");

// Edit mode: fetch existing variation
if ($edit_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM product_colors_tbl WHERE pcolor_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $product_id = $row['product_id'];
        $color_id = $row['color_id'];
        $stock = $row['stock'];
        $f_image = $row['f_image'];
        $b_image = $row['b_image'];
        $tryon_image = $row['tryon_image'];
    }
    $stmt->close();
}

// Handle Add/Edit form submission
if (isset($_POST['submit'])) {

    $product_id = $_POST['product_id'];
    $color_id = $_POST['color_id'];
    $stock = $_POST['stock_status'];

    // Server-side validation
    if (empty($product_id) || empty($color_id) || empty($stock)) {
        $message = "Please fill all required fields.";
        $message_type = "error";
    } else {

        // --- Handle Images ---
        $uploadDir = "uploads/";

        // Front Image
        if (isset($_FILES['f_image']) && $_FILES['f_image']['name'] != '') {
            $f_image = $uploadDir . time() . '_f_' . basename($_FILES['f_image']['name']);
            if (!move_uploaded_file($_FILES['f_image']['tmp_name'], $f_image)) {
                $message = "Error uploading Front Image.";
                $message_type = "error";
            }
        }

        // Back Image
        if (isset($_FILES['b_image']) && $_FILES['b_image']['name'] != '') {
            $b_image = $uploadDir . time() . '_b_' . basename($_FILES['b_image']['name']);
            if (!move_uploaded_file($_FILES['b_image']['tmp_name'], $b_image)) {
                $message = "Error uploading Back Image.";
                $message_type = "error";
            }
        }

        // Tryon Image
        if (isset($_FILES['tryon_image']) && $_FILES['tryon_image']['name'] != '') {
            $tryon_image = $uploadDir . time() . '_t_' . basename($_FILES['tryon_image']['name']);
            if (!move_uploaded_file($_FILES['tryon_image']['tmp_name'], $tryon_image)) {
                $message = "Error uploading Tryon Image.";
                $message_type = "error";
            }
        }

        // Insert/Update only if no upload errors
        if ($message_type != "error") {
            if ($edit_id > 0) {
                // Update existing variation
                $stmt = $conn->prepare("UPDATE product_colors_tbl SET product_id=?, color_id=?, f_image=?, b_image=?, tryon_image=?, stock=? WHERE pcolor_id=?");
                $stmt->bind_param("iissssi", $product_id, $color_id, $f_image, $b_image, $tryon_image, $stock, $edit_id);
                if ($stmt->execute()) {
                    $message = "Product variation updated successfully.";
                    $message_type = "success";
                } else {
                    $message = "Database error: " . $stmt->error;
                    $message_type = "error";
                }
                $stmt->close();
            } else {
                // Insert new variation
                $stmt = $conn->prepare("INSERT INTO product_colors_tbl (product_id, color_id, f_image, b_image, tryon_image, stock) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iissss", $product_id, $color_id, $f_image, $b_image, $tryon_image, $stock);
                if ($stmt->execute()) {
                    $message = "Product variation added successfully.";
                    $message_type = "success";
                } else {
                    $message = "Database error: " . $stmt->error;
                    $message_type = "error";
                }
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Add Product Variation</title>
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
            .switch {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 24px;
            }
            .switch input { display: none; }
            .slider {
                position: absolute;
                cursor: pointer;
                background-color: #ccc;
                border-radius: 34px;
                top: 0; left: 0; right: 0; bottom: 0;
                transition: .4s;
            }
            .slider:before {
                content: "";
                position: absolute;
                height: 18px; width: 18px;
                left: 3px; bottom: 3px;
                background: #fff;
                border-radius: 50%;
                transition: .4s;
            }
            input:checked + .slider { background-color: #28a745; }
            input:checked + .slider:before { transform: translateX(26px); }
			
			/* Error messages */
			.error-msg {
				color: red;
				font-size: 13px;
				margin-top: 3px;
				display: block;
			}

			/* Red border + background on invalid fields */
			.input-error {
				border: 1px solid red !important;
			}	
        </style>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom border-dashed d-flex align-items-center">
                                 <h2 class="header-title">Add Product Variation</h2>
                            </div>
                            <div class="card-body">
							<form method="POST" id="pcolorForm" enctype="multipart/form-data">
                                <!-- Product -->
                                <div class="mb-3">
                                    <label class="form-label">Product</label>
                                    <select class="form-select" id="product_id" name="product_id">
                                        <option value="">Select Product</option>
                                        <?php while($prod = mysqli_fetch_assoc($productQuery)) { ?>
                                            <option value="<?= $prod['product_id'] ?>" <?= ($prod['product_id'] == $product_id) ? 'selected' : '' ?>><?= $prod['title'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-msg" id="productError"></span>
                                </div>

                                <!-- Color -->
                                <div class="mb-3">
                                    <label class="form-label">Color</label>
                                    <select class="form-select" id="color_id" name="color_id">
                                        <option value="">Select Color</option>
                                        <?php while($clr = mysqli_fetch_assoc($colorQuery)) { ?>
                                            <option value="<?= $clr['color_id'] ?>" <?= ($clr['color_id'] == $color_id) ? 'selected' : '' ?>><?= $clr['color_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-msg" id="colorError"></span>
                                </div>

                                <!-- Front Image -->
                                <div class="mb-3">
                                    <label class="form-label">Front Image</label>
                                    <input type="file" class="form-control" id="f_image" name="f_image" accept="image/*">
                                </div>

                                <!-- Back Image -->
                                <div class="mb-3">
                                    <label class="form-label">Back Image</label>
                                    <input type="file" class="form-control" id="b_image" name="b_image" accept="image/*">
                                </div>

                                <!-- Tryon Image -->
                                <div class="mb-3">
                                    <label class="form-label">Tryon Image</label>
                                    <input type="file" class="form-control" id="tryon_image" name="tryon_image" accept="image/*">
                                </div>

                                <!-- Stock Status -->
                                <div class="mb-3">
                                    <label class="form-label">Stock Status</label>
                                    <select class="form-select" id="stock_status" name="stock_status">
                                        <option value="">Select Stock Status</option>
                                        <option value="Active" <?= ($stock=='Active')?'selected':'' ?>>Active</option>
                                        <option value="Inactive" <?= ($stock=='Inactive')?'selected':'' ?>>Inactive</option>
                                    </select>
                                    <span class="error-msg" id="stockStatusError"></span>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary w-10"><?= $edit_id ? "Update" : "Add" ?> Product Variation</button>
                            </form>
                            </div> 
                        </div> <!-- end card-->
                    </div> <!-- end col-->
  
                </div>
                <!-- end row -->

            </div> <!-- container -->
            <!-- Footer Start -->
                <?php 
					include 'footer.php';
				?>
                <!-- end Footer -->				
        </div>
		<script>
		// Form validation and auto-clear
		const form = document.getElementById('pcolorForm');

		// Map each field to its error span
		const fields = {
			product_id: 'productError',
			color_id: 'colorError',
			stock_status: 'stockStatusError',
			f_image: 'fImageError',
			b_image: 'bImageError',
			//tryon_image: 'tryonImageError'
		};

		// Optional: Add error spans dynamically for file inputs
		['f_image', 'b_image'].forEach(id => {
			const input = document.getElementById(id);
			let span = document.createElement('span');
			span.className = 'error-msg';
			span.id = fields[id];
			input.parentNode.appendChild(span);
		});

		form.addEventListener('submit', function(e) {
			let valid = true;

			// Clear previous errors
			Object.keys(fields).forEach(key => {
				document.getElementById(fields[key]).innerText = '';
				document.getElementById(key).classList.remove('input-error');
			});

			// Validation for select fields
			if (document.getElementById('product_id').value === '') {
				document.getElementById('productError').innerText = 'Please select a product';
				document.getElementById('product_id').classList.add('input-error');
				valid = false;
			}
			if (document.getElementById('color_id').value === '') {
				document.getElementById('colorError').innerText = 'Please select a color';
				document.getElementById('color_id').classList.add('input-error');
				valid = false;
			}
			if (document.getElementById('stock_status').value === '') {
				document.getElementById('stockStatusError').innerText = 'Please select stock status';
				document.getElementById('stock_status').classList.add('input-error');
				valid = false;
			}

			// Validation for file inputs
			const fileFields = ['f_image', 'b_image']; //'tryon_image'
			fileFields.forEach(fileId => {
				const fileInput = document.getElementById(fileId);
				if (fileInput && fileInput.files.length === 0) {
					document.getElementById(fields[fileId]).innerText = 'Please upload a file';
					fileInput.classList.add('input-error');
					valid = false;
				} else if (fileInput.files.length > 0) {
					const file = fileInput.files[0];
					const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
					if (!allowedTypes.includes(file.type)) {
						document.getElementById(fields[fileId]).innerText = 'Only JPG, PNG, or WEBP files allowed';
						fileInput.classList.add('input-error');
						valid = false;
					} else if (file.size > 2 * 1024 * 1024) { // 2MB limit
						document.getElementById(fields[fileId]).innerText = 'File size must be less than 2MB';
						fileInput.classList.add('input-error');
						valid = false;
					}
				}
			});

			if (!valid) e.preventDefault(); // Stop form submission
		});

		// Auto-remove error when user interacts
		Object.keys(fields).forEach(key => {
			const el = document.getElementById(key);
			el.addEventListener('input', clearError);
			el.addEventListener('change', clearError);

			function clearError() {
				document.getElementById(fields[key]).innerText = '';
				el.classList.remove('input-error');
			}
		});

		</script>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        <!-- Wraper class div -->
        </div>
         <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- Apex Chart js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <!-- Projects Analytics Dashboard App js -->
        <script src="assets/js/pages/dashboard.js"></script> 
	
		
<?php if (!empty($message)): ?>
<script>
Swal.fire({
    icon: '<?= $message_type ?>',
    title: '<?= ($message_type === "success") ? "Success" : "Error" ?>',
    text: "<?= $message ?>",
    confirmButtonText: 'OK'
}).then(() => {
    <?php if($message_type === 'success' && !$edit_id): ?>
        document.getElementById("pcolorForm").reset();
    <?php elseif($message_type === 'success' && $edit_id): ?>
        window.location.href = "manage-product-variation.php";
    <?php endif; ?>
});
</script>
<?php endif; ?>
		
</body>
</html> 