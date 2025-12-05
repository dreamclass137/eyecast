<?php
include 'connection.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$error = "";   
$success_msg = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');

    // ===== SERVER SIDE VALIDATION =====
    if ($email === "") {
        $error = "Please enter your email!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email!";
    } else {
        // ===== DATABASE CHECK =====
        $stmt = $conn->prepare("SELECT * FROM admin_tbl WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $error = "Email not registered!";
        } else {
            // ===== SEND OTP =====
            $_SESSION['otp_email'] = $email;
            $_SESSION['otp'] = rand(100000, 999999);
            $_SESSION['otp_time'] = time();

            $mail = new PHPMailer(true);
            try {
                // ✅ FIXED SMTP SETTINGS
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'speczo2025@gmail.com';   // Your Gmail
                $mail->Password   = 'jiba hqeg hpyg avgs';    // Your App Password (spaces are OK)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ✅ use constant instead of string 'tls'
                $mail->Port       = 587;
                $mail->SMTPOptions = [                          // ✅ Fix SSL certificate issues on localhost
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ]
                ];

                $mail->setFrom('speczo2025@gmail.com', 'OTP Verification'); // ✅ must match Username
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = "<h2>Your OTP is: <b>{$_SESSION['otp']}</b></h2>
                                  <p>This OTP is valid for 10 minutes.</p>";
                $mail->AltBody = "Your OTP is: {$_SESSION['otp']}";

                $mail->send();
                $success_msg = "OTP has been sent to your email successfully!";

            } catch (Exception $e) {
                // ✅ Show actual error for easier debugging
                $error = "Failed to send OTP: " . $mail->ErrorInfo;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en" data-layout="">
	<head>
		<meta charset="utf-8" />
		<title>Reset Password | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
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
		
		<!-- SweetAlert2 -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<style>
			.error-text { color: red; font-size: 0.875rem; margin-top: 0.25rem; }
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

						<h4 class="fw-semibold mb-3 fs-18">Reset Your Password</h4>

						<p class="text-muted mb-4">Enter your email address and we'll send you an email with instructions to
							reset your password.</p>
						
						<form method="POST" id="resetForm" class="text-start mb-3">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off">
                        <div id="email-error" class="error-text"><?php echo $error; ?></div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary fw-semibold" type="submit">Reset Password</button>
                    </div>
                </form>

						<p class="text-muted fs-14 mb-0">
							Back To <a href="login.php" class="fw-semibold text-danger ms-1">Login !</a>
						</p>
					</div>
					<p class="mt-4 text-center mb-0">
						<script>document.write(new Date().getFullYear())</script> © Adminto - By <span
							class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Coderthemes</span>
					</p>
				</div>
			</div>
		</div>
		
		<script>
// JS live validation
const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error');

emailInput.addEventListener('input', () => {
    emailInput.classList.remove('is-invalid');
    emailError.innerText = '';
});

// JS form submit validation
document.getElementById('resetForm').addEventListener('submit', function(e){
    e.preventDefault();
    const emailVal = emailInput.value.trim();

    if(emailVal === ''){
        emailInput.classList.add('is-invalid');
        emailError.innerText = 'Please enter your email!';
        return;
    }

    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!pattern.test(emailVal)){
        emailInput.classList.add('is-invalid');
        emailError.innerText = 'Please enter a valid email!';
        return;
    }

    this.submit();
});
</script>

<?php if($success_msg != ""): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'OTP Sent!',
    text: '<?php echo $success_msg; ?>',
    confirmButtonColor: '#28a745',
    confirmButtonText: 'OK',
}).then(() => {
    window.location.href = "login-pin.php";
});
</script>
<?php endif; ?>

		
		<!-- Vendor js -->
		<script src="assets/js/vendor.min.js"></script>

		<!-- App js -->
		<script src="assets/js/app.js"></script>
		
	</body>
</html>