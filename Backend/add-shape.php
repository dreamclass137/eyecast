<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
// ===================== INITIAL VALUES =====================
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$shape_name = "";
$shapeErrorMessage = "";

// ===================== FETCH FOR EDIT =====================
if ($edit_id > 0) {
    $res = mysqli_query($conn, "SELECT * FROM shape_tbl WHERE shape_id = $edit_id");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $shape_name = $row['s_name'];
    } else {
        die("Shape not found!");
    }
}

// ===================== SUBMIT (INSERT / UPDATE) =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['s_name']);
    $edit_id = intval($_POST['edit_id']);

    if ($name == "") {
        $shapeErrorMessage = "Please enter shape name";
    } else {
        // ===================== DUPLICATE CHECK (CASE-INSENSITIVE) =====================
        if ($edit_id > 0) {
            $q = mysqli_query($conn, "SELECT * FROM shape_tbl WHERE LOWER(s_name) = LOWER('$name') AND shape_id != $edit_id");
        } else {
            $q = mysqli_query($conn, "SELECT * FROM shape_tbl WHERE LOWER(s_name) = LOWER('$name')");
        }

        if (!$q) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($q) > 0) {
            $shapeErrorMessage = "Shape already exists!";
        } else {
            // ===================== UPDATE =====================
            if ($edit_id > 0) {
                mysqli_query($conn, "UPDATE shape_tbl SET s_name='$name' WHERE shape_id = $edit_id");
                header("Location: add-shape.php?msg=updated");
                exit;
            }

            // ===================== INSERT =====================
            mysqli_query($conn, "INSERT INTO shape_tbl (s_name) VALUES ('$name')");
            header("Location: add-shape.php?msg=inserted");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />shape
        <title>Adminto | Add </title>
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
                                 <h2 class="header-title">Add Shape</h2>
                            </div>
                            <div class="card-body">
                             <form id="shapeForm" method="POST">
                                <input type="hidden" name="edit_id" id="edit_id" value="<?= $edit_id ?>">

                                <!-- Shape Name -->
                                <div class="mb-3">
                                    <label for="s_name" class="form-label">Shape Name</label>
                                    <input type="text" class="form-control" id="s_name" name="s_name" 
                                           value="<?= htmlspecialchars($shape_name) ?>">
                                    <div class="error-message" id="shapeNameError" style="color:red;">
                                        <?= $shapeErrorMessage ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <?= $edit_id > 0 ? 'Update Shape' : 'Add Shape' ?>
                                </button>
                            </form>

                            </div> 
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row -->
            </div> <!-- container -->
				
			 <!-- SweetAlert -->
			<?php if (isset($_GET['msg']) && $_GET['msg'] == 'inserted'): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: 'Shape Added Successfully!',
				confirmButtonColor: '#28a745', 
				confirmButtonText: 'OK'
			}).then(() => {
				window.location = 'manage-shape.php';
			});
			</script>
			<?php endif; ?>

			<?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: 'Shape Updated Successfully!',
				confirmButtonColor: '#28a745', 
				confirmButtonText: 'OK'
			}).then(() => {
				window.location = 'manage-shape.php';
			});
			</script>
			<?php endif; ?>
			
            <!-- Footer Start -->
                <?php include_once("footer.php");?>
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
		
		
<script>
window.onload = () => {
    const form = document.getElementById("shapeForm");
    const nameInput = document.getElementById("s_name");
    const errorBox = document.getElementById("shapeNameError");
    const editId = document.getElementById("edit_id").value;

    function checkEmpty() {
        if (nameInput.value.trim() === "") {
            errorBox.innerText = "Please enter shape name";
            nameInput.style.borderColor = "red";
            return false;
        }
        return true;
    }

    async function checkDuplicate() {
        let name = nameInput.value.trim();
        if (name === "") return false;

        let res = await fetch(`check_shape.php?name=${name}&edit_id=${editId}`);
        let txt = await res.text();

        if (txt === "exists") {
            errorBox.innerText = "Shape already exists!";
            nameInput.style.borderColor = "red";
            return false;
        }

        errorBox.innerText = "";
        nameInput.style.borderColor = "green";
        return true;
    }

    nameInput.addEventListener('keyup', async () => {
        checkEmpty();
        await checkDuplicate();
    });

    form.addEventListener("submit", async function(e) {
        e.preventDefault();
        if (!checkEmpty()) return;
        if (!await checkDuplicate()) return;
        form.submit();
    });
};
</script>
	</body>
</html>