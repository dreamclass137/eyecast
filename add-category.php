<?php
include "connection.php";

$message = '';
$message_type = '';
$category_name = '';
$status = '';
$edit_id = 0;
$categoryErrorMessage = ''; // For inline PHP errors

// Check if edit ID is passed
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_sql = "SELECT * FROM category_tbl WHERE category_id = $edit_id LIMIT 1";
    $result = mysqli_query($conn, $edit_sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_name = $row['c_name'];
        $status = $row['status'];
    } else if ($edit_id > 0) {
        $categoryErrorMessage = 'Category not found!';
        $edit_id = 0; // reset edit_id to allow new category
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim(mysqli_real_escape_string($conn, $_POST['title'] ?? ''));
    $status = trim(mysqli_real_escape_string($conn, $_POST['status'] ?? ''));
    $edit_id = intval($_POST['edit_id'] ?? 0);

    if ($category_name === '' || $status === '') {
        $message = 'Please fill in all fields!';
        $message_type = 'warning';
    } else {
        // Check for duplicate category
        $check_sql = "SELECT * FROM category_tbl WHERE c_name = '$category_name'";
        if ($edit_id > 0) {
            $check_sql .= " AND category_id != $edit_id";
        }
        $check_result = mysqli_query($conn, $check_sql);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $message = 'Category already exists!';
            $message_type = 'error';
        } else {
            if ($edit_id > 0) {
                // Update existing category
                $update_sql = "UPDATE category_tbl SET c_name='$category_name', status='$status' WHERE category_id=$edit_id";
                if (mysqli_query($conn, $update_sql)) {
                    $message = 'Category updated successfully!';
                    $message_type = 'success';
                } else {
                    $message = 'Database error: ' . mysqli_error($conn);
                    $message_type = 'error';
                }
            } else {
                // Insert new category
                $insert_sql = "INSERT INTO category_tbl (c_name, status) VALUES ('$category_name', '$status')";
                if (mysqli_query($conn, $insert_sql)) {
                    $message = 'Category added successfully!';
                    $message_type = 'success';
                    $category_name = '';
                    $status = '';
                } else {
                    $message = 'Database error: ' . mysqli_error($conn);
                    $message_type = 'error';
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Add Product</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
		
		<style>
		/* Error style */
		.input-error {
			border-color: #dc3545;
		}
		.error-message {
			color: #dc3545;
			font-size: 0.85em;
			margin-top: 0.25rem;
		}
		/* Success style */
		.input-success {
			border-color: #28a745;
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
                                 <h2 class="header-title">Add Category</h2>
                            </div>
                            <div class="card-body">
                              <form id="categoryForm" method="POST">
								<input type="hidden" name="edit_id" value="<?= $edit_id ?>">

								<!-- Category Name -->
								<div class="mb-3">
									<label for="c_name" class="form-label">Category Name</label>
									<input type="text" class="form-control" id="c_name" name="title" value="<?= htmlspecialchars($category_name) ?>">
									<div class="error-message" id="categoryNameError"><?= $categoryErrorMessage ?></div>
								</div>

								<!-- Status -->
								<div class="mb-3">
									<label for="statusSelect" class="form-label">Status</label>
									<select name="status" id="statusSelect" class="form-select">
										<option value="" hidden>Select Status</option>
										<option value="Active" <?= $status === 'Active' ? 'selected' : '' ?>>Active</option>
										<option value="Inactive" <?= $status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
									</select>
									<div class="error-message" id="statusError"></div>
								</div>

								<button type="submit" class="btn btn-primary"><?= $edit_id > 0 ? 'Update Category' : 'Add Category' ?></button>
							</form>


                            </div> 
                        </div> <!-- end card-->
                    </div> <!-- end col-->
  
                </div>
                <!-- end row -->

            </div> <!-- container -->
            <!-- Footer Start -->
                <?php include_once("footer.php");?>
                <!-- end Footer -->
        </div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/js/app.js"></script>

		<script>
		// JS Validation
		const form = document.getElementById('categoryForm');
		const categoryInput = document.getElementById('c_name');
		const statusSelect = document.getElementById('statusSelect');
		const categoryError = document.getElementById('categoryNameError');
		const statusError = document.getElementById('statusError');

		form.addEventListener('submit', function(e) {
			e.preventDefault();
			let isValid = true;

			// Reset styles
			categoryInput.classList.remove('input-error','input-success');
			statusSelect.classList.remove('input-error','input-success');
			categoryError.innerText = '';
			statusError.innerText = '';

			// Validate Category
			if (!categoryInput.value.trim()) {
				categoryError.innerText = 'Please enter category name';
				categoryInput.classList.add('input-error');
				isValid = false;
			} else {
				categoryInput.classList.add('input-success');
			}

			// Validate Status
			if (!statusSelect.value.trim()) {
				statusError.innerText = 'Please select a status';
				statusSelect.classList.add('input-error');
				isValid = false;
			} else {
				statusSelect.classList.add('input-success');
			}

			if (isValid) {
				form.submit();
			}
		});

		// Live validation
		categoryInput.addEventListener('input', () => {
			categoryInput.classList.remove('input-error');
			categoryError.innerText = '';
		});
		statusSelect.addEventListener('change', () => {
			statusSelect.classList.remove('input-error');
			statusError.innerText = '';
		});
		</script>

		<?php if(!empty($message)): ?>
		<script>
		Swal.fire({
			icon: '<?= $message_type ?>',
			title: '<?= $message ?>',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'OK'
		}).then(() => {
			<?php if($message_type === 'success' && !$edit_id): ?>
			document.getElementById('categoryForm').reset();
			<?php endif; ?>
		});
		</script>
		<?php endif; ?>

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
</body>
</html>