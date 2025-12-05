<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
// AJAX delete review (same page)
if (isset($_POST['delete_review_id'])) {
    $id = intval($_POST['delete_review_id']);

    $delete = mysqli_query($conn, "DELETE FROM review_tbl WHERE review_id = $id");

    if ($delete) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Reviews</title>
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
		   .icon-delete {
			background: none;
			border: none;
			color: #1e88e5; /* blue */
			font-size: 16px;
			cursor: pointer;
			padding: 4px 6px;
		}

		.icon-delete:hover {
			color: #d32f2f; /* red on hover */
			transform: scale(1.1);
		}

		.icon-delete:focus {
			outline: none;
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

                    
                    <!-- <h1>Manage State</h1> -->
                    <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom border-dashed">
                                <h4 class="header-title mb-2">Manage Reviews</h4>
                                <p class="text-muted mb-0">
                                   
                                </p>
                            </div>
                            <div class="card-body">
								<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
									<thead>
										<tr>
											<th>ID</th>
											<th>User</th>
											<th>Product</th>
											<th>Rating</th>
											<th>Review</th>
											<th>Created At</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query = "
											SELECT 
												r.review_id,
												r.rating,
												r.review_text,
												r.created_at,
												u.name AS user_name,
												p.title AS product_title
											FROM review_tbl r
											LEFT JOIN user_tbl u ON r.user_id = u.user_id
											LEFT JOIN product_tbl p ON r.product_id = p.product_id
											ORDER BY r.created_at DESC
										";

										$result = mysqli_query($conn, $query);

										if ($result && mysqli_num_rows($result) > 0) {
											while ($row = mysqli_fetch_assoc($result)) {
												?>
												<tr>
													<td><?= $row['review_id']; ?></td>

													<td><?= htmlspecialchars($row['user_name'] ?? 'Unknown'); ?></td>

													<td><?= htmlspecialchars($row['product_title'] ?? 'Deleted Product'); ?></td>

													<td>
														<?php
														for ($i = 1; $i <= 5; $i++) {
															echo ($i <= $row['rating'])
																? '<i class="fa-solid fa-star text-warning"></i>'
																: '<i class="fa-regular fa-star text-muted"></i>';
														}
														?>
													</td>

													<td><?= htmlspecialchars($row['review_text']); ?></td>

													<td><?= date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>

													<td>
											<button 
											class="delete-review icon-delete"
											data-id="<?= $row['review_id']; ?>"
											title="Delete">
											<i class="fa-solid fa-trash"></i>
										</button>
										</td>
												</tr>
												<?php
											}
										} else {
											echo "<tr><td colspan='7' class='text-center'>No reviews found</td></tr>";
										}
										?>
									</tbody>
								</table>


                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div> <!-- end row-->
                   
                </div> <!-- container -->

                <!-- Footer Start -->
                <?php include_once("footer.php");?>
                <!-- end Footer -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
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
			document.addEventListener("DOMContentLoaded", function () {
				document.querySelectorAll(".delete-review").forEach(button => {
					button.addEventListener("click", function () {
						let reviewId = this.getAttribute("data-id");

						Swal.fire({
							title: "Are you sure?",
							text: "This review will be permanently deleted!",
							icon: "warning",
							showCancelButton: true,
							confirmButtonColor: "#d33",
							confirmButtonText: "Yes, delete it!"
						}).then((result) => {
							if (result.isConfirmed) {
								fetch("manage-reviews.php", {
									method: "POST",
									headers: {
										"Content-Type": "application/x-www-form-urlencoded"
									},
									body: "delete_review_id=" + reviewId
								})
								.then(res => res.text())
								.then(data => {
									if (data.trim() === "success") {
										Swal.fire("Deleted!", "Review deleted successfully.", "success");
										button.closest("tr").remove(); // remove row
									} else {
										Swal.fire("Error!", "Delete failed.", "error");
									}
								});
							}
						});
					});
				});
			});
</script>
</body>
</html>