<?php
include "connection.php"; // Your database connection file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Manage Orders</title>
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
                                <h4 class="header-title mb-2">Manage Orders</h4>
                                <p class="text-muted mb-0">
                                    The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page
                                    that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                                </p>
                            </div>
                            <div class="card-body">
							<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
								<thead>
									<tr>
										<th>#</th>
										<th>User</th>
										<th>Address</th>
										<th>Total Amount</th>
										<th>Payment Status</th>
										<th>Order Status</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT * FROM order_tbl ORDER BY order_id DESC";
									$result = mysqli_query($conn, $sql);
									$sn = 1;

									if($result){
										while($row = mysqli_fetch_assoc($result)){
											// Fetch user name from user_tbl
											$user_id = $row['user_id'];
											$userResult = mysqli_query($conn, "SELECT name FROM user_tbl WHERE user_id = $user_id");
											$userName = mysqli_fetch_assoc($userResult)['name'];

											// Fetch address from address_tbl
											$address_id = $row['address_id'];
											$addressResult = mysqli_query($conn, "SELECT address, city, state, pincode FROM address_tbl WHERE address_id = $address_id");
											$addressRow = mysqli_fetch_assoc($addressResult);
											$fullAddress = $addressRow['address'] . 
														   (!empty($addressRow['city']) ? ', '.$addressRow['city'] : '') . 
														   (!empty($addressRow['state']) ? ', '.$addressRow['state'] : '') . 
														   (!empty($addressRow['pincode']) ? ' - '.$addressRow['pincode'] : '');
											echo "<tr>";
											echo "<td>{$sn}</td>";
											echo "<td>{$userName}</td>";
											echo "<td>{$fullAddress}</td>";
											echo "<td>{$row['total_amount']}</td>";
											echo "<td>{$row['payment_status']}</td>";
											echo "<td>{$row['order_status']}</td>";
											echo "<td>{$row['created_at']}</td>";
											// Plain delete icon
											echo "<td>
													<a href='delete_order.php?order_id={$row['order_id']}'>
														<i class='fa-solid fa-trash'></i>
													</a>
													
												  </td>";
											echo "</tr>";
											$sn++;
										}
									} else {
										echo "<tr><td colspan='8'>No orders found</td></tr>";
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
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- Apex Chart js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <!-- Projects Analytics Dashboard App js -->
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
</body>
</html>