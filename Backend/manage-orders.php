<?php
include "connection.php"; // Database connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    header('Content-Type: application/json; charset=utf-8');

    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

    if ($_POST['action'] === 'update') {
        $field = isset($_POST['field']) ? $_POST['field'] : '';
        $value = isset($_POST['value']) ? $_POST['value'] : '';

        // Only allow these fields
        if (!in_array($field, ['o_status', 'payment_status'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid field']);
            exit; 
        }

        // White list values
        $allowed_values = [
								'o_status' => ['Pending', 'Shipped', 'Delivered', 'Cancelled'],
								'payment_status' => ['Unpaid', 'Paid']
							];


        if (!in_array($value, $allowed_values[$field])) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid value']);
            exit;
        }

        // Update in DB
        $safe_value = mysqli_real_escape_string($conn, $value);
        $update_sql = "UPDATE order_tbl SET `$field` = '$safe_value' WHERE order_id = $order_id LIMIT 1";
        $ok = mysqli_query($conn, $update_sql);

        if ($ok) {
            echo json_encode(['status' => 'success', 'order_id' => $order_id, 'field' => $field, 'value' => $value]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if ($_POST['action'] === 'delete') {
        if($order_id > 0){
            $delete_sql = "DELETE FROM order_tbl WHERE order_id=$order_id LIMIT 1";
            if(mysqli_query($conn, $delete_sql)){
                echo json_encode(['status'=>'success','msg'=>"Order #$order_id deleted"]);
            } else {
                echo json_encode(['status'=>'error','msg'=>mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['status'=>'error','msg'=>'Invalid order ID']);
        }
        exit;
    }

}

// ----------------------
// Page rendering
// ------------ ----------
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto | Manage Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS & JS -->
    <script src="assets/js/config.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .badge-status { position: relative; padding: 6px 12px; border-radius: 20px; font-weight:600; cursor:pointer; display:inline-flex; gap:6px; }
        .badge-status .arrow { font-size:10px; margin-left:4px; opacity:.8; }
        .badge-pending { background:#fff4d9;color:#d39800; }
        .badge-paid { background:#d4f5e3;color:#0f8f44; }
        .badge-unpaid { background:#ffe7e7; color:#c20000; }
        .badge-shipped { background:#dfeaff;color:#3366ff; }
        .badge-delivered { background:#c9f7f5;color:#0b807a; }
        .badge-cancelled { background:#ffd7d7;color:#d60000; }
	    .status-filter a {
			margin-right: 22px;
			padding: 9px 20px;
			border-radius: 10px;
			font-weight: 600;
			background: #f1f3f7;
			display: inline-block;
			color: #444;
			text-decoration: none;
			transition: 0.25s ease;
		}
		.status-filter a:hover { background: #dce6ff; color: #295ad2; transform: translateY(-2px); }
		.status-filter a.active { background: #3e7bfa; color: #fff; box-shadow: 0 4px 12px rgba(62, 123, 250, 0.35); transform: translateY(-2px); }
		.delete-btn i { color: #87CEEB; font-size: 18px; transition: 0.2s ease-in-out; }
		.delete-btn i:hover { transform: scale(1.2); color: #b30000; }
        .status-dropdown li:hover { background:#f2f4ff; }
		
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
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="header-title mb-0">Manage Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 status-filter">
                                <?php
                                $statuses = ['all'=>'All', 'Pending'=>'Pending', 'Unpaid'=>'Unpaid','Paid'=>'Paid','Shipped'=>'Shipped','Delivered'=>'Delivered','Cancelled'=>'Cancelled'];
                                foreach($statuses as $key => $label){
                                    $activeClass = ($statusFilter==$key) ? 'active' : '';
                                    echo "<a href='?status=$key' class='$activeClass' data-status='$key'>$label</a>";
                                }
                                ?>
                            </div>

                            <div id="orderTableContainer">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            
                                            <th>Order id</th>
											<th>Product name</th>
                                            <th>Price</th>
                                            <th>User</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Order</th>
                                            <th>Ordered Time</th>
                                           
                                        </tr>
                                    </thead>
								<tbody>
									<?php
									// --- STATUS MAPPING ---
									$statusClass = [
										"Pending"   => "badge-pending",
										"Paid"      => "badge-paid",
										"Unpaid"    => "badge-unpaid",
										"Shipped"   => "badge-shipped",
										"Delivered" => "badge-delivered",
										"Cancelled" => "badge-cancelled"
									];

									// 1. Fetch data
									$sql = "SELECT 
												o.order_id, o.total_amount, o.payment_status, o.o_status, o.created_at,
												u.name AS user_name,
												a.address, a.city, a.state, a.pincode,
												p.title AS product_name,
												oi.price, oi.quantity,
												c.color_name
											FROM order_tbl o
											INNER JOIN user_tbl u ON o.user_id = u.user_id
											INNER JOIN address_tbl a ON o.address_id = a.address_id
											INNER JOIN order_items_tbl oi ON o.order_id = oi.order_id
											INNER JOIN product_tbl p ON oi.product_id = p.product_id
											INNER JOIN product_image_tbl pi ON oi.pimage_id = pi.image_id
											INNER JOIN color_tbl c ON pi.color_id = c.color_id";

									if ($statusFilter !== 'all') {
										$safeStatus = mysqli_real_escape_string($conn, $statusFilter);
										if ($statusFilter === 'Paid' || $statusFilter === 'Unpaid') {
											$sql .= " WHERE o.payment_status = '$safeStatus'";
										} else {
											$sql .= " WHERE o.o_status = '$safeStatus'";
										}
									}
									$sql .= " ORDER BY o.order_id DESC";

									$result = mysqli_query($conn, $sql);

									// 2. Group items by Order ID
									$orders = [];
									while ($row = mysqli_fetch_assoc($result)) {
										$orders[$row['order_id']]['info'] = $row;
										$orders[$row['order_id']]['items'][] = [
											'name'  => $row['product_name'],
											'color' => $row['color_name'],
											'price' => $row['price']
										];
									}

									// 3. Render Rows (Sr no removed)
									foreach ($orders as $orderId => $orderData) {
										$row = $orderData['info'];
										$items = $orderData['items'];
										$itemCount = count($items);
										
										$fullAddress = $row['address'] . (!empty($row['city'])?', '.$row['city']:'') . (!empty($row['state'])?', '.$row['state']:'');
										
										$payClass = $statusClass[$row['payment_status']] ?? 'badge-pending';
										$ordClass = $statusClass[$row['o_status']] ?? 'badge-pending';
									?>
										<tr data-order-id="<?= $orderId ?>">
											<td style="font-weight: bold; color: ##343434;"><?= $orderId ?></td>
											
											<?php if ($itemCount > 1): ?>
												<td colspan="2">
													<a href="javascript:void(0);" class="btn btn-sm view-products" 
													   style="background: #3e7bfa; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; text-decoration: none;"
													   data-id="<?= $orderId ?>">
													   View Products (<?= $itemCount ?>)
													</a>
													<div id="prod-list-<?= $orderId ?>" style="display:none; margin-top:5px; font-size: 12px; background: #f8f9fa; padding: 10px; border-radius: 6px; border-left: 3px solid #3e7bfa;">
														<?php foreach ($items as $item): ?>
															<div style="border-bottom: 1px solid #eee; padding: 5px 0;">
																<strong><?= $item['name'] ?></strong> <span style="color: #666;">(<?= $item['color'] ?>)</span> — ₹<?= number_format($item['price'], 2) ?>
															</div>
														<?php endforeach; ?>
													</div>
												</td>
											<?php else: ?>
												<td><?= $items[0]['name'] ?> <small style="color: #888;">(<?= $items[0]['color'] ?>)</small></td>
												<td>₹<?= number_format($items[0]['price'], 2) ?></td>
											<?php endif; ?>

											<td><?= $row['user_name'] ?></td>
											<td style="max-width: 200px; font-size: 13px; color: #666;"><?= $fullAddress ?></td>
											<td class="text-center"><?= intval($row['quantity']) ?></td>
											<td><span style="font-size: 15px; color: #333;">₹<?= number_format($row['total_amount'], 2) ?></span></td>
											<td>
												<span class="badge-status <?= $payClass ?>" data-id="<?= $orderId ?>" data-field="payment_status">
													<span class="text"><?= $row['payment_status'] ?></span>
													<span class="arrow">▾</span>
												</span>
											</td>
											<td>
												<span class="badge-status <?= $ordClass ?>" data-id="<?= $orderId ?>" data-field="o_status">
													<span class="text"><?= $row['o_status'] ?></span>
													<span class="arrow">▾</span>
												</span>
											</td>
											<td style="font-size: 12px; color: #999;"><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></td>
										</tr>
									<?php } ?>
									</tbody>
                                </table>
                            </div>
                        </div> <!-- card-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("footer.php"); ?>
    </div>
</div>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables/buttons.bootstrap5.min.js"></script>

<script>
$(function() {
    var orderOptions = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];
    var paymentOptions = ['Unpaid', 'Paid'];

    const statusConfig = {
        "Pending":   { icon: 'fa-box', color: '#fbc02d', isCustom: true, subIcon: 'fa-hourglass-half' }, 
        "Paid":      { type: 'success', color: '#a5dc86', isCustom: false }, 
        "Unpaid":    { type: 'error',   color: '#f27474', isCustom: false },
        "Shipped":   { icon: 'fa-truck-fast', color: '#81d4fa', isCustom: true }, 
        "Delivered": { icon: 'fa-truck', color: '#81c784', isCustom: true, subIcon: 'fa-circle-check' }, 
        "Cancelled": { icon: 'fa-box', color: '#ef9a9a', isCustom: true, subIcon: 'fa-circle-xmark' } 
    };

    function getBadgeClass(value) {
        return {
            "Pending": "badge-pending", "Paid": "badge-paid", "Unpaid": "badge-unpaid",
            "Shipped": "badge-shipped", "Delivered": "badge-delivered", "Cancelled": "badge-cancelled"
        }[value] || 'badge-pending';
    }

    $(document).on("click", ".badge-status .arrow", function(e) {
        e.stopPropagation();
        $(".status-dropdown").remove();
        var badge = $(this).closest(".badge-status");
        var field = badge.data("field");
        var options = (field === 'payment_status') ? paymentOptions : orderOptions;

        var dropdown = $("<ul class='status-dropdown'>").css({
            position: "absolute", background: "#fff", listStyle: "none", margin: 0,
            padding: "6px 0", borderRadius: "12px", boxShadow: "0 10px 25px rgba(0,0,0,0.1)", zIndex: 9999
        });

        options.forEach(function(opt) {
            dropdown.append('<li class="opt" data-value="' + opt + '" style="padding:8px 20px;cursor:pointer;font-weight:500;">' + opt + '</li>');
        });

        $("body").append(dropdown);
        var pos = badge.offset();
        dropdown.css({ top: pos.top + badge.outerHeight() + 5, left: pos.left });
        $("body").data("openBadge", badge);
    });

    $(document).on("click", ".status-dropdown .opt", function() {
        var selected = $(this).data("value");
        var dropdown = $(this).closest(".status-dropdown");
        var badge = $("body").data("openBadge");
        var order_id = badge.data("id");
        var field = badge.data("field");

        $.post("", { action: "update", order_id: order_id, field: field, value: selected }, function(resp) {
            if (resp.status === "success") {
                badge.find(".text").text(selected);
                badge.removeClass("badge-pending badge-paid badge-unpaid badge-shipped badge-delivered badge-cancelled").addClass(getBadgeClass(selected));

                var config = statusConfig[selected] || statusConfig["Pending"];
                
                // Text Logic: "Payment Paid" or "Order Shipped" etc.
                var topText = (field === 'payment_status') ? "Payment " + selected : "Order " + selected;

                var swalOptions = {
                    title: '<span style="font-size: 24px; font-weight: 600; color: #555;">' + topText + '</span>',
                    timer: 2000,
                    showConfirmButton: false,
                    width: '400px', 
                    padding: '3rem',
                    background: '#ffffff'
                };

                if (config.isCustom) {
                    // Alternate method using '+' concatenation to avoid "black code" editor bug
                    var htmlContent = '<div style="position: relative; margin: 30px auto; width: 100px; height: 80px; display: flex; align-items: center; justify-content: center;">' +
                                      '<i class="fas ' + config.icon + '" style="color: ' + config.color + '; font-size: 75px; opacity: 0.8;"></i>';
                    
                    if (config.subIcon) {
                        htmlContent += '<i class="fas ' + config.subIcon + '" style="position: absolute; bottom: -12px; right: -15px; color: ' + config.color + '; font-size: 42px; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);"></i>';
                    }
                    
                    htmlContent += '</div>' +
                                   '<div style="font-size: 16px; color: #888; margin-top: 20px;">Order ID: <b>' + order_id + '</b></div>';
                    
                    swalOptions.html = htmlContent;
                } else {
                    swalOptions.icon = config.type;
                    swalOptions.iconColor = config.color;
                    swalOptions.html = '<div style="font-size: 16px; color: #888; margin-top: 10px;">Order ID: <b>' + order_id + '</b></div>';
                }

                Swal.fire(swalOptions);

                var activeTab = $(".status-filter a.active").data("status") || "all";
                var row = badge.closest("tr");
                if (activeTab !== "all" && activeTab !== selected) {
                    $('#datatable-buttons').DataTable().row(row).remove().draw(false);
                }
            } else {
                Swal.fire("Error", resp.msg, "error");
            }
        }, "json");
        dropdown.remove();
    });

    $(document).on("click", function() { $(".status-dropdown").remove(); });
});
$(document).on("click", ".view-products", function() {
    let orderId = $(this).data("id");
    $(`#prod-list-${orderId}`).slideToggle(200);
});
</script>

</body>
</html>
