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
                                    <h1 class="h4 text-gray-900 mb-4">Lupa Password</h1>
                                </div>
                                <?php include(APPPATH . 'Views/components/alerts.php'); ?>
                                <form method="POST" action="<?= base_url('forgot-password') ?>" novalidate>
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                            name="email" placeholder="Masukkan Email" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #D56062; border-color: #D56062;">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('register') ?>">Buat akun baru!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('login-user') ?>">Sudah ingat password? Login!</a>
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
    $(document).ready(function() {
        const emailInput = $('#exampleInputEmail');
        const form = $('form');

        function validateEmail() {
            const email = emailInput.val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                emailInput.removeClass('is-valid is-invalid');
                emailInput.next('.invalid-feedback').text('');
                return false;
            }

            if (emailRegex.test(email)) {
                emailInput.removeClass('is-invalid').addClass('is-valid');
                emailInput.next('.invalid-feedback').text('');
                return true;
            } else {
                emailInput.removeClass('is-valid').addClass('is-invalid');
                emailInput.next('.invalid-feedback').text('Format email tidak valid. Contoh: nama@domain.com');
                return false;
            }
        }

        emailInput.on('keyup blur', validateEmail);

        form.on('submit', function(e) {
            // Hapus alert lama
            $('.alert.alert-danger.manual-alert').remove();

            if (!validateEmail()) {
                e.preventDefault();
                const alertHtml = `<div class="alert alert-danger alert-dismissible fade show manual-alert" role="alert">
                                     Mohon perbaiki format email sebelum melanjutkan.
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                   </div>`;
                form.before(alertHtml);
                emailInput.focus();
            }
        });
    });
</script>
<?= $this->endSection() ?>
