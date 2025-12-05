<?php
ob_start(); // Start output buffering
include 'connection.php';
session_start();

/* ================= SECURITY CHECK ================= */
if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['otp_email'])) {
    header("Location: recoverpw.php");
    exit;
}

$email = $_SESSION['otp_email'];
$error = '';

/* ================= SERVER SIDE VALIDATION ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $new = $_POST['new_password'] ?? '';
    $re  = $_POST['re_password'] ?? '';

    $strongPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{4,}$/';

    if ($new !== "" && $new === $re && preg_match($strongPattern, $new)) {
        $hash = password_hash($new, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE admin_tbl SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hash, $email);
        $stmt->execute();

        session_unset();
        session_destroy();

        $success = true;
    } else {
        $error = "Passwords do not match or do not meet strength requirements.";
    }
}
?>



<!DOCTYPE html>
<html lang="en" data-layout="">


<!-- Mirrored from coderthemes.com/adminto/layouts/createpw.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Create Password | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
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
	
	<!-- Add this in the <head> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
	<style>
		/* Error message style */
		.error-text {
			color: red !important;       /* Force red color */
			font-size: 0.875rem;
			margin-top: 0.25rem;
		}

		/* Input red border */
		.is-invalid {
			border-color: red !important;
		}
	</style>

</head>

<body class="h-100">
    <div class="auth-bg d-flex min-vh-100">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xxl-3 col-lg-5 col-md-6">
                <a href="index.php" class="auth-brand d-flex justify-content-center mb-2">
                    <img src="assets/images/logo-dark.png" alt="dark logo" height="26" class="logo-dark">
                    <img src="assets/images/logo.png" alt="logo light" height="26" class="logo-light">
                </a>

                <p class="fw-semibold mb-4 text-center text-muted fs-15">Admin Panel Design by Coderthemes</p>

                <div class="card overflow-hidden text-center p-xxl-4 p-3 mb-0">

                    <h4 class="fw-semibold mb-2 fs-20">Create New Password</h4>

                    <p class="text-muted mb-2">Please create your new password.</p>
                    <!--<p class="mb-4">Need password suggestion ? <a href="#!"
                            class="link-dark fw-semibold text-decoration-underline">Suggestion</a></p>-->
							
						<form id="createPwForm" method="POST" class="text-start mb-3">
							<div class="mb-3">
								<label class="form-label">Create New Password</label>
								<input type="password" id="new-password" name="new_password"
									   class="form-control" placeholder="New Password">
								<div id="new-password-error" class="error-text"></div>
							</div>

							<div class="mb-3">
								<label class="form-label">Reenter New Password</label>
								<input type="password" id="re-password" name="re_password"
									   class="form-control" placeholder="Reenter Password">
								<div id="re-password-error" class="error-text"></div>
							</div>

							<div class="d-grid">
								<button class="btn btn-primary" type="submit">Create New Password</button>
							</div>
							
						</form>

                    <p class="text-muted fs-14 mb-0">
                        Back To <a href="login.php" class="fw-semibold text-danger ms-1">Login !</a>
                    </p>
                </div>

                <p class="mt-3 text-center mb-0">
                    <script>document.write(new Date().getFullYear())</script> © Adminto - By <span
                        class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Coderthemes</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
	
	<!-- Include this above your JS validation script -->
	<script src="assets/js/sweetalert2.min.js"></script>

	<script>
document.addEventListener('DOMContentLoaded', function () {

    const pwInput = document.getElementById('new-password');
    const cpwInput = document.getElementById('re-password');
    const form = document.getElementById('createPwForm');

    const strongPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{4,}$/;

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: message
        });
    }

    function resetBorders() {
        pwInput.classList.remove('is-invalid');
        cpwInput.classList.remove('is-invalid');
    } 

    form.addEventListener('submit', function (e) {
        resetBorders();

        const pw = pwInput.value.trim();
        const cpw = cpwInput.value.trim();

        if (pw === '') {
            pwInput.classList.add('is-invalid');
            showError('Please enter new password');
            e.preventDefault();
            return;
        }

        if (!strongPattern.test(pw)) {
            pwInput.classList.add('is-invalid');
            showError(
                'Password must contain uppercase, lowercase, number & special character (min 4 chars)'
            );
            e.preventDefault();
            return;
        }

        if (cpw === '') {
            cpwInput.classList.add('is-invalid');
            showError('Please re-enter password');
            e.preventDefault();
            return;
        }

        if (pw !== cpw) {
            cpwInput.classList.add('is-invalid');
            showError('Passwords do not match');
            e.preventDefault();
            return;
        }
    });

    <?php if (isset($success) && $success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Password Updated',
            text: 'Your password has been successfully updated!',
			confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
        }).then(() => {
            window.location.href = 'login.php';
        });
    <?php endif; ?>

});
</script>


</body>

<!-- Mirrored from coderthemes.com/adminto/layouts/createpw.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
</html>