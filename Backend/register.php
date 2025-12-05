<?php
include 'connection.php';
session_start();

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    /* ================= SERVER SIDE VALIDATION ================= */

    // 1️⃣ Empty check
    if ($name === '' || $email === '' || $password === '') {
        $response = [
            'status'  => 'error',
            'message' => 'All fields are required'
        ];
    }

    // 2️⃣ Name validation (min 3 letters)
    elseif (!preg_match("/^[a-zA-Z ]{3,}$/", $name)) {
        $response = [
            'status'  => 'error',
            'message' => 'Name must contain at least 3 letters'
        ];
    }

    // 3️⃣ Email validation (must include @ and domain)
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'status'  => 'error',
            'message' => 'Please enter a valid email address'
        ];
    }

    // 4️⃣ Strong password validation
    elseif (!preg_match(
        "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#]).{4,}$/",
        $password
    )) {
        $response = [
            'status'  => 'error',
            'message' => 'Password must be 4+ characters with uppercase, lowercase, number & special character'
        ];
    }

    /* ================= DATABASE CHECK ================= */
    else {

        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM admin_tbl WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = [
                'status'  => 'error',
                'message' => 'Email already exists. Please login'
            ];
        } 
        else {
            // Insert new admin
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $insert = $conn->prepare(
                "INSERT INTO admin_tbl (username, email, password) VALUES (?, ?, ?)"
            );
            $insert->bind_param("sss", $name, $email, $hashedPassword);

            if ($insert->execute()) {
                $response = [
                    'status'  => 'success',
                    'message' => 'Registered successfully!'
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => 'Something went wrong. Please try again'
                ];
            }
        }
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-layout="">


<!-- Mirrored from coderthemes.com/adminto/layouts/register.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Sign Up | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
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

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	
	<!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div class="auth-bg d-flex min-vh-100">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xxl-3 col-lg-5 col-md-6">
                <a href="index.php" class="auth-brand d-flex justify-content-center mb-2">
                    <img src="assets/images/logo-dark.png" alt="dark logo" height="26" class="logo-dark">
                    <img src="assets/images/logo.png" alt="logo light" height="26" class="logo-light">
                </a>

                <p class="fw-semibold mb-4 text-center text-muted fs-15">Admin Panel Design by Coderthemes</p>

                <div class="card overflow-hidden text-center p-xxl-4 p-3 mb-0">

                    <h4 class="fw-semibold mb-3 fs-18">Sign Up to your account</h4>

						<form id="registerForm" method="POST" class="text-start">
							<input type="hidden" name="action" value="register">

	
						<div class="mb-3">
							<label class="form-label">Your Name</label>
							<input type="text" id="name" name="name" class="form-control" placeholder="Enter your name">
							<small id="name-error" class="text-danger"></small>
						</div>

						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="email" id="email" name="email" class="form-control"placeholder="Enter your email">
							<small id="email-error" class="text-danger"></small>
						</div>

						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
							<small id="password-error" class="text-danger"></small>
						</div>

                    <button class="btn btn-primary w-100 fw-semibold" type="submit">Sign Up</button>

                </form>

               
                <p class="text-muted mt-3 mb-0">
                    Already have an account? <a href="login.php" class="text-danger fw-semibold">Login</a>
                </p>

				
                </div>
                <p class="mt-4 text-center mb-0">
                    <script>document.write(new Date().getFullYear())</script> © Adminto - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Coderthemes</span>
                </p>           
			</div>
        </div>
    </div>
	
	<script>
function clearError(id){
    document.getElementById(id+'-error').innerText = '';
    document.getElementById(id).classList.remove('is-invalid');
}

['name','email','password'].forEach(id=>{
    document.getElementById(id).addEventListener('input',()=>{
        clearError(id);
        liveValidate(id);
    });
});

function liveValidate(id){
    let val = document.getElementById(id).value.trim();

    /* Email validation: must have @ and domain */
    if(id === 'email' && val !== ''){
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailPattern.test(val)){
            showError(id,'Invalid email format');
        }
    }

    /* Strong password validation */
    if(id === 'password' && val !== ''){
        const passPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#]).{4,}$/;
        if(!passPattern.test(val)){
            showError(id,'Password must be 4+ chars with uppercase, lowercase, number & symbol');
        }
    }
}

function showError(id,msg){
    document.getElementById(id).classList.add('is-invalid');
    document.getElementById(id+'-error').innerText = msg;
}

document.getElementById('registerForm').addEventListener('submit',function(e){
    e.preventDefault();
    let valid = true;

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    /* ===== REQUIRED FIELD CHECK ===== */
    if(name === ''){
        showError('name','Please enter name');
        valid = false;
    }
    if(email === ''){
        showError('email','Please enter email');
        valid = false;
    }
    if(password === ''){
        showError('password','Please enter password');
        valid = false;
    }

    if(!valid) return;

    /* ===== PATTERN VALIDATION ===== */
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passPattern  = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#]).{4,}$/;

    if(!emailPattern.test(email)){
        showError('email','Invalid email format');
        valid = false;
    }

    if(!passPattern.test(password)){
        showError('password','Password must be 4+ chars with uppercase, lowercase, number & symbol');
        valid = false;
    }

    if(!valid) return;

    /* ===== AJAX SUBMIT ===== */
    const formData = new FormData(this);
    fetch('register.php',{method:'POST',body:formData})
    .then(res=>res.json())
    .then(data=>{
        if(data.status==='success'){
            Swal.fire({
                icon:'success',
                title:data.message,
                timer:1500,
                showConfirmButton:false
            }).then(()=>location.href='login.php');
        }else{
            Swal.fire({icon:'error',title:data.message});
        }
    });
});
</script>
	
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>
<!-- Mirrored from coderthemes.com/adminto/layouts/register.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
</html>