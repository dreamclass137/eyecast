<?php
include "connection.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$product_id = 0;

// Priority: GET parameter > Session > default 0
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
} elseif (isset($_SESSION['last_inserted_product_id'])) {
    $product_id = $_SESSION['last_inserted_product_id'];
    unset($_SESSION['last_inserted_product_id']);
}

$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$swal_script = "";

// Fetch Products
$products = [];
$resProd = mysqli_query($conn, "SELECT product_id, title FROM product_tbl ORDER BY title ASC");
while ($row = mysqli_fetch_assoc($resProd)) { $products[] = $row; }

// Fetch Enum Sizes from Database
$sizeOptions = [];
$result = mysqli_query($conn, "SHOW COLUMNS FROM product_variation_tbl LIKE 'size'");
if ($row = mysqli_fetch_assoc($result)) {
    preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
    $values = explode(",", $matches[1]);
    foreach ($values as $value) { $sizeOptions[] = trim($value, "'"); }
}

// Fetch Data for Edit Mode
$variations = [];
if ($edit_id) {
    $res = mysqli_query($conn, "SELECT * FROM product_variation_tbl WHERE pvariation_id='$edit_id'");
    if ($row = mysqli_fetch_assoc($res)) {
        $variations[] = $row;
        $product_id = $row['product_id'];
    }
}

// Handle Submission
if (isset($_POST['submit'])) {
    $product_id_post = intval($_POST['product_id']);
    $sizes        = $_POST['size'];
    $prices       = $_POST['price'];
    $descriptions = $_POST['description'];

    if ($edit_id) {
        $sizeEsc = mysqli_real_escape_string($conn, $sizes[0]);
        $check = mysqli_query($conn,"
            SELECT pvariation_id 
            FROM product_variation_tbl 
            WHERE product_id='$product_id_post' 
            AND size='$sizeEsc'
            AND pvariation_id != '$edit_id'
        ");
        if(mysqli_num_rows($check) > 0){
            $swal_script = "Swal.fire({
                icon: 'error',
                title: 'Duplicate Size',
                text: 'This size already exists for selected product',
                confirmButtonColor: '#28a745'
            });";
        } else {
            $price = mysqli_real_escape_string($conn, $prices[0]);
            $desc  = mysqli_real_escape_string($conn, $descriptions[0]);
            mysqli_query($conn,"
                UPDATE product_variation_tbl 
                SET product_id='$product_id_post',
                    size='$sizeEsc',
                    price='$price',
                    description='$desc'
                WHERE pvariation_id='$edit_id'
            ");
            $swal_script = "Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Variation updated successfully.',
                confirmButtonColor: '#28a745'
            }).then(() => {
                window.location.href = 'manage-product-variation.php';
            });";
        }
    } else {
        $inserted = false;
        foreach ($sizes as $i => $size) {
            if(empty($size) || empty($prices[$i])) continue;
            $sizeEsc  = mysqli_real_escape_string($conn, $size);
            $priceEsc = mysqli_real_escape_string($conn, $prices[$i]);
            $descEsc  = mysqli_real_escape_string($conn, $descriptions[$i]);

            $check = mysqli_query($conn,"
                SELECT pvariation_id 
                FROM product_variation_tbl 
                WHERE product_id='$product_id_post' 
                AND size='$sizeEsc'
            ");
            if(mysqli_num_rows($check) > 0){
                $swal_script = "Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Size',
                    text: 'One or more sizes already exist for this product',
                    confirmButtonColor: '#28a745'
                });";
                break;
            }

            mysqli_query($conn,"
                INSERT INTO product_variation_tbl 
                (product_id, size, description, price, v_status)
                VALUES
                ('$product_id_post','$sizeEsc','$descEsc','$priceEsc','1')
            ");
            $inserted = true;
        }
        if($inserted){
            $swal_script = "Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Variations added successfully.',
                confirmButtonColor: '#28a745'
            }).then(() => {
                window.location.href = 'add-product-image.php';
            });";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $edit_id ? 'Edit' : 'Add' ?> Product Variations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/vendor.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="assets/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .form-control, .form-select { height: 50px; font-size: 15px; transition: border-color 0.3s; }
        textarea.form-control { min-height: 90px; }
        .action-buttons { display:flex; gap:8px; margin-top:32px; }
        .btn-add { border:1px solid #28a745; color:#28a745; }
        .btn-add:hover { background:#28a745; color:#fff; }
        .btn-remove { border:1px solid #dc3545; color:#dc3545; }
        .btn-remove:hover { background:#dc3545; color:#fff; }
        .error-msg { color:red; font-size:0.9em; margin-top:4px; height: 18px; }
        .is-invalid { border-color: #dc3545 !important; }
        .is-valid { border-color: #28a745 !important; }
        .form-control.is-invalid, .form-select.is-invalid, .form-control.is-valid, .form-select.is-valid { background-image: none !important; padding-right: 0.75rem !important; }
        .select2-container--default .select2-selection--single.is-invalid { border-color: #dc3545 !important; }
        .select2-container--default .select2-selection--single.is-valid { border-color: #28a745 !important; }
        input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px white inset !important; }
        .form-control:focus { box-shadow: none !important; outline: none !important; }
        .select2-container--default .select2-selection--single { height:50px; border: 1px solid #dee2e6; border-radius: 0.3rem; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:50px; padding-left: 12px; color: grey; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height:50px; }
        .select2-container--default .select2-selection--single .select2-selection__placeholder { color: grey !important; }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include "sidebar.php"; ?>
    <?php include "header.php"; ?>

    <div class="page-content">
        <div class="page-container">
            <div class="card">
                <div class="card-header"><h4 class="card-title"><?= $edit_id ? 'Edit' : 'Add' ?> Product Variations</h4></div>
                <div class="card-body">
                    <form method="POST" id="variationForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Select Product</label>
                                <select name="product_id" id="productSelect" class="form-select" data-placeholder="Select Product...">
                                    <option value=""></option>
                                    <?php foreach($products as $p): ?>
                                        <option value="<?= $p['product_id'] ?>" <?= ($p['product_id']==$product_id)?'selected':'' ?>>
                                            <?= htmlspecialchars($p['title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="error-msg" id="product-error"></div>
                            </div>
                        </div>

                        <div id="variationWrapper">
                            <?php if($edit_id): ?>
                                <div class="row variation-row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Size</label>
                                        <select name="size[]" class="form-select size-select" data-placeholder="Select Size">
                                            <option value=""></option>
                                            <?php foreach($sizeOptions as $s): ?>
                                                <option value="<?= $s ?>" <?= ($s==$variations[0]['size'])?'selected':'' ?>><?= $s ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="error-msg size-error"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price[]" class="form-control price-input" value="<?= $variations[0]['price'] ?>">
                                        <div class="error-msg price-error"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Description</label>
                                        <textarea name="description[]" class="form-control desc-input"><?= $variations[0]['description'] ?></textarea>
                                        <div class="error-msg desc-error"></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row variation-row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Size</label>
                                        <select name="size[]" class="form-select size-select" data-placeholder="Select Size">
                                            <option value=""></option>
                                            <?php foreach($sizeOptions as $s): ?>
                                                <option value="<?= $s ?>"><?= $s ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="error-msg size-error"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price[]" class="form-control price-input" placeholder="0.00">
                                        <div class="error-msg price-error"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Description</label>
                                        <textarea name="description[]" class="form-control desc-input" placeholder="Variation description..."></textarea>
                                        <div class="error-msg desc-error"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-add addRow">+</button>
                                            <button type="button" class="btn btn-remove removeRow">−</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100 mt-3">
                            <?= $edit_id ? 'Update Variation' : 'Add Variations' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</div>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function(){

    function initSelect2(element = '.size-select, #productSelect') {
        $(element).select2({ 
            width: '100%',
            placeholder: function(){ return $(this).data('placeholder'); },
            allowClear: true
        });
    }

    function checkDuplicateSizes(){
        let sizeArr = [];
        let duplicate = false;
        $('.variation-row').each(function(){
            let size = $(this).find('.size-select').val();
            if(size !== ''){
                if(sizeArr.includes(size)){
                    duplicate = true;
                    $(this).find('.size-select').addClass('is-invalid');
                    $(this).find('.size-error').text('This size already added');
                    $(this).find('.select2-selection').addClass('is-invalid');
                } else {
                    sizeArr.push(size);
                }
            }
        });
        return !duplicate;
    }

    initSelect2();

    $(document).on('input', '.price-input', function() {
        validateField($(this), $(this).siblings('.price-error'), '', false, 'price');
    });
    $(document).on('input', '.desc-input', function() {
        validateField($(this), $(this).siblings('.desc-error'), '', false, 'desc');
    });
    $(document).on('change', '.size-select, #productSelect', function() {
        validateField($(this), $(this).siblings('.error-msg'), '', true);
    });

    $(document).on('click', '.addRow', function () {
        let newRow = $('.variation-row:first').clone();
        newRow.find('.select2-container').remove();
        newRow.find('select').removeClass('select2-hidden-accessible is-invalid is-valid').val('');
        newRow.find('input, textarea').val('').removeClass('is-invalid is-valid');
        newRow.find('.error-msg').text('');
        $('#variationWrapper').append(newRow);
        initSelect2(newRow.find('.size-select'));
    });

    $(document).on('click', '.removeRow', function () {
        if($('.variation-row').length > 1) $(this).closest('.variation-row').remove();
    });

    function validateField(el, errorEl, msg, isSelect2 = false, extra = null) {
        let val = el.val()?.trim() ?? '';
        let isValid = false;
        if(val === ''){
            isValid = false;
            if(extra === 'price') msg = 'Please enter price';
            else if(extra === 'desc') msg = 'Please enter description';
            else if(el.hasClass('size-select')) msg = 'Please enter size';
            else if(el.attr('id') === 'productSelect') msg = 'Please select a product';
            else msg = 'This field is required';
        } else if(extra === 'price') {
            isValid = /^[+]?\d+(\.\d{1,2})?$/.test(val) && parseFloat(val) > 0;
            msg = 'Enter a valid positive number';
        } else if(extra === 'desc') {
            isValid = val.length >= 8;
            msg = 'Enter at least 8 characters';
        } else {
            isValid = true;
        }

        if(!isValid){
            el.addClass('is-invalid').removeClass('is-valid');
            if(isSelect2) el.next('.select2-container').find('.select2-selection').addClass('is-invalid').removeClass('is-valid');
            errorEl.text(msg);
        } else {
            el.addClass('is-valid').removeClass('is-invalid');
            if(isSelect2) el.next('.select2-container').find('.select2-selection').addClass('is-valid').removeClass('is-invalid');
            errorEl.text('');
        }
        return isValid;
    }

    $('#variationForm').on('submit', function(e){
        let pValid = validateField($('#productSelect'), $('#product-error'), '', true);
        let allRowsValid = true;
        $('.variation-row').each(function(){
            let r1 = validateField($(this).find('.size-select'), $(this).find('.size-error'), '', true);
            let r2 = validateField($(this).find('.price-input'), $(this).find('.price-error'), '', null, 'price');
            let r3 = validateField($(this).find('.desc-input'), $(this).find('.desc-error'), '', null, 'desc');
            if(!r1 || !r2 || !r3) allRowsValid = false;
        });
        let noDuplicate = checkDuplicateSizes();
        if(!pValid || !allRowsValid || !noDuplicate){
            e.preventDefault();
            if(!noDuplicate){
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Size',
                    text: 'Same size cannot be added more than once for a product',
                    confirmButtonColor: '#28a745'
                });
            }
        }
    });

    <?php if(!empty($swal_script)) echo $swal_script; ?>
});
</script>
</body>
</html>
