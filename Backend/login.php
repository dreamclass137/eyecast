<?php
include 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === "" && $password === "") {
        echo json_encode(['status' => 'empty']); exit;
    } elseif ($email === "") {
        echo json_encode(['status' => 'email_empty']); exit;
    } elseif ($password === "") {
        echo json_encode(['status' => 'password_empty']); exit;
    }

    $stmt = $conn->prepare("SELECT admin_id, username, password FROM admin_tbl WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(['status' => 'email_wrong']); exit;
    }

    $row = $res->fetch_assoc();
    if (!password_verify($password, $row['password'])) {
        echo json_encode(['status' => 'password_wrong']); exit;
    }

    $_SESSION['admin_id']   = $row['admin_id'];
    $_SESSION['username'] = $row['username'];



    echo json_encode(['status' => 'success']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-layout="">


<!-- Mirrored from coderthemes.com/adminto/layouts/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Log In | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
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

                    <h4 class="fw-semibold mb-3 fs-18">Log in to your account</h4>

						<!-- LOGIN FORM -->
						<form method="POST" id="loginForm" class="text-start mb-3" novalidate>
							<input type="hidden" name="action" value="login">


							<div class="mb-3">
								<label class="form-label" for="email">Email</label>
								<input type="email" id="email" name="email"
									   class="form-control" placeholder="Enter your email">
								<small id="email-error" class="text-danger"></small>
							</div>

							<div class="mb-3">
								<label class="form-label" for="password">Password</label>
								<input type="password" id="password" name="password"
									   class="form-control" placeholder="Enter your password">
								<small id="password-error" class="text-danger"></small>
							</div>

							<div class="d-flex justify-content-between mb-3">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="checkbox-signin">
									<label class="form-check-label" for="checkbox-signin">Remember me</label>
								</div>

								<a href="recoverpw.php" class="text-muted border-bottom border-dashed">Forget
										Password</a>
								</div>

							<div class="d-grid">
								<button class="btn btn-primary fw-semibold" type="submit">Login</button>
							</div>

						</form>

                </div>
                <p class="mt-4 text-center mb-0">
                    <script>document.write(new Date().getFullYear())</script> © Adminto - By <span
                        class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Coderthemes</span>
                </p>
            </div>
        </div>
    </div>
		
	<script>
const form = document.getElementById('loginForm');
const emailEl = document.getElementById('email');
const passEl = document.getElementById('password');
const emailErr = document.getElementById('email-error');
const passErr = document.getElementById('password-error');

/* ✅ AUTO CLEAR ERROR ON TYPING */
emailEl.addEventListener('input', () => {
    emailEl.classList.remove('is-invalid');
    emailErr.innerText = '';
});
passEl.addEventListener('input', () => {
    passEl.classList.remove('is-invalid');
    passErr.innerText = '';
});

form.addEventListener('submit', function(e){
    e.preventDefault();

    emailErr.innerText = '';
    passErr.innerText = '';
    emailEl.classList.remove('is-invalid');
    passEl.classList.remove('is-invalid');

    let valid = true;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(emailEl.value.trim()===''){
        emailErr.innerText='Enter email';
        emailEl.classList.add('is-invalid');
        valid=false;
    } else if(!emailPattern.test(emailEl.value.trim())){
        emailErr.innerText='Invalid email';
        emailEl.classList.add('is-invalid');
        valid=false;
    }

    if(passEl.value.trim()===''){
        passErr.innerText='Enter password';
        passEl.classList.add('is-invalid');
        valid=false;
    }

    if(!valid) return;

    fetch('login.php',{method:'POST',body:new FormData(this)})
    .then(r=>r.json())
    .then(data=>{
        if(data.status==='email_wrong'){
            emailErr.innerText='Email not registered';
            emailEl.classList.add('is-invalid');
        }
        else if(data.status==='password_wrong'){
            passErr.innerText='Wrong password';
            passEl.classList.add('is-invalid');
        }
        else if(data.status==='success'){
            Swal.fire({
                icon:'success',
                title:'Login Successful',
                timer:1500,
                showConfirmButton:false,
                willClose:()=>location.href='index.php'
            });
        }
    });
});
</script>

	
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

	</body>
<!-- Mirrored from coderthemes.com/adminto/layouts/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
</html>