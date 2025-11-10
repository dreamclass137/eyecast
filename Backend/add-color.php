<?php
include "connection.php";
session_start();
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$color_name = "";
$color_code = "";
$errorMessageName = "";
$errorMessageCode = "";
$successMsg = ""; // <-- Added

// Form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $color_name = trim($_POST['color_name']);
    $color_code = trim($_POST['color_code']);
    $edit_id = intval($_POST['edit_id']);

    $valid = true;

    if ($color_name == "") {
        $errorMessageName = "Please enter color name";
        $valid = false;
    } elseif(!preg_match("/^[a-zA-Z\s]+$/",$color_name)) {
        $errorMessageName = "Only letters allowed";
        $valid = false;
    }

    if ($color_code == "") {
        $errorMessageCode = "Please pick a color";
        $valid = false;
    }

    if ($valid) {
        if ($edit_id > 0) {
            $q = mysqli_query($conn, "SELECT * FROM color_tbl WHERE LOWER(color_name) = LOWER('$color_name') AND color_id != $edit_id");
        } else {
            $q = mysqli_query($conn, "SELECT * FROM color_tbl WHERE LOWER(color_name) = LOWER('$color_name')");
        }

        if (!$q) die("Query failed: ".mysqli_error($conn));

        if (mysqli_num_rows($q) > 0) {
            $errorMessageName = "Color already exists!";
        } else {
            if ($edit_id > 0) {
                mysqli_query($conn, "UPDATE color_tbl SET color_name='$color_name', color_code='$color_code' WHERE color_id=$edit_id");
                $successMsg = "updated"; // <-- set success message
            } else {
                mysqli_query($conn, "INSERT INTO color_tbl (color_name,color_code) VALUES ('$color_name','$color_code')");
                $successMsg = "inserted"; // <-- set success message
            }
        }
    }
} else {
    // Fetch for edit
    if($edit_id>0){
        $res = mysqli_query($conn, "SELECT * FROM color_tbl WHERE color_id=$edit_id");
        if($res && $row = mysqli_fetch_assoc($res)){
            $color_name = $row['color_name'];
            $color_code = $row['color_code'];
        } else { die("Color not found!"); }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />
	<title>Adminto | Add Color</title>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Pickr Advanced Color Picker CDN -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<script src="assets/js/config.js"></script>
	<link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

	<style>
.color-container { display: flex; align-items: center; gap: 10px; margin-top:5px; }
.pcr-button { width: 50px !important; height: 40px !important; border-radius: 6px !important; }
.error-message { color: #dc3545; font-size: 0.85em; margin-top: 0.25rem; }
</style>

</head>

<body>

<div class="wrapper">

<?php include_once("sidebar.php"); ?>
<?php include_once("header.php"); ?>

<div class="page-content">
<div class="page-container">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-header border-bottom border-dashed d-flex align-items-center">
    <h2 class="header-title"><?= $edit_id ? 'Edit Color' : 'Add Color' ?></h2>
</div>

<div class="card-body">

<form id="colorForm" method="POST">
<input type="hidden" name="edit_id" value="<?= $edit_id ?>">

<!-- Color Name -->
<div class="mb-3">
<label class="form-label">Color Name</label>
<input type="text" class="form-control" id="color_name" name="color_name" value="<?= htmlspecialchars($color_name) ?>">
<div class="error-message" id="nameError"><?= $errorMessageName ?></div>
</div>

<!-- Color Picker -->
<div class="mb-3">
<label class="form-label">Pick Color</label>
<div class="color-container">
    <div id="pickr"></div>
    <input type="text" id="color_code" name="color_code" value="<?= htmlspecialchars($color_code ?: '#000000') ?>" style="width:80px;" readonly/>
</div>
<div class="error-message" id="codeError"><?= $errorMessageCode ?></div>
</div>

<button type="submit" class="btn btn-primary"><?= $edit_id ? 'Update Color' : 'Add Color' ?></button>
</form>


</div> <!-- card-body -->
</div> <!-- card -->
</div> <!-- col-lg-12 -->
</div> <!-- row -->

</div> <!-- page-container -->
<?php include_once("footer.php"); ?>
</div> <!-- page-content -->

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>

<script>
window.onload = () => {
    const nameInput = document.getElementById("color_name");
    const codeInput = document.getElementById("color_code");
    const nameError = document.getElementById("nameError");
    const codeError = document.getElementById("codeError");
    const form = document.getElementById("colorForm");

    // ===== Pickr setup =====
    const pickr = Pickr.create({
        el: '#pickr',
        theme: 'classic',
        default: codeInput.value.trim() !== '' ? codeInput.value.trim() : '#000000',
        components: {
            preview: true,
            opacity: true,
            hue: true,
            interaction: { hex: true, input: true, save: true }
        }
    });

    pickr.on('init', () => {
        const saveBtn = document.querySelector('.pcr-save');
        if (saveBtn) saveBtn.textContent = 'Apply';
    });

    pickr.on('save', color => {
        if(color) {
            codeInput.value = color.toHEXA().toString();
            codeInput.style.borderColor = 'green';
            codeError.innerText = '';
        }
        pickr.hide();
    });

    codeInput.addEventListener('input', () => {
        const hex = codeInput.value.trim();
        if(/^#([0-9A-F]{3}){1,2}$/i.test(hex)){
            pickr.setColor(hex);
            codeInput.style.borderColor = 'green';
            codeError.innerText = '';
        }
    });

    // ===== Real-time validation for name =====
    nameInput.addEventListener('input', () => {
        if(nameInput.value.trim() === '') {
            nameError.innerText = "Please enter color name";
            nameInput.style.borderColor = 'red';
        } else if(!/^[a-zA-Z\s]+$/.test(nameInput.value)) {
            nameError.innerText = "Only letters allowed";
            nameInput.style.borderColor = 'red';
        } else {
            nameError.innerText = '';
            nameInput.style.borderColor = 'green';
        }
    });

    // ===== Form submit validation =====
    form.addEventListener('submit', e => {
        pickr.save();
        let valid = true;

        if(nameInput.value.trim() === '') {
            nameError.innerText = "Please enter color name";
            nameInput.style.borderColor = 'red';
            valid = false;
        } else if(!/^[a-zA-Z\s]+$/.test(nameInput.value)) {
            nameError.innerText = "Only letters allowed";
            nameInput.style.borderColor = 'red';
            valid = false;
        }

        if(codeInput.value.trim() === '') {
            codeError.innerText = "Please pick a color";
            codeInput.style.borderColor = 'red';
            valid = false;
        }

        if(!valid) e.preventDefault();
    });

    // ===== Apply red border if PHP validation error exists (on page load) =====
    if("<?= $errorMessageName ?>" !== ""){
        nameInput.style.borderColor = 'red';
    }

    if("<?= $errorMessageCode ?>" !== ""){
        codeInput.style.borderColor = 'red';
    }

    // ===== SweetAlert success message + redirect =====
    const successMsg = "<?= $successMsg ?>";
    if(successMsg === 'inserted'){
        Swal.fire({
            icon: 'success',
            title: 'Color Added!',
            text: 'Your color has been added successfully.',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = 'manage-color.php';
        });
    } else if(successMsg === 'updated'){
        Swal.fire({
            icon: 'success',
            title: 'Color Updated!',
            text: 'Your color has been updated successfully.',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = 'manage-color.php';
        });
    }
};
</script>

</body>
</html>
