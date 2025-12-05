<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$error = "";

/* ================== SECURITY CHECK ================== */
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email']) || !isset($_SESSION['otp_time'])) {
    header("Location: recoverpw.php");
    exit;
}

/* ================== AJAX RESEND OTP ================== */
if (isset($_POST['action']) && $_POST['action'] === 'resend_otp') {
    $email = $_SESSION['otp_email'];
    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;
    $_SESSION['otp_time'] = time();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'speczo2025@gmail.com';
        $mail->Password = 'jiba hqeg hpyg avgs';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('speczo2025@gmail.com', 'OTP Verification');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "<h2>Your OTP is: <b>$otp</b></h2>";

        $mail->send();
        echo json_encode(['status'=>'success']);
    } catch (Exception $e) {
        echo json_encode(['status'=>'error']);
    }
    exit;
}

/* ================== AJAX VERIFY OTP ================== */
if (isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    $input_otp = '';
    for ($i = 1; $i <= 6; $i++) {
        $input_otp .= $_POST["digit$i"] ?? '';
    }

    $current_time = time();
    $time_limit = 60;

    if ($current_time - $_SESSION['otp_time'] > $time_limit) {
        echo json_encode(['status'=>'error','message'=>'OTP expired!']);
    } elseif ((string)$input_otp !== (string)$_SESSION['otp']) {
        echo json_encode(['status'=>'error','message'=>'Invalid OTP!']);
    } else {
        $_SESSION['otp_verified'] = true;
        echo json_encode(['status'=>'success','redirect'=>'createpw.php']);
    }
    exit;
}

/* ================== TIMER ================== */
$time_limit = 60;
$current_time = time();
$time_left = $time_limit - ($current_time - $_SESSION['otp_time']);
if ($time_left < 0) $time_left = 0;

$email = $_SESSION['otp_email'];
?>


<!DOCTYPE html>
<html lang="en" data-layout="">
<!-- Mirrored from coderthemes.com/adminto/layouts/login-pin.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Login with Pin | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
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
                    <h4 class="fw-semibold mb-2 fs-20">Login with PIN</h4>

                    <p class="text-muted mb-4">
						We sent you a code, please enter it below to verify your email: <br />
						<span class="link-dark fs-13 fw-medium"><?= htmlspecialchars($email) ?></span>
					</p>
					
					<form method="POST" id="otpForm" class="text-start mb-3">
                    <label class="form-label">Enter 6 Digit Code</label>

                    <div class="d-flex gap-2 mt-1 mb-2">
                        <?php for($i=1;$i<=6;$i++): ?>
                            <input type="text" maxlength="1" class="form-control text-center otp-input" name="digit<?= $i ?>">
                        <?php endfor; ?>
                    </div>

                    <!-- FIXED ERROR POSITION -->
                    <div id="otp-error" class="text-danger mb-2" style="min-height:20px;"></div>

                    <div class="mb-2">
                        Time left: <span id="timer"><?= sprintf('%02d:%02d', floor($time_left/60), $time_left%60) ?></span>
                    </div>

                    <div class="mb-3 d-grid">
                        <button id="submitBtn" class="btn btn-primary fw-semibold" type="submit">Continue</button>
                    </div>

                    <p class="text-muted fs-14 mb-0" id="resendBox" style="display:none;">
                        Didn’t receive OTP?
                        <a href="#" id="resendOtp" class="fw-semibold text-danger ms-1">Resend OTP</a>
                    </p>
                </form>

                <p class="fs-14 text-muted">Back to
                    <a href="login.php" class="fw-semibold text-danger ms-1">Login</a>
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
const inputs = document.querySelectorAll('.otp-input');
let timeLeft = <?= $time_left ?>;
const timerEl = document.getElementById('timer');
const resendBox = document.getElementById('resendBox');
const submitBtn = document.getElementById('submitBtn');
let timerInterval;

/* Auto move cursor */
inputs.forEach((input,i)=>{
    input.addEventListener('input',()=>{
        if(input.value && i < 5) inputs[i+1].focus();
    });
    input.addEventListener('keydown', e=>{
        if(e.key==="Backspace" && !input.value && i>0) inputs[i-1].focus();
    });
});

/* Start Timer */
function startTimer(){
    clearInterval(timerInterval);
    timerInterval = setInterval(()=>{
        let m = Math.floor(timeLeft/60);
        let s = timeLeft % 60;
        timerEl.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;

        if(timeLeft <= 0){
            clearInterval(timerInterval);
            inputs.forEach(i=>i.disabled=true);
            submitBtn.disabled = true;
            resendBox.style.display = 'block';
        }
        timeLeft--;
    }, 1000);
}
if(timeLeft>0) startTimer();

/* OTP Submit */
document.getElementById('otpForm').addEventListener('submit', function(e){
    e.preventDefault();

    let otp = '';
    inputs.forEach(i => otp += i.value.trim());

    const err = document.getElementById('otp-error');

    if(otp.length < 6){
        err.textContent = "Please enter the 6-digit OTP!";
        return;
    }
    err.textContent = "";  // clear old error

    const formData = new FormData(this);
    formData.append('action','verify_otp');

    fetch('login-pin.php',{ method:'POST', body:formData })
    .then(res=>res.json())
    .then(data=>{
        if(data.status === 'success'){
            Swal.fire({
                icon:'success',
                title:'OTP Verified Successfully',
                timer:1000,
                showConfirmButton:false
            }).then(()=> window.location.href = data.redirect );
        } else {
            err.textContent = data.message; // INVALID / EXPIRED
        }
    });
});

/* Resend OTP */
document.getElementById('resendOtp').addEventListener('click', function(e){
    e.preventDefault();

    fetch('login-pin.php',{
        method:'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'action=resend_otp'
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.status==='success'){
            Swal.fire({icon:'success', title:'OTP Sent Again!', timer:1000});
            inputs.forEach(i=>{ i.value=''; i.disabled=false; });
            submitBtn.disabled=false;
            timeLeft = 60;
            resendBox.style.display='none';
            startTimer();
        } else {
            Swal.fire({icon:'error', title:'Failed to Send OTP'});
        }
    });
});

/* -------------- ADDED PART (ONLY THIS) -------------- */
inputs.forEach(input=>{
    input.addEventListener('input', ()=> {
        document.getElementById('otp-error').textContent = "";
    });
});
/* ---------------------------------------------------- */

</script>


    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	</body>

<!-- Mirrored from coderthemes.com/adminto/layouts/login-pin.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:39 GMT -->
</html>