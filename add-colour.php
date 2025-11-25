<?php
include "connection.php";

$message = '';
$message_type = '';
$color_name = '';
$color_code = '';
$edit_id = 0;

// Check if edit ID is passed
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_sql = "SELECT * FROM colour_tbl WHERE color_id = $edit_id";
    $result = mysqli_query($conn, $edit_sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $color_name = $row['color_name'];
        $color_code = $row['color_code'];
    } else {
        $message = 'Color not found!';
        $message_type = 'error';
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color_name = trim(mysqli_real_escape_string($conn, $_POST['color_name'] ?? ''));
    $color_code = trim(mysqli_real_escape_string($conn, $_POST['color_code'] ?? ''));
    $edit_id = intval($_POST['edit_id'] ?? 0);

    if (empty($color_name) || empty($color_code)) {
        $message = 'Please fill in all fields!';
        $message_type = 'warning';
    } else {
        // Check duplicate
        $check_sql = "SELECT * FROM colour_tbl WHERE color_name='$color_name'";
        if ($edit_id > 0) {
            $check_sql .= " AND color_id != $edit_id"; // Exclude current record when updating
        }
        if (mysqli_num_rows(mysqli_query($conn, $check_sql)) > 0) {
            $message = 'Color already exists!';
            $message_type = 'error';
        } else {
            if ($edit_id > 0) {
                // Update
                $update_sql = "UPDATE colour_tbl SET color_name='$color_name', color_code='$color_code' WHERE color_id=$edit_id";
                if (mysqli_query($conn, $update_sql)) {
                    $message = 'Color updated successfully!';
                    $message_type = 'success';
                } else {
                    $message = 'Database error: ' . mysqli_error($conn);
                    $message_type = 'error';
                }
            } else {
                // Insert
                $insert_sql = "INSERT INTO colour_tbl (color_name, color_code) VALUES ('$color_name', '$color_code')";
                if (mysqli_query($conn, $insert_sql)) {
                    $message = 'Color added successfully!';
                    $message_type = 'success';
                    $color_name = '';
                    $color_code = '';
                } else {
                    $message = 'Database error: ' . mysqli_error($conn);
                    $message_type = 'error';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Adminto | Add Colour</title>

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
.pcr-button {
    width: 50px !important;
    height: 40px !important;
    border-radius: 6px !important;
}
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
    <h2 class="header-title"><?= $edit_id ? 'Edit Colour' : 'Add Colour' ?></h2>
</div>

<div class="card-body">

<form action="" method="POST" class="needs-validation" novalidate id="colorForm">
    <input type="hidden" name="edit_id" value="<?= $edit_id ?>">

    <!-- Color Name -->
    <div class="mb-3">
        <label class="form-label">Color Name</label>
        <input type="text" class="form-control" name="color_name" value="<?= htmlspecialchars($color_name) ?>" required>
        <div class="invalid-feedback">Please enter a color name.</div>
    </div>

    <!-- Color Code -->
    <div class="mb-3">
        <label class="form-label">Color Code</label>
        <div class="d-flex align-items-center gap-3">
            <!-- Pickr Button -->
            <div id="pickr" class="pcr-button"></div>
            <!-- Visible Color Code Box -->
            <input type="text" 
                   class="form-control"
                   style="width:150px;"
                   placeholder="#000000"
                   id="colorCodeInput"
                   name="color_code"
                   value="<?= htmlspecialchars($color_code ?: '#000000') ?>"
                   required>
        </div>
        <div class="invalid-feedback">Please select a color code.</div>
    </div>

    <button class="btn btn-primary" type="submit"><?= $edit_id ? 'Update Color' : 'Add Color' ?></button>
</form>

<!-- Pickr Script -->
<script>
const pickr = Pickr.create({
    el: '#pickr',
    theme: 'classic',
    default: '<?= htmlspecialchars($color_code ?: '#000000') ?>',
    components: {
        preview: true,
        opacity: true,
        hue: true,
        interaction: {
            hex: true,
            input: true,
            save: true
        }
    }
});

// Inputs
const input = document.getElementById("colorCodeInput");

// Rename Save → Apply
pickr.on('init', () => {
    const saveBtn = document.querySelector('.pcr-save');
    if (saveBtn) saveBtn.textContent = "Apply";
});

// Apply color
pickr.on('save', (color) => {
    const hex = color.toHEXA().toString();
    input.value = hex;       // put color code inside visible box
    pickr.hide();
});

// Form validation
const form = document.getElementById('colorForm');
form.addEventListener('submit', function(event){
    if(!form.checkValidity()){
        event.preventDefault();
        event.stopPropagation();
    }
    form.classList.add('was-validated');
});
</script>

<?php if(!empty($message)): ?>
<script>
Swal.fire({
    icon: '<?= $message_type ?>',       // success, error, warning
    title: '<?= $message ?>',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
}).then(() => {
    <?php if($message_type === 'success'): ?>
        // Reset form after successful submit
        document.getElementById('colorForm').reset();
        document.getElementById('colorCodeInput').value = '#000000';
        pickr.setColor('#000000'); // reset Pickr button
    <?php endif; ?>
});
</script>
<?php endif; ?>

</div> <!-- card-body -->
</div> <!-- card -->
</div> <!-- col-lg-12 -->
</div> <!-- row -->

</div> <!-- page-container -->
<?php include_once("footer.php"); ?>
</div> <!-- page-content -->

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
