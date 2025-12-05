<?php
include("connection.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* ===================== 1. AJAX HANDLERS ===================== */
if (isset($_POST['fetch_data'])) {
    $pid  = intval($_POST['product_id']);
    $type = $_POST['fetch_type'];

    if ($type == 'size') {
        echo '<option value="">Select size...</option>'; 
        $sizeQ = mysqli_query($conn, "SELECT pvariation_id, size FROM product_variation_tbl WHERE product_id = '$pid' ORDER BY size ASC");
        if (mysqli_num_rows($sizeQ) > 0) {
            while ($row = mysqli_fetch_assoc($sizeQ)) {
                echo '<option value="'.$row['pvariation_id'].'">'.htmlspecialchars($row['size']).'</option>';
            }
        }
    }
    exit;
}

if (isset($_POST['fetch_already_used_colors'])) {
    $pid = intval($_POST['product_id']);
    $vid = intval($_POST['variation_id']);
    $usedColors = [];
    $query = mysqli_query($conn, "SELECT color_id FROM product_image_tbl WHERE product_id = '$pid' AND pvariation_id = '$vid'");
    while($row = mysqli_fetch_assoc($query)) { $usedColors[] = $row['color_id']; }
    echo json_encode($usedColors);
    exit;
}

/* ===================== 2. DATA PREP ===================== */
$edit_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0);
$product_id = $pvariation_id = $color_id = "";
$old_images = ['f_image' => '', 'b_image' => '', 'third_image' => '', 'fourth_image' => '', 'fifth_image' => '', 'tryon_image' => ''];

if ($edit_id > 0) {
    $editQ = mysqli_query($conn, "SELECT * FROM product_image_tbl WHERE image_id='$edit_id'");
    if ($row = mysqli_fetch_assoc($editQ)) {
        $product_id = $row['product_id']; 
        $pvariation_id = $row['pvariation_id'];
        $color_id = $row['color_id'];
        foreach($old_images as $k => $v) { $old_images[$k] = $row[$k]; }
    }
}

$productQ = mysqli_query($conn, "SELECT * FROM product_tbl WHERE p_status=1 ORDER BY title ASC");
$colorQ   = mysqli_query($conn, "SELECT * FROM color_tbl ORDER BY color_name ASC");

function up_img($file, $old = "") {
    $uploadDir = "uploads/";
    if (!empty($file['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $name = $uploadDir.time().'_'.basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $name)) return $name;
        }
    }
    return $old;
}

if (isset($_POST['submit'])) {
    $p_id = intval($_POST['product_id']); 
    $v_id = intval($_POST['pvariation_id']);
    $c_id = intval($_POST['color_id']);
    $f  = up_img($_FILES['f_image'], $old_images['f_image']);
    $b  = up_img($_FILES['b_image'], $old_images['b_image']);
    $t  = up_img($_FILES['third_image'], $old_images['third_image']);
    $fo = up_img($_FILES['fourth_image'], $old_images['fourth_image']);
    $fi = up_img($_FILES['fifth_image'], $old_images['fifth_image']);
    $tr = up_img($_FILES['tryon_image'], $old_images['tryon_image']);

    if ($edit_id > 0) {
        $sql = "UPDATE product_image_tbl SET product_id='$p_id', pvariation_id='$v_id', color_id='$c_id', f_image='$f', b_image='$b', third_image='$t', fourth_image='$fo', fifth_image='$fi', tryon_image='$tr' WHERE image_id='$edit_id'";
        $msg_type = "Updated Successfully!";
    } else {
        $sql = "INSERT INTO product_image_tbl (product_id, pvariation_id, color_id, f_image, b_image, third_image, fourth_image, fifth_image, tryon_image, i_status) VALUES ('$p_id', '$v_id', '$c_id', '$f', '$b', '$t', '$fo', '$fi', '$tr', '1')";
        $msg_type = "Inserted Successfully!";
    }

    if(mysqli_query($conn, $sql)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Success!',
                    text: '$msg_type',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    window.location.href='manage-product-image.php';
                });
            }, 100);
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= ($edit_id > 0) ? 'Edit' : 'Add' ?> Product Image</title>
	<script src="assets/js/config.js"></script>
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="assets/libs/choices.js/choices.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .img-preview { margin-top:8px; width:100px; height:100px; object-fit: cover; border:1px solid #ddd; display:block; border-radius: 6px; background: #f8f9fa; }
        .val-container { position: relative; }
        .choices__inner, .select2-container--default .select2-selection--single, .form-control { border: 1px solid #ced4da !important; min-height: 40px !important; display: flex; align-items: center; }
        .field-error .choices__inner, .field-error .select2-selection, .field-error .form-control { border: 1.5px solid #ef5350 !important; background-color: #fff8f8 !important; }
        .field-success .choices__inner, .field-success .select2-selection, .field-success .form-control { border: 1.5px solid #05cd99 !important; background-color: #f6fffb !important; }
        .invalid-msg { color: #ef5350; font-size: 11px; margin-top: 4px; display: none; font-weight: 600; }
        .field-error .invalid-msg { display: block; }
        .color-dot { width: 14px; height: 14px; border-radius: 50%; display: inline-block; margin-right: 10px; border: 1px solid #ddd; flex-shrink: 0; }
        .select2-results__option[aria-disabled=true] { opacity: 0.4; cursor: not-allowed; }
		
		/* 1. Targets the Select2 placeholder text specifically */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #6c757d !important; /* This makes it grey */
    line-height: 40px !important; /* Keeps it centered vertically */
}

/* 2. Style for Choices.js (Product and Size) to ensure they match */
.choices__list--single .choices__placeholder {
    color: #6c757d !important;
    opacity: 1;
}
		/* EXTRA SAFETY FOR CHOICES */
		.val-container .choices {
			margin-bottom: 0 !important;
		}

		/* Validation just below input */
		.val-container .invalid-msg {
			margin-top: 2px !important;
		}
		
		
	</style>
</head>
<body>
<div class="wrapper">
    <?php include_once("sidebar.php"); include_once("header.php"); ?>
    <div class="page-content">
        <div class="page-container">
            <div class="card">
                <div class="card-header bg-white"><h4><?= ($edit_id > 0) ? 'Edit' : 'Add' ?> Product Images</h4></div>
                <div class="card-body">
                    <form id="variationForm" method="POST" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Product Title</label>
                                <div class="val-container">
                                    <select id="product_id" name="product_id" required>
                                        <option value="" selected disabled hidden>Select Product</option>
                                        <?php mysqli_data_seek($productQ, 0); while($p = mysqli_fetch_assoc($productQ)): ?>
                                            <option value="<?= $p['product_id'] ?>" <?= ($p['product_id'] == $product_id) ? 'selected' : '' ?>><?= htmlspecialchars($p['title']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <div class="invalid-msg">Product title is required.</div>

                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Select Size</label>
                                <div class="val-container">
                                    <select id="pvariation_id" name="pvariation_id" required>
                                        <option value="" selected disabled hidden>Select Size</option>
                                    </select>
                                    <div class="invalid-msg">Product size is required.</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Select Color</label>
                                <div class="val-container">
                                    <select name="color_id" id="color_id" class="form-select select2" placeholder="Select Color..." required>
                                        <option value="" selected disabled hidden>Select Color</option>
                                        <?php mysqli_data_seek($colorQ, 0); while($c=mysqli_fetch_assoc($colorQ)){ ?>
                                            <option value="<?= $c['color_id'] ?>" data-color="<?= $c['color_code'] ?>" <?= ($c['color_id'] == $color_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['color_name']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-msg">Product color is required.</div>
                                </div>
                            </div>
                            <div class="col-12"><hr class="my-2"></div>
                            <?php 
                            $imgs = ['f_image' => 'Front', 'b_image' => 'Back', 'third_image' => 'Third', 'fourth_image' => 'Fourth', 'fifth_image' => 'Fifth', 'tryon_image' => 'Try-On'];
                            foreach($imgs as $key => $lbl): ?>
                            <div class="col-md-4 mb-4">
                                <label class="form-label"><?= $lbl ?> Image</label>
                                <div class="val-container">
                                    <input type="file" id="<?= $key ?>" name="<?= $key ?>" class="form-control img-input" <?= ($key !== 'tryon_image' && $edit_id == 0) ? 'required' : '' ?> accept="image/*">
                                    <div class="invalid-msg"><?= $lbl ?> image required.</div>
                                    <img id="<?= $key ?>_preview" src="<?= $old_images[$key] ?>" class="img-preview" style="<?= empty($old_images[$key]) ? 'display:none' : '' ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="col-12 mt-2"><button type="submit" name="submit" class="btn btn-primary w-100 py-2">Save Product Details</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/libs/choices.js/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
	
    const isEdit = <?= $edit_id ?> > 0;
    const initialVariation = '<?= $pvariation_id ?>';
    let validationActive = isEdit;

    const productChoice = new Choices('#product_id', { searchEnabled: true, itemSelectText: '' });
    const sizeChoice = new Choices('#pvariation_id', { searchEnabled: true, itemSelectText: '', shouldSort: false });

    function formatColor(color) {
        if (!color.id) return color.text;
        let hex = $(color.element).data('color');
        return $('<span style="display:flex; align-items:center;"><span class="color-dot" style="background:' + hex + ';"></span>' + color.text + '</span>');
    }

    $('#color_id').select2({ width: '100%', templateResult: formatColor, templateSelection: formatColor, escapeMarkup: function(m) { return m; } });

    function applyValidation(selector) {
        if (!validationActive) return;
        let val = $(selector).val();
        let $container = $(selector).closest('.val-container');
        if (!val || val === "" || val === "Select size...") { $container.addClass('field-error').removeClass('field-success'); }
        else { $container.addClass('field-success').removeClass('field-error'); }
    }

    function disableUsedColors() {
        if (isEdit) return;
        let pid = $('#product_id').val();
        let vid = $('#pvariation_id').val();
        if (!pid || !vid) return;
        $.post(window.location.href, { fetch_already_used_colors: 1, product_id: pid, variation_id: vid }, function(data) {
            let usedColors = JSON.parse(data);
            $('#color_id option').each(function() {
                let v = $(this).val();
                $(this).prop('disabled', usedColors.includes(v));
            });
            $('#color_id').trigger('change.select2');
        });
    }

    function fetchSizes(productId, preSelect = '') {
        if (!productId) {
            sizeChoice.clearStore();
            sizeChoice.setChoices([{ value: '', label: 'Select size...', selected: true }], 'value', 'label', true);
            applyValidation('#pvariation_id');
            return;
        }
        $.post(window.location.href, { fetch_data: 1, product_id: productId, fetch_type: 'size' }, function(response) {
            sizeChoice.clearStore();
            let options = $.map($(response), function(opt) {
                let v = $(opt).val();
                return { value: v, label: $(opt).text(), selected: (v == preSelect && v !== "") };
            });
            sizeChoice.setChoices(options, 'value', 'label', true);
            setTimeout(() => { applyValidation('#pvariation_id'); disableUsedColors(); }, 100);
        });
    }

    if (isEdit) {
        setTimeout(() => {
            applyValidation('#product_id');
            applyValidation('#color_id');
            fetchSizes('<?= $product_id ?>', initialVariation);
            $('.img-preview').each(function() { if($(this).attr('src') != "") $(this).closest('.val-container').addClass('field-success'); });
        }, 500);
    }

    $('#product_id').on('change', function() { applyValidation(this); fetchSizes($(this).val()); });
    $('#pvariation_id').on('change', function() { applyValidation(this); disableUsedColors(); });
    $('#color_id').on('change', function() { applyValidation(this); });

    $('.img-input').on('change', function() {
        if (this.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => $('#' + $(this).attr('id') + '_preview').attr('src', e.target.result).show();
            reader.readAsDataURL(this.files[0]);
            $(this).closest('.val-container').addClass('field-success').removeClass('field-error');
        }
    });

    $('#variationForm').on('submit', function(e) {
        validationActive = true;
        let isValid = true;
        ['#product_id', '#pvariation_id', '#color_id'].forEach(selector => {
            if (!$(selector).val() || $(selector).val() === "" || $(selector).val() === "Select size...") {
                $(selector).closest('.val-container').addClass('field-error'); isValid = false;
            } else { $(selector).closest('.val-container').addClass('field-success'); }
        });
        $('.img-input[required]').each(function() {
            if (!this.files[0] && !isEdit) { $(this).closest('.val-container').addClass('field-error'); isValid = false; }
        });
        if (!isValid) e.preventDefault();
    });
});
</script>
</body>
</html>