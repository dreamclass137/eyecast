<?php
include "connection.php"; // Database connection

$showSuccess = false;

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $shape_id = $_POST['shape_id'];
    $description = $_POST['description'];
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $created_at = $_POST['created_at'];
    $status = $_POST['status'];

    // Server-side validation
    if($title && $category_id && $shape_id && $description && $gender && $price && $size && $created_at && $status){
        $sql = "INSERT INTO product_tbl (title, category_id, shape_id, description, gender, price, size, created_at, status) 
                VALUES ('$title','$category_id','$shape_id','$description','$gender','$price','$size','$created_at','$status')";
        
        if(mysqli_query($conn, $sql)){
            $showSuccess = true; // allow JavaScript alert
        }
    }
}

// Fetch categories & shapes
$catQuery = mysqli_query($conn, "SELECT * FROM category_tbl WHERE status='Active' ORDER BY c_name ASC");
$shapeQuery = mysqli_query($conn, "SELECT * FROM shape_tbl WHERE status='Active' ORDER BY s_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <title>Adminto | Add Product</title>
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

<style>
.error-msg { color:red;font-size:0.9em; }
.is-invalid { border-color:red !important; }
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
                    <h2 class="header-title">Add Product</h2>
                </div>

                <div class="card-body">
                    <form method="POST" id="productForm">

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="error-msg" id="titleError"></span>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                <?php while($cat = mysqli_fetch_assoc($catQuery)){ ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= $cat['c_name'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="error-msg" id="category_idError"></span>
                        </div>

                        <!-- Shape -->
                        <div class="mb-3">
                            <label class="form-label">Shape</label>
                            <select class="form-select" id="shape_id" name="shape_id">
                                <option value="">Select Shape</option>
                                <?php while($shape = mysqli_fetch_assoc($shapeQuery)){ ?>
                                    <option value="<?= $shape['shape_id'] ?>"><?= $shape['s_name'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="error-msg" id="shape_idError"></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                            <span class="error-msg" id="descriptionError"></span>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Men">Men</option>
                                <option value="Women">Women</option>
                                <option value="Kids">Kids</option>
								<option value="All">All</option>
                            </select>
                            <span class="error-msg" id="genderError"></span>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price">
                            <span class="error-msg" id="priceError"></span>
                        </div>

                        <!-- Size -->
                        <div class="mb-3">
                                    <label for="size" class="form-label">Size</label>
                                    <select class="form-select" id="size" name="size">
                                        <option value="" hidden>Select Size</option>
                                        <option value="Extra Narrow">Extra Narrow</option>
                                        <option value="Narrow">Narrow</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Wide">Wide</option>
                                        <option value="Extra Wide">Extra Wide</option>
                                    </select>
                            <span class="error-msg" id="sizeError"></span>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at">
                            <span class="error-msg" id="created_atError"></span>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="statusSelect" name="status">
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <span class="error-msg" id="statusSelectError"></span>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-10">Add Product</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
</div>
</div>

<script>
const validationRules = {
    title: "Please enter product title",
    category_id: "Please select a category",
    shape_id: "Please select a shape",
    description: "Description is required",
    gender: "Please select gender",
    price: "Price cannot be empty (Only numbers allowed)",
    size: "Enter size information",
    created_at: "Please pick a creation date",
    statusSelect: "Choose a status"
};

// Validate single field
function validateField(id){
    let input = document.getElementById(id);
    let error = document.getElementById(id + 'Error');
    let value = input.value.trim();

    if(value === ""){
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        if(error) error.innerHTML = validationRules[id];
        return false;
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        if(error) error.innerHTML = "";
        return true;
    }
}

// Attach real-time validation
Object.keys(validationRules).forEach(id => {
    let field = document.getElementById(id);

    if(!field) return;

    field.addEventListener('input', () => validateField(id));
    field.addEventListener('change', () => validateField(id));
});

// Validate on submit
document.getElementById('productForm').addEventListener('submit', function(e){
    let valid = true;

    Object.keys(validationRules).forEach(id => {
        if(!validateField(id)) valid = false;
    });

    if(!valid){
        e.preventDefault();
        Swal.fire("error ", "Please fill all fields.", "warning");
    }
});

<?php if($showSuccess): ?>
setTimeout(()=>{
    Swal.fire({
        icon: 'success',
        title: 'Product Added Successfully!',
        timer: 1500,
        showConfirmButton: false
    });

    // Reset form values
    const form = document.getElementById('productForm');
    form.reset();

    // Remove validation colors
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.classList.remove('is-valid', 'is-invalid');
    });

    // Clear all error text
    document.querySelectorAll('.error-msg').forEach(err => err.innerHTML = '');
},200);
<?php endif; ?>
 
</script>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
</body>
</html>
