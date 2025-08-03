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
    <div class="d-flex align-items-center p-4" style="position: absolute; top: 0; left: 0;">
        <img src="<?= base_url('img/logo.png') ?>" width="40px" height="40px" alt="Your Logo">
        <a style="text-transform: none; text-decoration: none; margin-left: 10px; font-size: 24px; font-weight: bold;">
            <span style="color: #D56062">Mental</span><span style="color: #A9A9A9">Care</span>
        </a>
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
                                    <h1 class="h4 text-gray-900 mb-4">MentalCare Admin Panel</h1>
                                </div>
                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                                <?php endif; ?>
                                <?php if (session()->has('remainingTimeAdmin')) : ?>
                                    <div class="alert alert-danger">Silakan tunggu <span id="countdownAdmin"></span> sebelum mencoba login lagi.</div>
                                <?php endif; ?>
                                <form method="post" action="<?= base_url('/login') ?>" id="loginForm" novalidate>
    <?= csrf_field() ?>
    <div class="user">
        <div id="FormUsername">
            <div class="form-group">
                <input type="text" class="form-control form-control-user"
                    placeholder="Username Admin" name="username" id="username" required 
                    autocomplete="username"
                    oninvalid="this.setCustomValidity('Harap isi username')"
                    oninput="this.setCustomValidity('')">
                <div class="invalid-feedback">
                    Harap isi username
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="password" class="form-control form-control-user" name="password"
                        id="password" placeholder="Password" required 
                        autocomplete="current-password"
                        oninvalid="this.setCustomValidity('Harap isi password')"
                        oninput="this.setCustomValidity('')">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                            <i class="fa fa-eye-slash" id="eyeSlashIcon"></i>
                            <i class="fa fa-eye d-none" id="eyeIcon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">
                        Harap isi password
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #D56062; border-color: #D56062;">
                Login
            </button>
        </div>
    </div>
</form>
                                <hr>
                                <div class="text-center">
                                    <span class="small text-muted">Copyright <?= date('Y') ?> <a href="https://www.instagram.com/indihealth/" class="text-muted">Indihealth</a>. All rights reserved.</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
// Form validation
function initFormValidation() {
    var form = document.getElementById('loginForm');
    if (!form) return;
    
    // Validate on submit
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Show validation messages for all invalid fields
            var inputs = form.querySelectorAll('input');
            inputs.forEach(function(input) {
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                }
            });
        }
        form.classList.add('was-validated');
    }, false);
    
    // Real-time validation on input
    var inputs = form.querySelectorAll('input[required]');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        });
    });
}

// Toggle password visibility
function togglePasswordVisibility() {
    const pwdInput = document.getElementById('password');
    const eyeSlash = document.getElementById('eyeSlashIcon');
    const eye = document.getElementById('eyeIcon');
    
    if (!pwdInput) return;
    
    if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeSlash.classList.add('d-none');
        eye.classList.remove('d-none');
    } else {
        pwdInput.type = 'password';
        eyeSlash.classList.remove('d-none');
        eye.classList.add('d-none');
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    initFormValidation();
    
    // Initialize password toggle
    const toggleBtn = document.getElementById('togglePassword');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', togglePasswordVisibility);
    }

        // Countdown lockout admin
        var remainingAdmin = <?php echo json_encode(session()->get('remainingTimeAdmin')) ?? 0; ?>;
        if (remainingAdmin > 0) {
            var display = document.getElementById('countdownAdmin');
            var timer = remainingAdmin;
            var interval = setInterval(function() {
                var minutes = parseInt(timer / 60, 10);
                var seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = minutes + ":" + seconds;
                if (--timer < 0) {
                    clearInterval(interval);
                    window.location.reload();
                }
            }, 1000);
        }
    })();
</script>

<?= $this->endSection() ?>