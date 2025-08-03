<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<!-- CSS untuk animasi khusus OTP -->
<style>
    .otp-input {
        transition: all 0.3s ease;
    }
    .otp-input:focus {
        transform: scale(1.05);
    }
    .countdown-wrapper {
        margin-top: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #D56062;
    }
    .submit-btn {
        transition: all 0.3s ease;
    }
    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(213, 96, 98, 0.3);
    }
    .submit-btn:disabled {
        background-color: #e9ecef;
        border-color: #e9ecef;
        color: #6c757d;
    }
    .mental-health-quote {
        font-style: italic;
        color: #6c757d;
        text-align: center;
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 8px;
        background-color: rgba(213, 96, 98, 0.05);
    }
</style>

<div class="container-fluid">
    <div class="bg-login" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0a2342 0%, #D56062 150%);
        z-index: -1;
    "></div>
    <div style="position: absolute; top: 1.5rem; left: 1.5rem;">
        <h5 class="logo me-auto" style="font-size: 20px; font-family: 'Jost', sans-serif; line-height: 1; font-weight: 500; letter-spacing: 2px;">
            <img src="<?= base_url('img/logo.png') ?>" class="mb-1" style="height: 28px; width: 28px;" alt="">
            <a href="<?= base_url('/') ?>" style="text-transform: none; text-decoration: none;"><span style="color: #D56062;">MENTAL</span><span style="color: #A9A9A9;">CARE</span></a>
        </h5>
    </div>
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-xl-5 col-lg-12 col-md-9">
            <div class="card" style="background: rgba(255, 255, 255, 0.95); border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('img/logo.png') ?>" width="80px" height="80px" alt="MentalCare Logo" class="mb-3">
                                    <h1 class="h4 text-gray-900 mb-2">Verifikasi Email</h1>
                                    <p class="text-muted">Masukkan kode verifikasi yang telah kami kirim ke email Anda untuk melanjutkan pendaftaran di MentalCare.</p>
                                </div>

                                <?php include(APPPATH . 'Views/components/alerts.php'); ?>

                                <form method="POST" action="<?= base_url('verify-otp') ?>" id="otpForm" class="user">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="otp_expiry" id="otpExpiry">
                                    <div class="form-group">
                                        <div class="otp-input-container d-flex justify-content-center gap-3 mb-4">
                                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                                <input type="text" class="form-control form-control-lg text-center otp-input" 
                                                    style="width: 60px; height: 60px; font-size: 24px; border-radius: 12px; border: 2px solid #D56062;" 
                                                    maxlength="1" data-index="<?= $i ?>" required>
                                            <?php endfor; ?>
                                        </div>
                                        <input type="hidden" name="otp" id="otpValue">
                                        
                                        <div class="countdown-wrapper text-center mb-3">
                                            <small class="text-muted" id="countdown-message">
                                                Kode verifikasi akan kadaluarsa dalam <span id="countdown" class="text-danger fw-bold"></span>
                                            </small>
                                        </div>
                                        
                                        <div class="text-center mb-3">
    <?php if (session()->getFlashdata('errorr') === 'Untuk keamanan, sesi verifikasi telah berakhir karena terlalu banyak percobaan. Silakan daftar ulang.') : ?>
        <div class="alert alert-danger" id="otp-limit-alert">
            Anda telah melebihi batas percobaan verifikasi. Silakan daftar ulang.
        </div>
    <?php else: ?>
        <small class="text-muted" id="attempts-info">
            Sisa <?= 3 - (session()->get('otp_attempts') ?? 0) ?> kali kesempatan verifikasi
        </small>
    <?php endif; ?>
</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block submit-btn" 
                                            id="submitBtn" style="background-color: #D56062; border: none; padding: 12px; font-size: 16px; border-radius: 8px;">
                                        Verifikasi Email
                                    </button>
                                </form>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="small mb-2">
                                        Tidak menerima kode? 
                                        <a href="javascript:void(0)" id="resendBtn" class="text-primary text-decoration-none">
                                            Kirim ulang
                                        </a>
                                        <span id="resendTimer" class="text-muted"></span>
                                    </p>
                                    <a class="small text-muted" href="<?= base_url('login-user') ?>">
                                        Kembali ke Halaman Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpForm = document.getElementById('otpForm');
        const submitBtn = document.getElementById('submitBtn');
        const otpValue = document.getElementById('otpValue');
        const resendBtn = document.getElementById('resendBtn');
        const resendTimer = document.getElementById('resendTimer');

        // --- OTP LIMIT HANDLING ---
        const otpLimitAlert = document.getElementById('otp-limit-alert');
        if (otpLimitAlert) {
            // Disable all OTP input and submit/resend
            otpInputs.forEach(input => {
                input.disabled = true;
                input.style.backgroundColor = '#f8f9fa';
            });
            if (submitBtn) submitBtn.disabled = true;
            if (resendBtn) resendBtn.style.display = 'none';
            if (resendTimer) resendTimer.style.display = 'none';
            // Redirect ke halaman register setelah 4 detik
            setTimeout(function() {
                window.location.href = '<?= base_url('register') ?>';
            }, 4000);
            return; // Stop further JS
        }
        
        // Disable submit button initially
        submitBtn.disabled = true;
        
        // Handle form submission
        otpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let otp = '';
            otpInputs.forEach(input => otp += input.value);
            
            if (otp.length === 6) {
                otpValue.value = otp;
                this.submit();
            }
        });
        
        // OTP Input Handler
        otpInputs.forEach((input, index) => {
            // Style focus state
            input.addEventListener('focus', function() {
                this.style.borderColor = '#0a2342';
                this.style.boxShadow = '0 0 0 0.2rem rgba(10, 35, 66, 0.25)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = '#D56062';
                this.style.boxShadow = 'none';
            });

            // Handle input
            input.addEventListener('keyup', (e) => {
                if (e.key !== 'Backspace' && e.key !== 'Delete') {
                    const next = input.nextElementSibling;
                    if (next && input.value) {
                        next.focus();
                    }
                }
                
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    const prev = input.previousElementSibling;
                    if (prev) {
                        prev.focus();
                    }
                }
                
                // Combine OTP values
                let otp = '';
                otpInputs.forEach(input => otp += input.value);
                otpValue.value = otp;
                
                // Enable/disable submit button
                submitBtn.disabled = otp.length !== 6;
            });
            
            // Allow only alphanumeric characters
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
            });

            // Handle paste event
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                
                if (pastedText.length === 6 && /^[a-zA-Z0-9]{6}$/.test(pastedText)) {
                    otpInputs.forEach((input, i) => {
                        input.value = pastedText[i];
                    });
                    otpValue.value = pastedText;
                    submitBtn.disabled = false;
                    otpInputs[5].focus();
                }
            });
        });
        
        // Countdown Timer
        function startCountdown(duration, display, messageDisplay) {
            const startTime = new Date().getTime();
            document.getElementById('otpExpiry').value = startTime + (duration * 1000);
            
            function updateCountdown() {
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - startTime;
                const remainingTime = duration - Math.floor(elapsedTime / 1000);
                
                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    display.textContent = "00:00";
                    messageDisplay.innerHTML = '<span class="text-danger">Kode verifikasi sudah kadaluarsa</span>';
                    
                    // Disable form
                    otpInputs.forEach(input => {
                        input.disabled = true;
                        input.style.backgroundColor = '#f8f9fa';
                    });
                    submitBtn.disabled = true;
                    
                    // Show resend button
                    resendBtn.style.display = 'inline';
                    resendTimer.style.display = 'none';
                } else {
                    const minutes = Math.floor(remainingTime / 60);
                    const seconds = remainingTime % 60;
                    
                    display.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }
            }
            
            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
            return countdownInterval;
        }
        
        // Start initial countdown
        const fiveMinutes = 5 * 60;
        const display = document.querySelector('#countdown');
        const messageDisplay = document.querySelector('#countdown-message');
        let countdownInterval = startCountdown(fiveMinutes, display, messageDisplay);
        
        // Resend OTP Handler
        let resendCount = 0;
        resendBtn.addEventListener('click', function() {
            if (resendCount >= 2) {
                alert('Anda telah mencapai batas maksimal pengiriman ulang kode verifikasi. Silakan daftar ulang.');
                window.location.href = '<?= base_url('register') ?>';
                return;
            }

            // Disable resend button
            resendBtn.style.display = 'none';
            resendTimer.style.display = 'inline';

            // Send AJAX request to resend OTP
            fetch('<?= base_url('resend-otp') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset OTP inputs
                    otpInputs.forEach(input => {
                        input.value = '';
                        input.disabled = false;
                        input.style.backgroundColor = '#fff';
                    });
                    otpInputs[0].focus();
                    submitBtn.disabled = true;

                    // Reset countdown
                    clearInterval(countdownInterval);
                    countdownInterval = startCountdown(fiveMinutes, display, messageDisplay);

                    // Start resend cooldown
                    let cooldown = 30;
                    resendTimer.textContent = ` (${cooldown}s)`;
                    const timerInterval = setInterval(() => {
                        cooldown--;
                        resendTimer.textContent = ` (${cooldown}s)`;
                        if (cooldown <= 0) {
                            clearInterval(timerInterval);
                            resendBtn.style.display = 'inline';
                            resendTimer.style.display = 'none';
                        }
                    }, 1000);

                    resendCount++;
                } else {
                    alert(data.message);
                    if (data.message === 'Sesi registrasi telah berakhir') {
                        window.location.href = '<?= base_url('register') ?>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    });
</script>

<?= $this->endSection() ?>
