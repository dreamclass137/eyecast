<?php
include "connection.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// ===================== INITIAL VALUES =====================
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$category_name = "";
$categoryErrorMessage = "";

// ===================== FETCH FOR EDIT =====================
if ($edit_id > 0) {
    $res = mysqli_query($conn, "SELECT * FROM category_tbl WHERE category_id = $edit_id");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $category_name = $row['c_name'];
    } else {
        die("Category not found!");
    }
}

// ===================== SUBMIT (INSERT / UPDATE) =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['c_name']);
    $edit_id = intval($_POST['edit_id']);

    if ($name == "") {
        $categoryErrorMessage = "Please enter category name";
    } else {
        // ===================== DUPLICATE CHECK (CASE-INSENSITIVE) =====================
        if ($edit_id > 0) {
            $q = mysqli_query($conn, "SELECT * FROM category_tbl WHERE LOWER(c_name) = LOWER('$name') AND category_id != $edit_id");
        } else {
            $q = mysqli_query($conn, "SELECT * FROM category_tbl WHERE LOWER(c_name) = LOWER('$name')");
        }

        if (!$q) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($q) > 0) {
            $categoryErrorMessage = "Category already exists!";
        } else {
           // ===================== UPDATE =====================
			if ($edit_id > 0) {
				mysqli_query($conn, "UPDATE category_tbl SET c_name='$name' WHERE category_id = $edit_id");
				header("Location: add-category.php?msg=updated");
				exit;
			}

			// ===================== INSERT =====================
			mysqli_query($conn, "INSERT INTO category_tbl (c_name) VALUES ('$name')");
			header("Location: add-category.php?msg=inserted");
			exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Add Category</title>
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
								<input type="hidden" name="edit_id" id="edit_id" value="<?= $edit_id ?>">

								<!-- Category Name -->
								<div class="mb-3">
									<label for="c_name" class="form-label">Category Name</label>
									<input type="text" class="form-control" id="c_name" name="c_name" 
										   value="<?= htmlspecialchars($category_name) ?>">
									<div class="error-message" id="categoryNameError" style="color:red;">
										<?= $categoryErrorMessage ?>
									</div>
								</div>

								<button type="submit" class="btn btn-primary">
									<?= $edit_id > 0 ? 'Update Category' : 'Add Category' ?>
								</button>
							</form>
			
                            </div> 
                        </div> <!-- end card-->
                    </div> <!-- end col-->
  
                </div>
                <!-- end row -->

            </div> <!-- container ->
			
			<!-- ===================== SWEETALERT ===================== -->
			
			<?php if (isset($_GET['msg']) && $_GET['msg'] == 'inserted'): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: 'Category Added Successfully!',
				confirmButtonColor: '#28a745', 
				confirmButtonText: 'OK'
			}).then(() => {
				window.location = 'manage-category.php';
			});
			</script>
			<?php endif; ?>

			<?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: 'Category Updated Successfully!',
				confirmButtonColor: '#28a745', 
				confirmButtonText: 'OK'
			}).then(() => {
				window.location = 'manage-category.php';
			});
			</script>
			<?php endif; ?>

			
            <!-- Footer Start -->
            <?php 
				include_once("footer.php");
			?>
            <!-- end Footer -->
        </div>
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
		
		<!-- ===================== JS VALIDATIONS + AJAX ===================== -->
<script>
window.onload = () => {
    const form = document.getElementById("categoryForm");
    const nameInput = document.getElementById("c_name");
    const errorBox = document.getElementById("categoryNameError");
    const editId = document.getElementById("edit_id").value;

    // Check empty field
    function checkEmpty() {
        if (nameInput.value.trim() === "") {
            errorBox.innerText = "Please enter category name";
            nameInput.style.borderColor = "red";
            return false;
        }
        return true;
    }

    // AJAX duplicate check (case insensitive)
    async function checkDuplicate() {
    let name = nameInput.value.trim();
    if (name === "") return false;

    let res = await fetch(`check_category.php?name=${name}&edit_id=${editId}`);
    let txt = await res.text();

    if (txt === "exists") {
        errorBox.innerText = "Category already exists!";
        nameInput.style.borderColor = "red";
        return false;
    }

    errorBox.innerText = "";
    nameInput.style.borderColor = "green";
    return true;
}

    // Live validation while typing
    nameInput.addEventListener('keyup', async () => {
        checkEmpty();
        await checkDuplicate();
    });

    // Form submit
    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        if (!checkEmpty()) return;
        if (!await checkDuplicate()) return;

        // ✅ Submit if valid
        form.submit();
    });
};
</script>
	</body>
</html>