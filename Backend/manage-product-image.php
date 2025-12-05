<?php
include("connection.php"); // DB connection
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$image_columns = ['f_image','b_image','third_image','fourth_image','fifth_image','tryon_image'];
$image_labels = [
    'f_image'      => 'Front Image',
    'b_image'      => 'Back Image',
    'third_image'  => 'Third Image',
    'fourth_image' => 'Fourth Image',
    'fifth_image'  => 'Fifth Image',
    'tryon_image'  => 'Try-On Image'
];

// --- DELETE HANDLER ---
if(isset($_GET['delete_id'])){
    $del_id = intval($_GET['delete_id']);
    mysqli_query($conn,"DELETE FROM product_image_tbl WHERE image_id='$del_id'");
    echo "<script>window.location.href='manage-product-image.php';</script>";
    exit;
}

// --- DELETE ALL VARIATIONS FOR A PRODUCT ---
if(isset($_GET['delete_product_id'])){
    $product_id = intval($_GET['delete_product_id']);

    // Get all image files to delete from server
    $res = mysqli_query($conn, "SELECT * FROM product_image_tbl pi 
        JOIN product_variation_tbl pv ON pi.pvariation_id=pv.pvariation_id 
        WHERE pv.product_id='$product_id'");

    while($row = mysqli_fetch_assoc($res)){
        foreach($image_columns as $col){
            $file = $row[$col];
            if($file && file_exists($file) && $file != 'assets/images/no-image.png'){
                @unlink($file);
            }
        }
    }

    // Delete all images for the product variations
    mysqli_query($conn,"DELETE pi FROM product_image_tbl pi
        INNER JOIN product_variation_tbl pv ON pi.pvariation_id=pv.pvariation_id
        WHERE pv.product_id='$product_id'");

    echo "<script>window.location.href='manage-product-image.php';</script>";
    exit;
}

// --- AJAX STATUS TOGGLE ---
if(isset($_POST['toggle_stock'])){
    $image_id = intval($_POST['image_id']);
    $get = mysqli_query($conn,"SELECT i_status FROM product_image_tbl WHERE image_id='$image_id'");
    if(mysqli_num_rows($get) > 0){
        $row = mysqli_fetch_assoc($get);
        $new_status = ($row['i_status']==1)?0:1;
        $update = mysqli_query($conn,"UPDATE product_image_tbl SET i_status='$new_status' WHERE image_id='$image_id'");
        echo $update ? $new_status : "error";
    } else {
        echo "error";
    }
    exit;
}

// --- FETCH DATA ---
$product_groups = [];
$sql = "SELECT pv.*, p.title AS product_name, pi.*, c.color_code, c.color_name
        FROM product_variation_tbl pv
        JOIN product_tbl p ON pv.product_id=p.product_id
        INNER JOIN product_image_tbl pi ON pv.pvariation_id=pi.pvariation_id
        LEFT JOIN color_tbl c ON pi.color_id=c.color_id
        WHERE p.p_status='1'
        ORDER BY pv.product_id ASC, pi.image_id ASC";
$res = mysqli_query($conn,$sql);
while($r = mysqli_fetch_assoc($res)){
    $pid = intval($r['product_id']);
    if(!isset($product_groups[$pid])){
        $product_groups[$pid] = [
            'product_id'=>$pid,
            'product_name'=>$r['product_name'],
            'variations'=>[]
        ];
    }

    $variation = [
        'pvariation_id'=>intval($r['pvariation_id']),
        'image_id'=>intval($r['image_id']),
        'size'=>$r['size'],
        'stock'=>intval($r['i_status']),
		'color_id'=>intval($r['color_id']), // ✅ ADD THIS
        'color_code'=>$r['color_code']??'#eeeeee',
        'color_name'=>$r['color_name']??'N/A'
    ];

    foreach($image_columns as $img){
        $variation[$img] = $r[$img] ?: 'assets/images/no-image.png';
    }
    $product_groups[$pid]['variations'][]=$variation;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Adminto | Manage Product Image</title>
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
.product-image{width:80px;height:80px;object-fit:cover;border-radius:6px;border:1px solid #eee;}
.color-swatch-wrapper{display:flex;gap:6px;padding:8px 0;flex-wrap:nowrap;overflow:visible;}
.color-swatch-interactive{width:22px;height:22px;border-radius:50%;border:2px solid #e5e7eb;box-shadow:0 2px 6px rgba(0,0,0,.15);cursor:pointer;transition:all .2s ease;flex-shrink:0;}
.color-swatch-interactive:hover{transform:scale(1.15);}
.active-swatch{border:3px solid #0d6efd !important;transform:scale(1.2);}
.switch{position:relative;display:inline-block;width:32px;height:16px;}
.switch input{display:none;}
.slider{position:absolute;cursor:pointer;background:#ccc;border-radius:20px;top:0;left:0;right:0;bottom:0;transition:.3s;}
.slider:before{position:absolute;content:"";width:12px;height:12px;left:2px;bottom:2px;background:white;border-radius:50%;transition:.3s;}
input:checked + .slider{background:#0d6efd;}
input:checked + .slider:before{transform:translateX(16px);}
.text-blue{color:#0d6efd !important;}
.text-blue:hover{color:#0a58ca !important;}
.modal-size-info{font-size:14px;font-weight:600;color:#0d6efd;margin-bottom:10px;background:#f0f7ff;display:inline-block;padding:4px 12px;border-radius:50px;}
.image-preview-horizontal{display:flex;gap:15px;justify-content:center;margin-top:20px;flex-wrap:wrap;}
.preview-image{width:100px;height:100px;object-fit:cover;border-radius:12px;border:1px solid #ddd;}
.image-label{font-size:11px;margin-top:3px;color:#555;text-align:center;}
.wheel-icon{width:22px;height:22px;cursor:pointer;}
</style>
</head>
<body>
<div class="wrapper">
<?php include_once("sidebar.php"); ?>
<?php include_once("header.php"); ?>

<div class="page-content">
<div class="page-container">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
<h4>Manage Product Images</h4>
<a href="add-product-image.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Product Image</a>
</div>
<div class="card-body">
<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
<thead>
<tr>
<th>Image Id</th>
<th>Product Name</th>
<th>Colors</th>
<?php foreach($image_columns as $col): ?>
    <th><?= $image_labels[$col] ?></th>
<?php endforeach; ?>

<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach($product_groups as $pid=>$group):
$default=$group['variations'][0]; ?>
<tr id="row-<?= $pid ?>">
<td class="image-id-cell">
    <strong><?= $default['image_id'] ?></strong>
</td>

<td><strong><?= htmlspecialchars($group['product_name']) ?></strong></td>
<td>
<button class="btn p-0" data-bs-toggle="modal" data-bs-target="#colorsModal<?= $pid ?>">
<svg class="wheel-icon" viewBox="0 0 100 100">
<circle r="40" cx="50" cy="50" fill="none" stroke="#ef4444" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(0 50 50)" />
<circle r="40" cx="50" cy="50" fill="none" stroke="#f97316" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(60 50 50)" />
<circle r="40" cx="50" cy="50" fill="none" stroke="#eab308" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(120 50 50)" />
<circle r="40" cx="50" cy="50" fill="none" stroke="#22c55e" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(180 50 50)" />
<circle r="40" cx="50" cy="50" fill="none" stroke="#3b82f6" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(240 50 50)" />
<circle r="40" cx="50" cy="50" fill="none" stroke="#8b5cf6" stroke-width="20" stroke-dasharray="41.87 209.33" transform="rotate(300 50 50)" />
</svg>
</button>

<div class="modal fade" id="colorsModal<?= $pid ?>" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" data-product-id="<?= $pid ?>">Variations: <?= htmlspecialchars($group['product_name']) ?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<div class="modal-size-info">Size: <span class="size-display-text"><?= $default['size'] ?></span></div>

<div class="color-swatch-wrapper justify-content-center mb-3">
<?php foreach($group['variations'] as $v): ?>
<span class="color-swatch-interactive"
      style="background-color:<?= $v['color_code'] ?>;"
      title="<?= htmlspecialchars($v['color_name']) ?>"
      data-pvariation-id="<?= $v['pvariation_id'] ?>"
      data-image-id="<?= $v['image_id'] ?>"
      data-size="<?= $v['size'] ?>"
      data-stock="<?= $v['stock'] ?>"
      data-color-id="<?= $v['color_id'] ?>"
      <?php foreach($image_columns as $col): ?>
          data-<?= str_replace('_image','',$col) ?>="<?= $v[$col] ?>"
      <?php endforeach; ?>>
</span>


<?php endforeach; ?>
</div>

<!-- Stock toggle inside modal -->
<div class="mb-3">
<label>Stock:</label>
<label class="switch ms-2">
<input type="checkbox" class="modalStockToggle">
<span class="slider"></span>
</label>
</div>

<div class="image-preview-horizontal">
<?php foreach($image_columns as $col): ?>
<div class="text-center">
<img src="<?= $default[$col] ?>" class="preview-image" data-col="<?= $col ?>">
<div class="image-label"><?= ucfirst(str_replace('_image',' ',$col)) ?></div>
</div>
<?php endforeach; ?>
</div>
</div>
<div class="modal-footer p-3">
<div class="w-100 d-flex align-items-center justify-content-between">
<div class="d-flex align-items-center gap-2">
<a href="add-product-image.php?edit_id=<?= $default['image_id'] ?>"
class="btn btn-outline-primary modal-edit-btn">Edit Variation</a>

<a href="#" class="btn btn-outline-danger modal-delete-btn"
data-image-id="<?= $default['image_id'] ?>">Delete Variation</a>
</div>
<div class="d-flex align-items-center gap-2">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary applyColorBtn">OK</button>
</div>
</div>
</div>
</div>
</div>
</div>
</td>
<?php foreach($image_columns as $col): ?>
<td class="<?= $col ?>_display"><img src="<?= $default[$col] ?>" class="product-image"></td>
<?php endforeach; ?>
<td>
<div class="d-flex gap-3">
<a href="#" class="text-blue deleteShapeBtn" data-product-id="<?= $pid ?>">
    <i class="fa-solid fa-trash fs-5"></i>
</a>

</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
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
$(document).ready(function(){

    var selectedData = {};
    var currentDeleteImageId = null;

    // ------------------------
 // ------------------------
// SWATCH CLICK (INSTANT IMAGE ID UPDATE)
// ------------------------
$(document).on("click", ".color-swatch-interactive", function () {

    var s = $(this);
    var modal = s.closest(".modal-content");

    // Active swatch UI
    s.addClass("active-swatch").siblings().removeClass("active-swatch");

    // Update size text
    modal.find(".size-display-text").text(s.data("size"));

    // Store selected data
    selectedData = {
        pvariation_id: s.data("pvariation-id"),
        image_id: s.data("image-id"),
        size: s.data("size"),
        stock: parseInt(s.data("stock")),
        color_id: s.data("color-id"),
        images: {}
    };

    currentDeleteImageId = selectedData.image_id;

    // -------------------------------
    // FIX EDIT BUTTON (INSTANT)
    // -------------------------------
    var newEditUrl = "add-product-image.php?edit_id=" + selectedData.image_id;
    modal.find(".modal-edit-btn").attr("href", newEditUrl);

    // Save color for edit page
    localStorage.setItem("edit_color_id", selectedData.color_id);

    // -------------------------------
    // STOCK TOGGLE
    // -------------------------------
    $(".modalStockToggle", modal).prop("checked", selectedData.stock === 1);

    // Update delete button ID
    modal.find(".modal-delete-btn").attr("data-image-id", selectedData.image_id);

    // -------------------------------
    // UPDATE IMAGE PREVIEWS (MODAL)
    // -------------------------------
    <?php foreach($image_columns as $col): ?>
        selectedData.images["<?= $col ?>"] = s.data("<?= str_replace('_image','',$col) ?>");
        modal
            .find(".preview-image[data-col='<?= $col ?>']")
            .attr("src", s.data("<?= str_replace('_image','',$col) ?>"));
    <?php endforeach; ?>

    // -------------------------------
    // SAVE SELECTION PER PRODUCT
    // -------------------------------
    var pid = modal.find(".modal-title").data("product-id");
    localStorage.setItem("product_" + pid + "_selected_image", selectedData.image_id);

    // -------------------------------
    // 🔥 INSTANT IMAGE ID CHANGE (MAIN TABLE)
    // -------------------------------
    var row = $("#row-" + pid);
    row.find(".image-id-cell strong").text(selectedData.image_id);

    // -------------------------------
    // UPDATE MAIN TABLE IMAGES
    // -------------------------------
    Object.keys(selectedData.images).forEach(function (k) {
        row.find("." + k + "_display img").attr("src", selectedData.images[k]);
    });
});


    // ... Rest of your scripts (Apply button, Delete, Stock toggle etc.) remain same ...
	 // APPLY BUTTON CLICK (SAVE SELECTION)
    // ------------------------
    $(document).on("click", ".applyColorBtn", function(){
        var modal = $(this).closest(".modal-content");
        var pid = modal.find(".modal-title").data("product-id");
        if(selectedData.image_id){
            localStorage.setItem("product_"+pid+"_selected_image", selectedData.image_id);
            Swal.fire({
                icon:'success',
                title:'Variation Selected',
                text:'Your selected variation has been saved.',
                timer:900,
                showConfirmButton:false
            });
            modal.closest(".modal").modal('hide'); // close modal
        }
    });
    // ------------------------
    // MODAL OPEN
    // ------------------------
    $('.modal').on('shown.bs.modal', function () {
        var pid = $(this).find(".modal-title").data("product-id");
        var savedImageId = localStorage.getItem("product_"+pid+"_selected_image");

        if(savedImageId){
            // Trigger click on saved swatch
            var swatch = $(this).find(".color-swatch-interactive[data-image-id='"+savedImageId+"']");
            if(swatch.length) swatch.trigger("click");
        } else {
            // Optional: select first swatch if nothing saved
            $(this).find(".color-swatch-interactive").first().trigger("click");
        }
    });

    // ------------------------
    // ON PAGE LOAD: UPDATE ALL TABLE ROWS WITH SAVED VARIATIONS
    // ------------------------
    $("tr[id^='row-']").each(function(){
    var row = $(this);
    var pid = row.attr("id").replace("row-","");
    var savedImageId = localStorage.getItem("product_"+pid+"_selected_image");

    if(savedImageId){
        var swatch = row.find(".color-swatch-interactive[data-image-id='"+savedImageId+"']");
        if(swatch.length){
            var images = {};
            <?php foreach($image_columns as $col): ?>
            images["<?= $col ?>"] = swatch.data("<?= str_replace('_image','',$col) ?>");
            <?php endforeach; ?>

            Object.keys(images).forEach(function(k){
                row.find("."+k+"_display img").attr("src", images[k]);
            });

            // ✅ ALSO UPDATE IMAGE ID
            row.find(".image-id-cell strong").text(savedImageId);
        }
    }
});


    // ------------------------
    // STOCK TOGGLE
    // ------------------------
    $(document).on("change", ".modalStockToggle", function(){
        if(!selectedData.image_id) return;

        var $this = $(this);
        var $swatch = $(".color-swatch-interactive[data-image-id='"+selectedData.image_id+"']");

        $.post("manage-product-image.php", { toggle_stock:1, image_id:selectedData.image_id }, function(resp){
            resp = resp.trim();
            if(resp === "error"){
                Swal.fire({
                    icon:'error',
                    title:'Error',
                    text:'Could not update status!',
                    timer:1500,
                    showConfirmButton:false
                });
                $this.prop("checked", !$this.is(":checked")); // revert toggle
            } else {
                selectedData.stock = parseInt(resp);
                $swatch.data("stock", resp);

                if(resp == "1") {
                    $swatch.css("border", "2px solid green"); // active
                } else {
                    $swatch.css("border", "2px solid #ccc"); // inactive
                }

                Swal.fire({
                    icon:'success',
                    title:'Status Updated',
                    text:'Variation ('+selectedData.size+') is now '+(resp=="1"?"Active":"Inactive"),
                    timer:1200,
                    showConfirmButton:false
                });
            }
        });
    });

    // ------------------------
    // DELETE BUTTONS
    // ------------------------
    $(document).on("click", ".deleteShapeBtn", function(e){
        e.preventDefault();
        var productId = $(this).data("product-id");
        var imageId = $(this).data("image-id");

        Swal.fire({
            title: "Are you sure?",
            text: imageId ? "This will permanently delete this variation!" : "This will permanently delete all variations for this product!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result)=>{
            if(result.isConfirmed){
                if(imageId){
                    window.location.href = "manage-product-image.php?delete_id="+imageId;
                } else {
                    window.location.href = "manage-product-image.php?delete_product_id="+productId;
                }
            }
        });
    });

    $(document).on("click", ".modal-delete-btn", function(e){
        e.preventDefault();
        var id = $(this).data("image-id");
        if(!id) return;

        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the variation!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result)=>{
            if(result.isConfirmed){
                window.location.href = "manage-product-image.php?delete_id="+id;
            }
        });
    });
});
</script>
</body>
</html>
