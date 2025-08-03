<?= $this->extend('layout/auth') ?>
<?= $this->section('enable_shortcuts') ?>
true
<?= $this->endSection() ?>
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
                                    <p>
                                        <?php if (!isset($showOtpForm)) : ?>
                                            <h1 class="h4 text-gray-900 mb-4">Silahkan Registrasi Akun Baru</h1></p>
                                        <?php else : ?>
                                            <h1 class="h4 text-gray-900 mb-4">Verifikasi OTP</h1>
                                        <?php endif; ?>
                                </div>
                                <?php include(APPPATH . 'Views/components/alerts.php'); ?>
                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger">
                                        <h6 class="font-weight-bold mb-2">Mohon perbaiki kesalahan berikut:</h6>
                                        <ul class="mb-0 pl-3">
                                        <?php
                                        $errors = session()->getFlashdata('error');
                                        foreach ($errors as $field => $error) {
                                            echo '<li>' . $error;
                                            // Tambahkan petunjuk spesifik berdasarkan jenis error
                                            if (strpos($error, 'Email') !== false) {
                                                echo ' <small class="text-muted d-block">Contoh format email yang benar: nama@domain.com</small>';
                                            } elseif (strpos($error, 'Password') !== false && strpos($error, 'minimal') !== false) {
                                                echo ' <small class="text-muted d-block">Password harus memiliki minimal 8 karakter dengan huruf kapital, angka, dan karakter khusus</small>';
                                            } elseif (strpos($error, 'tidak cocok') !== false) {
                                                echo ' <small class="text-muted d-block">Pastikan Anda mengetikkan password yang sama pada kedua field</small>';
                                            }
                                            echo '</li>';
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('errorr')) : ?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('errorr') ?></div>
                                <?php endif; ?>
                                <?php if (!isset($showOtpForm)) : ?>
                                    <form method="POST" action="<?= base_url('register') ?>">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="inputNamaLengkap"
                                                name="nama_lengkap" maxlength="50" placeholder="Nama Lengkap" autocomplete="name">
                                            <small class="form-text text-muted">Masukkan nama lengkap Anda sesuai identitas</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="inputEmail" name="email" placeholder="Email Aktif"
                                                data-toggle="tooltip" title="Anda Akan Menerima Verifikasi Kode" autocomplete="username">
                                            <small class="form-text text-muted">Pastikan email aktif untuk menerima kode OTP</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password"
                                                    id="password" placeholder="Password" required autocomplete="new-password">
                                                <button class="btn btn-outline-primary" type="button" onclick="togglePassword('password', 'eyeIcon', 'eyeSlashIcon')">
                                                    <i class="fas fa-eye-slash" id="eyeSlashIcon"></i>
                                                    <i class="fas fa-eye d-none" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">Password minimal 8 karakter dengan huruf kapital, angka, dan karakter khusus</small>
                                            <div id="passwordStrength" class="mt-1 mb-0"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="confirm_password"
                                                    id="confirm_password" placeholder="Konfirmasi Password" required autocomplete="new-password">
                                                <button class="btn btn-outline-primary" type="button" onclick="togglePassword('confirm_password', 'confirmEyeIcon', 'confirmEyeSlashIcon')">
                                                    <i class="fas fa-eye-slash" id="confirmEyeSlashIcon"></i>
                                                    <i class="fas fa-eye d-none" id="confirmEyeIcon"></i>
                                                </button>
                                            </div>
                                            <small id="passwordMatch" class="form-text"></small>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block login-btn" style="background-color: #D56062; border-color: #D56062;" id="registerBtn">
                                            Buat Akun
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small hover-effect" href="<?= base_url('forgot-password') ?>">Lupa Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small hover-effect" href="<?= base_url('login-user') ?>">Sudah punya akun? Silahkan login!</a>
                                    </div>
                                <?php else : ?>
                                    <!-- Form verifikasi OTP -->
                                    <form method="POST" action="<?= base_url('verify-otp') ?>">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputOTP"
                                                name="otp" placeholder="Masukkan Kode OTP">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #D56062; border-color: #D56062;">
                                            Verifikasi OTP
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tautan ke jQuery dan Bootstrap JS (pastikan Anda telah memuatnya di bagian <head> atau sebelum penutup </body>) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .tooltip-inner {
        background-color: white;
        color: black;
        border: 1px solid #ccc;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    
    /* Hover effect untuk link */
    .hover-effect {
        transition: all 0.3s ease;
        color: #6c757d;
    }
    .hover-effect:hover {
        color: #0d6efd !important;
        text-decoration: underline !important;
    }
    
    /* Hover effect untuk tombol Register */
    .login-btn {
        transition: all 0.3s ease;
    }
    .login-btn:hover {
        background-color: #c14e50 !important;
        border-color: #c14e50 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(213, 96, 98, 0.3);
    }
</style>

<!-- Inisialisasi komponen tooltip -->
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Validasi real-time untuk Nama Lengkap
        $('#inputNamaLengkap').on('keyup blur', function(event) {
            const namaLengkap = $(this).val();
            const namaRegex = /^[a-zA-Z\s'-]+$/; // Hanya huruf, spasi, apostrof, dan tanda hubung

            // Hapus feedback sebelumnya jika ada
            $(this).next('.invalid-feedback, .valid-feedback').remove();

            if (namaLengkap.trim() === '') {
                $(this).removeClass('is-valid is-invalid');
                // Hanya tampilkan error jika pengguna meninggalkan field (blur)
                if (event.type === 'blur') {
                    $(this).addClass('is-invalid');
                    $(this).after('<div class="invalid-feedback d-block">Nama lengkap tidak boleh kosong.</div>');
                }
                return;
            }

            if (!namaRegex.test(namaLengkap)) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $(this).after('<div class="invalid-feedback d-block">Nama lengkap hanya boleh berisi huruf dan spasi.</div>');
            } else if (namaLengkap.trim().length < 3) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $(this).after('<div class="invalid-feedback d-block">Nama lengkap minimal 3 karakter.</div>');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $(this).after('<div class="valid-feedback d-block">Nama lengkap valid.</div>');
            }
        });
        
        // Validasi format email saat pengguna mengetik
        $('#inputEmail').on('keyup blur', function() {
            const email = $(this).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email === '') {
                $(this).removeClass('is-invalid is-valid');
                $(this).next('.invalid-feedback, .valid-feedback').remove();
                return;
            }
            
            if (!emailRegex.test(email)) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                // Hapus feedback sebelumnya jika ada
                $(this).next('.invalid-feedback, .valid-feedback').remove();
                // Tambahkan pesan error baru
                $(this).after('<div class="invalid-feedback d-block">Format email tidak valid. Contoh: nama@domain.com</div>');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
                // Hapus feedback sebelumnya jika ada
                $(this).next('.invalid-feedback, .valid-feedback').remove();
                // Tambahkan pesan sukses
                $(this).after('<div class="valid-feedback d-block">Format email valid</div>');
            }
        });
        
        // Validasi kekuatan password saat pengetikan
        $('#password').on('keyup', function() {
            const password = $(this).val();
            const passwordStrengthElement = $('#passwordStrength');
            
            // Reset
            passwordStrengthElement.html('');
            
            if (password.length === 0) {
                return;
            }
            
            // Kriteria kekuatan password
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            const isLongEnough = password.length >= 8;
            
            let strength = 0;
            let feedback = '';
            
            if (hasUpperCase) strength++;
            if (hasLowerCase) strength++;
            if (hasNumbers) strength++;
            if (hasSpecialChars) strength++;
            if (isLongEnough) strength++;
            
            // Tampilkan progress bar kekuatan password
            let progressClass = 'bg-danger';
            let strengthText = 'Sangat Lemah';
            
            if (strength === 5) {
                progressClass = 'bg-success';
                strengthText = 'Sangat Kuat';
            } else if (strength === 4) {
                progressClass = 'bg-info';
                strengthText = 'Kuat';
            } else if (strength === 3) {
                progressClass = 'bg-warning';
                strengthText = 'Sedang';
            } else if (strength === 2) {
                progressClass = 'bg-danger';
                strengthText = 'Lemah';
            }
            
            // Tampilkan feedback
            feedback += '<div class="progress" style="height: 5px;"><div class="progress-bar ' + progressClass + '" style="width: ' + (strength * 20) + '%"></div></div>';
            feedback += '<small class="mt-1 d-block">' + strengthText + '</small>';
            
            // Tampilkan petunjuk jika password belum memenuhi kriteria
            if (strength < 3) {
                feedback += '<small class="text-danger">Tambahkan: ';
                if (!hasUpperCase) feedback += 'huruf kapital, ';
                if (!hasLowerCase) feedback += 'huruf kecil, ';
                if (!hasNumbers) feedback += 'angka, ';
                if (!hasSpecialChars) feedback += 'karakter khusus, ';
                if (!isLongEnough) feedback += 'minimal 8 karakter, ';
                feedback = feedback.slice(0, -2) + '</small>';
            }
            
            passwordStrengthElement.html(feedback);
            
            // Jika password terlalu lemah, tambahkan class is-invalid
            if (strength < 3) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });
        
        // Check password match
        $('#confirm_password, #password').on('keyup', function() {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            const passwordMatchElement = $('#passwordMatch');
            const registerBtn = $('#registerBtn');
            
            if (password === '' || confirmPassword === '') {
                passwordMatchElement.html('');
                return;
            }
            
            if (password === confirmPassword) {
                passwordMatchElement.html('<i class="fas fa-check-circle mr-1"></i> Password cocok').css('color', 'green');
                registerBtn.prop('disabled', false);
            } else {
                passwordMatchElement.html('<i class="fas fa-times-circle mr-1"></i> Password tidak cocok. Pastikan Anda mengetikkan password yang sama.').css('color', 'red');
                registerBtn.prop('disabled', true);
            }
        });
    });
    
    // Fungsi toggle password yang lebih sederhana
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
</script>

<?= $this->endSection() ?>
