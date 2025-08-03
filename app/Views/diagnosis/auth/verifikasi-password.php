<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>
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
            <div class="card" style="background: rgba(255, 255, 255, 0.9);">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="<?= base_url('img/logo.png') ?>" width="70px" height="70px">
                                    <h1 class="h4 text-gray-900 mb-4">Silahkan Masukkan Password Baru</h1>
                                </div>
                                <?php include(APPPATH . 'Views/components/alerts.php'); ?>
                                <form method="POST" action="<?= base_url('reset-password') ?>" novalidate>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="token" value="<?= $token ?>">
                                    <div class="form-group">
                                        <div class="input-group has-validation">
                                            <input type="password" class="form-control form-control-user" name="new_password" id="password" placeholder="Password Baru" required>
                                            <button class="btn btn-outline-primary" type="button" onclick="togglePassword('password', 'eyeIcon', 'eyeSlashIcon')">
                                                <i class="fas fa-eye-slash" id="eyeSlashIcon"></i>
                                                <i class="fas fa-eye d-none" id="eyeIcon"></i>
                                            </button>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div id="passwordStrength" class="mt-1 mb-0"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group has-validation">
                                            <input type="password" class="form-control form-control-user" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password Baru" required>
                                            <button class="btn btn-outline-primary" type="button" onclick="togglePassword('confirm_password', 'confirmEyeIcon', 'confirmEyeSlashIcon')">
                                                <i class="fas fa-eye-slash" id="confirmEyeSlashIcon"></i>
                                                <i class="fas fa-eye d-none" id="confirmEyeIcon"></i>
                                            </button>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #D56062; border-color: #D56062;">
                                        Submit
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('login-user') ?>">Kembali ke Halaman Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('page_scripts') ?>
<script>
// Fungsi toggle password tetap sama
function togglePassword(inputId, eyeIconId, eyeSlashIconId) {
    const input = document.getElementById(inputId);
    const eyeIcon = document.getElementById(eyeIconId);
    const eyeSlashIcon = document.getElementById(eyeSlashIconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.remove('d-none');
        eyeSlashIcon.classList.add('d-none');
    } else {
        input.type = 'password';
        eyeIcon.classList.add('d-none');
        eyeSlashIcon.classList.remove('d-none');
    }
}

$(document).ready(function() {
    const passwordInput = $('#password');
    const confirmPasswordInput = $('#confirm_password');
    const strengthDiv = $('#passwordStrength');
    const form = $('form');

    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^A-Za-z0-9]/)) strength += 1;

        let feedbackText = '';
        let progressBar = '<div class="progress" style="height: 5px;"><div class="progress-bar" role="progressbar"></div></div><small class="form-text mt-1"></small>';
        strengthDiv.html(progressBar);

        const bar = strengthDiv.find('.progress-bar');
        const feedbackElement = strengthDiv.find('.form-text');

        bar.removeClass('bg-danger bg-warning bg-info bg-success');

        switch (strength) {
            case 0:
                feedbackText = '';
                bar.css('width', '0%');
                break;
            case 1:
                feedbackText = 'Lemah';
                bar.css('width', '25%').addClass('bg-danger');
                break;
            case 2:
                feedbackText = 'Sedang';
                bar.css('width', '50%').addClass('bg-warning');
                break;
            case 3:
                feedbackText = 'Kuat';
                bar.css('width', '75%').addClass('bg-info');
                break;
            case 4:
                feedbackText = 'Sangat Kuat';
                bar.css('width', '100%').addClass('bg-success');
                break;
        }
        
        feedbackElement.text(feedbackText);
        return strength >= 3;
    }

    function validatePasswords() {
        const passVal = passwordInput.val();
        const confirmPassVal = confirmPasswordInput.val();
        let isPasswordValid = true;
        let isConfirmPasswordValid = true;

        // Validasi Kekuatan Password
        if (passVal) {
            isPasswordValid = checkPasswordStrength(passVal);
            if (isPasswordValid) {
                passwordInput.removeClass('is-invalid').addClass('is-valid');
                passwordInput.siblings('.invalid-feedback').text('');
            } else {
                passwordInput.removeClass('is-valid').addClass('is-invalid');
                passwordInput.siblings('.invalid-feedback').text('Password harus minimal 8 karakter, mengandung huruf besar, angka, dan simbol.');
            }
        } else {
            passwordInput.removeClass('is-valid is-invalid');
            strengthDiv.empty();
            passwordInput.siblings('.invalid-feedback').text('');
            isPasswordValid = false;
        }

        // Validasi Konfirmasi Password
        if (confirmPassVal) {
            if (passVal !== confirmPassVal) {
                confirmPasswordInput.removeClass('is-valid').addClass('is-invalid');
                confirmPasswordInput.siblings('.invalid-feedback').text('Password tidak cocok.');
                isConfirmPasswordValid = false;
            } else {
                confirmPasswordInput.removeClass('is-invalid').addClass('is-valid');
                confirmPasswordInput.siblings('.invalid-feedback').text('');
            }
        } else {
             confirmPasswordInput.removeClass('is-valid is-invalid');
             isConfirmPasswordValid = false;
        }
        return isPasswordValid && isConfirmPasswordValid;
    }

    passwordInput.on('keyup', validatePasswords);
    confirmPasswordInput.on('keyup', validatePasswords);

    form.on('submit', function(e) {
        $('.alert.alert-danger.manual-alert').remove();
        if (!validatePasswords()) {
            e.preventDefault();
            const alertHtml = `<div class="alert alert-danger alert-dismissible fade show manual-alert" role="alert">
                                 Mohon perbaiki isian form sebelum melanjutkan.
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                               </div>`;
            form.before(alertHtml);
        }
    });
});
</script>
<?= $this->endSection() ?>