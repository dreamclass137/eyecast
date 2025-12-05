<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

/* ========= AJAX STATUS UPDATE (SAME FILE) ========= */
if (isset($_POST['ajax_status_update'])) {

    header('Content-Type: application/json');

    if (!isset($_SESSION['admin_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Session expired"
        ]);
        exit;
    }

    if (!isset($_POST['product_id'], $_POST['variation_id'], $_POST['status'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid data"
        ]);
        exit;
    }

    $product_id   = intval($_POST['product_id']);
    $variation_id = intval($_POST['variation_id']);
    $status       = intval($_POST['status']);

    // Update PRODUCT
    $up1 = mysqli_query($conn, "
        UPDATE product_tbl 
        SET p_status = '$status'
        WHERE product_id = '$product_id'
    ");

    // Update VARIATION
    $up2 = mysqli_query($conn, "
        UPDATE product_variation_tbl 
        SET v_status = '$status'
        WHERE pvariation_id = '$variation_id'
    ");

    if ($up1 && $up2) {
        echo json_encode([
            "success" => true
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => mysqli_error($conn)
        ]);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
		<title>Adminto | View Products </title>
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
			/* BUTTONS */
			.btn-view-colors { 
				background:#fff; 
				color:#000; 
				border:1px solid #ccc; 
				padding:6px 12px; 
				border-radius:8px; 
				font-size:13px; 
				transition:0.25s; 
			}
			.btn-view-colors:hover { 
				border-color:#0d6efd; 
				color:#0d6efd; 
			}

			/* READ MORE */
			.read-more { 
				color:#0d6efd; 
				font-weight:600; 
				cursor:pointer; 
				margin-left:6px; 
			}

			/* STATUS BADGES */
			.status-badge { 
				padding:6px 10px; 
				border-radius:12px; 
				font-size:12px; 
				font-weight:700; 
				text-transform: uppercase;
			}
			.status-active { background: #0d6efd; color: #fff; }
			.status-inactive { background: #6c757d; color: #fff; }

			/* COLORS MODAL */
			.color-swatch-wrapper {
				display: flex;
				gap: 8px;
				flex-wrap: nowrap;
				overflow-x: auto;
				padding: 10px 8px; /* left & right padding to fix half-cut first swatch */
			}
			.color-swatch {
				width: 20px;
				height: 20px;
				border-radius: 50%;
				border: 2px solid #ccc; 
				cursor: pointer;
				flex: 0 0 auto;
				transition: 0.2s all ease;
			}
			.color-swatch:hover { transform: scale(1.1); }
			.color-swatch.active { 
				border-color: #0d6efd; 
				transform: scale(1.1); 
				box-shadow: none; 
			}

			/* IMAGE PREVIEW */
			.image-preview-horizontal {
				display: flex;
				gap: 10px;
				overflow-x: auto;
				padding: 10px 0;
				flex-wrap: nowrap;
			}
			.preview-image {
				width: 100px;
				height: 100px;
				object-fit: contain;
				border: 1px solid #ddd;
				border-radius: 6px;
				padding: 4px;
				background: #fff;
				flex: 0 0 auto;
			}
			.no-image {
				color: #888;
				font-style: italic;
				padding: 20px;
			}

			.modal-custom-width { max-width: 700px; margin: auto; }

			/* Hide default DataTables entries dropdown */
			.dataTables_length { display: none !important; }
			.card-header h4.mb-0 {
			margin-bottom: 0;
			}

			.card-body {
				padding-top: 10px; /* reduce top padding */
			}
			/* ---------- Magical Color Wheel Button ---------- */
			.color-btn {
				background: transparent;
				border: none;
				padding: 0;
				cursor: pointer;
			}
			
			.color-btn svg {
				width: 26px;
				height: 26px;
				transition: transform 0.4s ease, filter 0.4s ease;
			}

			/* subtle glow + scale */
			.color-btn:hover svg {
				transform: scale(1.2) rotate(12deg);
				filter: drop-shadow(0 0 6px rgba(13,110,253,0.6));
			}

			/* slow auto rotation */
			.color-wheel {
				animation: slowSpin 6s linear infinite;
			}

			@keyframes slowSpin {
				from { transform: rotate(0deg); }
				to   { transform: rotate(360deg); }
			}
			
			.color-item{
				display: flex;
				flex-direction: column;
				align-items: center;
				min-width: 60px;
				cursor: pointer;
			}

			.color-name{
				margin-top: 4px;
				font-size: 11px;
				font-weight: 600;
				color: #444;
				white-space: nowrap;
			}

		</style>
	</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <?php include 'header.php'; ?>

        <div class="page-content">
            <div class="page-container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
								<h4 class="mb-0">View Products</h4>
								<a href="add-product.php" class="btn btn-primary btn-sm">+ Add Product</a>
							</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Shape</th>
                                                <th>Colors</th>
                                                <th>Description</th>
                                                <th>Gender</th>
                                                <th>Size</th>
                                                <th class="text-end">Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
										<tbody>
										<?php
										$sql = "
											SELECT 
												p.product_id,
												p.title,
												pv.pvariation_id,
												pv.description,
												p.gender,
												pv.size,
												pv.price,
												p.p_status AS status,
												c.c_name,
												s.s_name
											FROM product_tbl p
											LEFT JOIN category_tbl c ON p.category_id = c.category_id
											LEFT JOIN shape_tbl s ON p.shape_id = s.shape_id
											INNER JOIN product_variation_tbl pv 
												ON p.product_id = pv.product_id
											ORDER BY p.product_id DESC
											";

											$res = mysqli_query($conn,$sql);
											while($p = mysqli_fetch_assoc($res)):
											$res_colors = mysqli_query($conn, "
											SELECT 
												pi.pvariation_id,
												pi.color_id,
												c.color_name,
												c.color_code,
												pi.f_image,
												pi.b_image,
												pi.third_image,
												pi.fourth_image,
												pi.fifth_image,
												pi.tryon_image
											FROM product_image_tbl pi
											LEFT JOIN color_tbl c ON pi.color_id = c.color_id
											WHERE pi.pvariation_id = ".$p['pvariation_id']."
											AND pi.i_status = '1'
											");

											$colors = mysqli_fetch_all($res_colors, MYSQLI_ASSOC);
											?>

										<tr>
											<td><?= $p['product_id'] ?></td>
											<td><b><?= $p['title'] ?></b></td>
											<td><?= $p['c_name'] ?></td>
											<td><?= $p['s_name'] ?></td>

											<!-- COLORS -->
											<td>
											<?php if(!empty($colors)): ?>
											<button class="color-btn"
													data-bs-toggle="modal"
													data-bs-target="#colorsModal-<?= $p['pvariation_id'] ?>"
													title="View Colors">

											<svg viewBox="0 0 100 100" class="color-wheel">
												<circle cx="50" cy="50" r="40" fill="none" stroke="#4285F4" stroke-width="20"
													stroke-dasharray="62.8 188.4"/>
												<circle cx="50" cy="50" r="40" fill="none" stroke="#34A853" stroke-width="20"
													stroke-dasharray="62.8 188.4" stroke-dashoffset="-62.8"/>
												<circle cx="50" cy="50" r="40" fill="none" stroke="#FBBC05" stroke-width="20"
													stroke-dasharray="62.8 188.4" stroke-dashoffset="-125.6"/>
												<circle cx="50" cy="50" r="40" fill="none" stroke="#EA4335" stroke-width="20"
													stroke-dasharray="62.8 188.4" stroke-dashoffset="-188.4"/>
											</svg>
											</button>

											<!-- MODAL -->
											<div class="modal fade" id="colorsModal-<?= $p['pvariation_id'] ?>">
												<div class="modal-dialog modal-dialog-centered modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title"><?= $p['title'] ?> Colors</h5>
															<button class="btn-close" data-bs-dismiss="modal"></button>
														</div>
														<div class="modal-body">
															<div class="color-swatch-wrapper">
																<?php foreach($colors as $i => $c): ?>
																<span class="color-swatch"
																	data-idx="<?= $i ?>"
																	style="background:<?= $c['color_code'] ?>;"
																	title="<?= htmlspecialchars($c['color_name']) ?>">
																</span>
															<?php endforeach; ?>

															</div>

															<div class="image-preview-horizontal"
																id="images-<?= $p['pvariation_id'] ?>"
															</div>
														</div>
													</div>
												</div>
											</div>

											<script>
												window['productColors<?= $p['pvariation_id'] ?>'] = <?= json_encode($colors) ?>;
											</script>
											
											<?php else: ?>
											No colors
											<?php endif; ?>
											</td>

											<!-- DESCRIPTION -->
											<td>
												<span class="desc-readmore"
													  data-desc="<?= htmlspecialchars($p['description']) ?>"
													  style="cursor:pointer;color:#0d6efd;text-decoration:underline">
													Read More
												</span>
											</td>

											<td><?= $p['gender'] ?></td>
											<td><?= $p['size'] ?></td>
											<td class="text-end">₹<?= number_format($p['price'],2) ?></td>

											<td class="text-center">
    <div class="form-check form-switch d-inline-flex align-items-center">
        <input class="form-check-input product-status-toggle"
       type="checkbox"
       role="switch"
       data-product="<?= $p['product_id'] ?>"
       data-variation="<?= $p['pvariation_id'] ?>"
       <?= ($p['status'] == 1) ? 'checked' : '' ?>>

    </div>
</td>

										</tr>
										<?php endwhile; ?>
										</tbody>
	
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once("footer.php"); ?>

        <div class="modal fade" id="readMoreModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="rmTitle">Description</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
					<div class="modal-body" id="rmText"
					 style="
						white-space: pre-wrap;
						word-break: break-word;
						overflow-wrap: anywhere;
					 ">
					</div>
                </div>
            </div>
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
            let table = $('#productsTable').DataTable({
                order: [[0, 'desc']],
                lengthChange: false,  
                pageLength: 10,       
                pagingType: "simple_numbers"
            });

            // Read More modal
            $(document).on('click', '.desc-readmore', function(){
			let desc = $(this).data('desc');
			$('#rmTitle').text('Description');
			$('#rmText').text(desc); // ⬅️ text() use karo (safe & clean)
			new bootstrap.Modal(document.getElementById('readMoreModal')).show();
			});


			// Color swatch click – SHOW IMAGES
			$(document).on('click', '.color-swatch', function () {

				let modal = $(this).closest('.modal');
				let idx = $(this).data('idx');

				// active state
				modal.find('.color-swatch').removeClass('active');
				$(this).addClass('active');

				// variation id
				let variationId = modal.attr('id').split('-')[1];

				// colors data
				let colors = window['productColors' + variationId];
				let selectedColor = colors[idx];

				// image container
				let imagesDiv = modal.find('#images-' + variationId);
				imagesDiv.html('');

				let hasImage = false;

				['f_image','b_image','third_image','fourth_image','fifth_image','tryon_image']
					.forEach(img => {
						if (selectedColor[img]) {
							imagesDiv.append(
								'<img src="'+selectedColor[img]+'" class="preview-image">'
							);
							hasImage = true;
						}
					});

				if (!hasImage) {
					imagesDiv.append('<div class="no-image">No images added</div>');
				}
			});

            
            // Auto-click first color on modal open
            $(document).on('shown.bs.modal', '.modal', function(){
                let modal = $(this);
                let firstSwatch = modal.find('.color-swatch').first();
                if(firstSwatch.length && !firstSwatch.hasClass('active')){
                    firstSwatch.click();
                }
            });
			$(document).on('change', '.product-status-toggle', function () {

    let checkbox    = $(this);
    let productId   = checkbox.data('product');
    let variationId = checkbox.data('variation');
    let status      = checkbox.is(':checked') ? 1 : 0;

    // prevent double click
    checkbox.prop('disabled', true);

    $.ajax({
        url: window.location.href,   // SAME FILE
        type: 'POST',
        dataType: 'json',
        data: {
            ajax_status_update: 1,
            product_id: productId,
            variation_id: variationId,
            status: status
        },
        success: function (res) {

            checkbox.prop('disabled', false);

            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: status ? 'Activated' : 'Deactivated',
                    timer: 1200,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', res.message || 'Update failed', 'error');
                checkbox.prop('checked', !status);
            }
        },
        error: function () {

            checkbox.prop('disabled', false);
            checkbox.prop('checked', !status);

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Please try again'
            });
        }
    });
});


        </script>
	</body>
</html>
