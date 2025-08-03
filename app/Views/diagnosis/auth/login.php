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
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="row">
                <div class="col-lg-6 p-5">
                    <div class="text-left mb-5" style="margin: 80px 0;">
                        <h1 class="display-4 fw-bold mb-3" style="color: white; font-family: 'Jost', sans-serif;">Halo,<br>selamat datang!</h1>
                        <p style="color: white; font-family: 'Open Sans', sans-serif;">Deteksi Hari Ini, Selamatkan Masa Depanmu.</p>
                    </div>
                    <div class="mt-5" style="margin: 80px 0;">
                        <div class="d-flex gap-3">
                            <a href="https://indihealth.com/about-us" class="text-white p-2"><i class="fas fa-globe"></i></a>
                            <a href="https://www.instagram.com/indihealth/" class="text-white p-2"><i class="fab fa-instagram"></i></a>
                            <a href="https://twitter.com/Indihealth_" class="text-white p-2"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/628814548544" class="text-white p-2"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-5">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" style="font-family: 'Open Sans', sans-serif;"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" style="font-family: 'Open Sans', sans-serif;"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <div id="countdown-alert" class="alert alert-danger" style="font-family: 'Open Sans', sans-serif; display: none;">Anda harus menunggu <span id="countdown"></span> sebelum mencoba login lagi.</div>
                    <form method="post" action="<?= base_url('login-user') ?>" class="mb-4" id="login-form" novalidate>
                        <?= csrf_field() ?>
                        <div class="form-group mb-4">
                            <label style="color: white; font-family: 'Open Sans', sans-serif;">Email address</label>
                            <input type="email" name="email" class="form-control form-control-lg" style="background: rgba(255, 255, 255, 0.2); border-color: rgba(255,255,255,0.3); color: white; font-family: 'Open Sans', sans-serif;" placeholder="name@email.com" required autocomplete="username">
                        </div>
                        <div class="form-group mb-4">
                            <label style="color: white; font-family: 'Open Sans', sans-serif;">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control form-control-lg" style="background: rgba(255, 255, 255, 0.2); border-color: rgba(255,255,255,0.3); color: white; font-family: 'Open Sans', sans-serif;" placeholder="Password" required autocomplete="current-password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                        <i class="fa fa-eye-slash" id="eyeSlashIcon"></i>
                                        <i class="fa fa-eye d-none" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4 text-end">
                                <a href="<?= base_url('forgot-password') ?>" class="text-white text-decoration-none hover-effect" style="font-family: 'Open Sans', sans-serif;">Lupa password?</a>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg login-btn" style="background-color: #D56062; color: white; font-family: 'Open Sans', sans-serif;">Masuk</button>
                            <a href="<?= base_url('register') ?>" class="btn btn-lg text-white signup-btn" style="background-color: #0d6efd; border-color: #0d6efd; font-family: 'Open Sans', sans-serif;">Buat Akun</a>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="text-white" style="font-family: 'Open Sans', sans-serif;">Atau lanjutkan dengan</p>
                        <a href="<?= base_url('login-google') ?>" class="btn btn-light btn-lg w-100 google-btn" style="font-family: 'Open Sans', sans-serif;">
                            <i class="fab fa-google me-2"></i> Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap');

    body {
        font-family: 'Open Sans', sans-serif;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Jost', sans-serif;
    }

    /* Hover effect untuk link Lupa Password */
    .hover-effect {
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        color: #0d6efd !important;
        text-decoration: underline !important;
    }
    
    /* Hover effect untuk tombol Login */
    .login-btn {
        transition: all 0.3s ease;
    }
    .login-btn:hover {
        background-color: #c14e50 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(213, 96, 98, 0.3);
    }
    
    /* Hover effect untuk tombol Sign up */
    .signup-btn {
        transition: all 0.3s ease;
    }
    .signup-btn:hover {
        background-color: #0b5ed7 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }
    
    /* Hover effect untuk tombol Google */
    .google-btn {
        transition: all 0.3s ease;
    }
    .google-btn:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    function startCountdown(duration, display) {
        var timer = duration,
            minutes, seconds;
        setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                window.location.reload();
            }
        }, 1000);
    }

    document.addEventListener("DOMContentLoaded", function() {
        var remainingTime = <?php echo json_encode(session()->get('remainingTime')) ?? 0; ?>;
        var countdownDisplay = document.getElementById("countdown");
        var countdownAlert = document.getElementById("countdown-alert");

        if (remainingTime > 0) {
            countdownAlert.style.display = 'block';
            startCountdown(remainingTime, countdownDisplay);
        }

        // Toggle password visibility
        const togglePasswordBtn = document.getElementById("togglePassword");
        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener("click", function () {
                const passwordInput = this.closest('.input-group').querySelector('input[name="password"]');
                const eyeSlashIcon = document.getElementById("eyeSlashIcon");
                const eyeIcon = document.getElementById("eyeIcon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeSlashIcon.classList.add("d-none");
                    eyeIcon.classList.remove("d-none");
                } else {
                    passwordInput.type = "password";
                    eyeSlashIcon.classList.remove("d-none");
                    eyeIcon.classList.add("d-none");
                }
            });
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var validator = $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Alamat email tidak boleh kosong.",
                    email: "Masukkan alamat email yang valid."
                },
                password: {
                    required: "Password tidak boleh kosong."
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('input[name="email"]').on('keyup', function() {
            validator.element($(this));
        });
    });
</script>

<?= $this->endSection() ?>