<?php
include "connection.php";
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$showSuccess = false;
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

/* ---------- AJAX: Check duplicate title ---------- */
if (isset($_POST['check_title'])) {
    $title = trim($_POST['title']);
    $edit_id_ajax = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : 0;

    $sql = "SELECT * FROM product_tbl WHERE title=? ";
    if ($edit_id_ajax) {
        $sql .= " AND product_id<>?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $title, $edit_id_ajax);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $title);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode(['exists' => $result->num_rows > 0]);
    exit;
}

/* ---------- DEFAULT VALUES ---------- */
$title = $category_id = $shape_id = $gender = "";

/* ---------- FETCH PRODUCT (EDIT MODE) ---------- */
if ($edit_id) {
    $query = mysqli_query($conn, "SELECT * FROM product_tbl WHERE product_id='$edit_id'");
    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $title       = $row['title'];
        $category_id = $row['category_id'];
        $shape_id    = $row['shape_id'];
        $gender      = $row['gender'];
    }
}

/* ---------- FORM SUBMIT ---------- */
if (isset($_POST['submit'])) {

    $title       = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $shape_id    = $_POST['shape_id'];
    $gender      = $_POST['gender'];
    $created_at  = date('Y-m-d H:i:s');

    /* ---------- UPDATE ---------- */
    if ($edit_id) {
        $sql = "UPDATE product_tbl SET
                    title='$title',
                    category_id='$category_id',
                    shape_id='$shape_id',
                    gender='$gender'
                WHERE product_id='$edit_id'";
    } 
    /* ---------- INSERT ---------- */
    else {
        $sql = "INSERT INTO product_tbl
                    (title, category_id, shape_id, gender, created_at)
                VALUES
                    ('$title', '$category_id', '$shape_id', '$gender', '$created_at')";
    }

    if (mysqli_query($conn, $sql)) {
    if (!$edit_id) {
    // If new product, get last inserted ID
    $edit_id = mysqli_insert_id($conn);
    $_SESSION['last_inserted_product_id'] = $edit_id; // Store in session
}

    $showSuccess = true;
}

}

/* ---------- FETCH CATEGORIES ---------- */
$categories = [];
$catQuery = mysqli_query($conn, "SELECT * FROM category_tbl");
while ($cat = mysqli_fetch_assoc($catQuery)) {
    $categories[] = $cat;
}

/* ---------- FETCH SHAPES ---------- */
$shapes = [];
$shapeQuery = mysqli_query($conn, "SELECT * FROM shape_tbl");
while ($shape = mysqli_fetch_assoc($shapeQuery)) {
    $shapes[] = $shape;
}

/* ---------- FETCH ENUM GENDERS ---------- */
$genders = [];
$genderEnumQuery = mysqli_query($conn, "SHOW COLUMNS FROM product_tbl LIKE 'gender'");
$row = mysqli_fetch_assoc($genderEnumQuery);
if ($row) {
    preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
    if (!empty($matches[1])) {
        $genders = str_getcsv($matches[1], ',', "'");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Adminto | <?= $edit_id ? "Edit" : "Add" ?> Product</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="assets/images/favicon.ico">
<script src="assets/js/config.js"></script>
<link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.error-msg { color:red; font-size:0.9em; margin-top: 1px !important; }
.is-valid { border-color: #28a745 !important; background-image: none !important; }
.is-invalid { border-color: red !important; background-image: none !important; }
.select2-container--default .select2-selection--single.is-valid { border-color: #28a745 !important; background-image: none !important; }
.select2-container--default .select2-selection--single.is-invalid { border-color: red !important; background-image: none !important; }
.form-label { margin-bottom: 0.1rem !important; font-size: 0.95rem; }
.form-control, .form-select { height: auto; min-height: calc(1.5em + 0.75rem + 2px); }
.select2-container--default .select2-selection--single { height: calc(1.5em + 0.75rem + 2px); padding: 0.375rem 0.75rem; }
</style>
</head>
<body>
<div class="wrapper">
<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center">
                        <h2 class="header-title"><?= $edit_id ? "Edit Product" : "Add Product" ?></h2>
                    </div>
                    <div class="card-body">
                    <form method="POST" id="productForm">

    <!-- Title -->
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title"
               value="<?= htmlspecialchars($title) ?>">
        <span class="error-msg" id="titleError"></span>
    </div>

    <!-- Category -->
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id">
            <option value="">Select Category</option>
            <?php foreach($categories as $cat) { ?>
                <option value="<?= $cat['category_id'] ?>"
                    <?= $category_id==$cat['category_id']?'selected':'' ?>>
                    <?= htmlspecialchars($cat['c_name']) ?>
                </option>
            <?php } ?>
        </select>
        <span class="error-msg" id="category_idError"></span>
    </div>

    <!-- Shape -->
    <div class="mb-3">
        <label class="form-label">Shape</label>
        <select class="form-select" id="shape_id" name="shape_id">
            <option value="">Select Shape</option>
            <?php foreach($shapes as $shape) { ?>
                <option value="<?= $shape['shape_id'] ?>"
                    <?= $shape_id==$shape['shape_id']?'selected':'' ?>>
                    <?= htmlspecialchars($shape['s_name']) ?>
                </option>
            <?php } ?>
        </select>
        <span class="error-msg" id="shape_idError"></span>
    </div>

    <!-- Gender -->
    <div class="mb-3">
        <label class="form-label">Gender</label>
        <select class="form-select" id="gender" name="gender">
            <option value="" hidden>Select Gender</option>
            <?php foreach($genders as $g) { ?>
                <option value="<?= htmlspecialchars($g) ?>"
                    <?= $gender==$g?'selected':'' ?>>
                    <?= htmlspecialchars($g) ?>
                </option>
            <?php } ?>
        </select>
        <span class="error-msg" id="genderError"></span>
    </div>

    <button type="submit" name="submit" class="btn btn-primary w-100">
        <?= $edit_id ? "Update Product" : "Add Product" ?>
    </button>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function(){

    // Initialize Select2
    $('#category_id').select2({ placeholder: "Select Category", allowClear: true });
    $('#shape_id').select2({ placeholder: "Select Shape", allowClear: true });
    $('#gender').select2({ placeholder: "Select Gender", allowClear: true });

    // Validation rules
    const validationRules = {
        title: "Please enter product title",
        category_id: "Please select a category",
        shape_id: "Please select a shape",
        gender: "Please select gender"
    };

    function validateField(id){
        let input = document.getElementById(id);
        let error = document.getElementById(id+'Error');
        let value = input.value.trim();
        let isSelect2 = ['category_id','shape_id','gender'].includes(id);

        if(value === ""){
            if(isSelect2){
                $('#' + id).next('.select2-container').find('.select2-selection--single')
                           .addClass('is-invalid').removeClass('is-valid');
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            }
            if(error) error.innerHTML = validationRules[id];
            return false;
        } else {
            if(isSelect2){
                $('#' + id).next('.select2-container').find('.select2-selection--single')
                           .removeClass('is-invalid').addClass('is-valid');
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
            if(error) error.innerHTML = "";
            return true;
        }
    }

    // Real-time validation
    Object.keys(validationRules).forEach(id=>{
        let field = document.getElementById(id);
        if(!field) return;
        let isSelect2 = ['category_id','shape_id','gender'].includes(id);
        if(isSelect2){
            $('#'+id).on('change',()=>validateField(id));
        } else {
            field.addEventListener('input',()=>validateField(id));
            field.addEventListener('change',()=>validateField(id));
        }
    });

    // Check duplicate title via AJAX
    async function checkDuplicateTitle() {
        let title = $('#title').val().trim();
        if (title === "") return false;

        let edit_id = <?= $edit_id ?>;

        let res = await $.ajax({
            url: '', // same page
            method: 'POST',
            data: { check_title: 1, title: title, edit_id: edit_id },
            dataType: 'json'
        });

        if (res.exists) {
            $('#titleError').text('This title already exists!');
            $('#title').addClass('is-invalid').removeClass('is-valid');
            return false;
        } else {
            $('#titleError').text('');
            $('#title').removeClass('is-invalid').addClass('is-valid');
            return true;
        }
    }

    // Form submit
    document.getElementById('productForm').addEventListener('submit', function(e){
    // e.preventDefault(); // REMOVE this line
    let valid = true;

    // Validate all fields
    for (let id of Object.keys(validationRules)) {
        if (!validateField(id)) valid = false;
    }

    if(!valid) {
        e.preventDefault(); // only prevent if invalid
    }
});

<?php if($showSuccess): ?>
Swal.fire({ 
    icon: 'success', 
    title: 'Product <?= isset($_GET['edit_id']) ? "Updated" : "Added" ?> Successfully!', 
    confirmButtonColor: '#28a745', 
    confirmButtonText: 'OK'
}).then(() => {
    <?php if(isset($_GET['edit_id'])): ?>
        // EDIT MODE → back to manage product
        window.location.href = 'manage-product.php';
    <?php else: ?>
        // INSERT MODE → go to add variation
window.location.href = 'add-product-variation.php';

    <?php endif; ?>
});
<?php endif; ?>
});
</script>
</body>
</html>