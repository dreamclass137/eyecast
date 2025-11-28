<?php 
include "connection.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    header('Content-Type: application/json; charset=utf-8');

    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

    if ($_POST['action'] === 'update') {
        $field = isset($_POST['field']) ? $_POST['field'] : '';
        $value = isset($_POST['value']) ? $_POST['value'] : '';

        // Only allow these fields
        if (!in_array($field, ['order_status', 'payment_status'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid field']);
            exit;
        }

        // Whitelist values
        $allowed_values = [
            'order_status'   => ['Pending', 'Shipped', 'Delivered', 'Cancelled'],
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
// ----------------------
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
                                            <th>Product id</th>
											<th>Product name</th>
                                            <th>Price</th>
                                            <th>User</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Order</th>
                                            <th>Created At</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sql = "SELECT o.order_id,o.total_amount,o.payment_status,o.order_status,o.created_at,
											u.name AS user_name,a.address,a.city,a.state,a.pincode,
											p.title AS product_name, pc.color_id, oi.price, oi.quantity
											FROM order_tbl o
											INNER JOIN user_tbl u ON o.user_id = u.user_id
											INNER JOIN address_tbl a ON o.address_id = a.address_id
											INNER JOIN order_items_tbl oi ON o.order_id = oi.order_id
											INNER JOIN product_tbl p ON oi.product_id = p.product_id
											LEFT JOIN product_colors_tbl pc ON oi.pcolor_id = pc.pcolor_id";

									if($statusFilter != 'all'){
										if($statusFilter == 'Paid' || $statusFilter == 'Unpaid'){
											$sql .= " WHERE o.payment_status='".mysqli_real_escape_string($conn,$statusFilter)."'";
										} else {
											$sql .= " WHERE o.order_status='".mysqli_real_escape_string($conn,$statusFilter)."'";
										}
									}
									$sql .= " ORDER BY o.order_id DESC";

									$result = mysqli_query($conn, $sql);
									$sn = 1;

									$statusClass = [
										"Pending"=>"badge-pending",
										"Paid"=>"badge-paid",
										"Unpaid"=>"badge-unpaid",
										"Shipped"=>"badge-shipped",
										"Delivered"=>"badge-delivered",
										"Cancelled"=>"badge-cancelled"
									];

									if($result && mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)){
											$fullAddress = $row['address'] . 
														   (!empty($row['city'])?', '.$row['city']:'') . 
														   (!empty($row['state'])?', '.$row['state']:'') . 
														   (!empty($row['pincode'])?' - '.$row['pincode']:'');

											$payClass = $statusClass[$row['payment_status']] ?? 'badge-pending';
											$ordClass = $statusClass[$row['order_status']] ?? 'badge-pending';
											?>
											<tr data-order-id="<?= $row['order_id'] ?>">
												<td><?= $sn ?></td>
												<td><?= $row['order_id'] ?></td>
												<td><?= $row['product_name'] ?> <?= $row['color_id']?"($row[color_id])":"" ?></td>
												<td>₹<?= number_format($row['price'],2) ?></td>
												<td><?= $row['user_name'] ?></td>
												<td><?= $fullAddress ?></td>
												<td><?= intval($row['quantity']) ?></td>
												<td>₹<?= number_format($row['total_amount'],2) ?></td>
												<td>
													<span class="badge-status <?= $payClass ?>" data-id="<?= $row['order_id'] ?>" data-field="payment_status">
														<span class="text"><?= $row['payment_status'] ?></span>
														<span class="arrow">▾</span>
													</span>
												</td>
												<td>
													<span class="badge-status <?= $ordClass ?>" data-id="<?= $row['order_id'] ?>" data-field="order_status">
														<span class="text"><?= $row['order_status'] ?></span>
														<span class="arrow">▾</span>
													</span>
												</td>
												<td><?= $row['created_at'] ?></td>
															

											</tr>
											<?php
											$sn++;
										}
									} else {
										echo '<tr><td colspan="12" class="text-center">No orders found</td></tr>';
									}
									?>
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
$(function(){
    var orderOptions = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];
    var paymentOptions = ['Unpaid', 'Paid'];

    function getBadgeClass(value){
        return {
            "Pending"   : "badge-pending",
            "Paid"      : "badge-paid",
            "Unpaid"    : "badge-unpaid",
            "Shipped"   : "badge-shipped",
            "Delivered" : "badge-delivered",
            "Cancelled" : "badge-cancelled"
        }[value] || 'badge-pending';
    }

    $(document).on("click",".badge-status .arrow",function(e){
        e.stopPropagation();
        $(".status-dropdown").remove();
        let badge = $(this).closest(".badge-status");
        let field = badge.data("field");
        let options = (field==='payment_status') ? paymentOptions : orderOptions;

        let dropdown = $("<ul class='status-dropdown'>")
            .css({position:"absolute",background:"#fff",listStyle:"none",margin:0,padding:"6px 0",borderRadius:"6px",boxShadow:"0 4px 12px rgba(0,0,0,.15)",zIndex:9999});
        options.forEach(opt => dropdown.append(`<li class="opt" data-value="${opt}" style="padding:6px 14px;cursor:pointer;white-space:nowrap">${opt}</li>`));
        $("body").append(dropdown);

        let pos = badge.offset();
        dropdown.css({top:pos.top + badge.outerHeight() + 3, left:pos.left});
        $("body").data("openBadge", badge);
    });

    $(document).on("click",".status-dropdown .opt",function(){
        let selected = $(this).data("value");
        let dropdown = $(this).closest(".status-dropdown");
        let badge = $("body").data("openBadge");
        let order_id = badge.data("id");
        let field = badge.data("field");

        $.post("",{action:"update", order_id, field, value:selected}, function(resp){
            if(resp.status === "success"){
                badge.find(".text").text(selected);
                badge.removeClass("badge-pending badge-paid badge-unpaid badge-shipped badge-delivered badge-cancelled");
                badge.addClass(getBadgeClass(selected));

                Swal.fire({
                    icon: "success",
                    title: "Updated",
                    text: field.replace("_"," ") + " → " + selected,
                    timer: 1100,
                    showConfirmButton: false
                });

                // Remove row if it doesn't belong to current tab
                let activeTab = $(".status-filter a.active").data("status") || "all";
                let row = badge.closest("tr");
                if(activeTab !== "all"){
                    let dt = $('#datatable-buttons').DataTable();
                    if(field === "payment_status" && activeTab !== selected){
                        dt.row(row).remove().draw(false);
                    }
                    if(field === "order_status" && activeTab !== selected){
                        dt.row(row).remove().draw(false);
                    }
                }
            }
        }, "json");

        dropdown.remove();
    });

    $(document).on("click",function(){
        $(".status-dropdown").remove();
    });
});
</script>

</body>
</html>
