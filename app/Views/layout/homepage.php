<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= env('app.name') ?> <?= $title ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url('landing/assets/img/logo.png') ?>" rel="icon">
    <link href="<?= base_url('landing/assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('landing/assets/vendors/aos/aos.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?= base_url('landing/assets/vendors/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('landing/assets/css/css.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

    <?php if (!isset($this->sections['disable_shortcuts'])): ?>
    <!-- Shortcut tooltip styles -->
    <style>
        .shortcut-tooltip {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            z-index: 1000;
            display: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
    <?php endif; ?>

</head>

<body class="d-flex flex-column min-vh-100">
    <div id="preloader"></div>

    <!-- Content -->
    <?= $this->renderSection('contentHome') ?>
    <!-- End Content -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Indihealth for Smart Health</h3>
                        <p>
                            Jl. Tubagus Ismail XVI No.7<br>
                            Kota Bandung, Jawa Barat<br>
                            Indonesia <br><br>
                            <strong>Phone:</strong> +6222 251 4440<br>
                            <strong>Email:</strong> info@indihealth.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Media Sosial</h4>
                        <p>Untuk informasi lebih lanjut terkait aplikasi sistem pakar diagnosis tingkat depresi
                            silahkan
                            hubungi sosial media kami.</p>
                        <div class="social-links mt-3">
                            <a href="https://indihealth.com/about-us"><i class="bx bx-globe"></i></a>
                            <a href="https://www.instagram.com/indihealth/" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="https://twitter.com/Indihealth_" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="https://wa.me/628814548544" class="whatsapp"><i class="bx bxl-whatsapp"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Homepage -->
        <?php include 'homepage/footer_homepage.php'; ?>
        <!-- End Footer Page -->

    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center" style="bottom: 80px !important;"><i class="bi bi-arrow-up-short"></i></a>

    <?php if (!isset($this->sections['disable_shortcuts'])): ?>
    <!-- Shortcut tooltip -->
    <div id="shortcutTooltip" class="shortcut-tooltip">
        Shortcuts: <br>
        Ctrl + L = Login<br>
        Ctrl + R = Register<br>
        Ctrl + F = Forgot Password
    </div>
    <?php endif; ?>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('landing/assets/vendors/aos/aos.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/glightbox/js/glightbox.min.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/isotope-layout/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/php-email-form/validate1.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/swiper/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('landing/assets/vendors/waypoints/noframework.waypoints.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('landing/assets/js/main.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <?php if (!isset($this->sections['disable_shortcuts'])): ?>
    <!-- Keyboard shortcuts script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let tooltipTimeout;
        const tooltip = document.getElementById('shortcutTooltip');

        // Fungsi untuk menampilkan tooltip
        function showTooltip() {
            if (tooltip) {
                tooltip.style.display = 'block';
                clearTimeout(tooltipTimeout);
                tooltipTimeout = setTimeout(() => {
                    tooltip.style.display = 'none';
                }, 2000); // Tooltip akan hilang setelah 2 detik
            }
        }

        // Event listener untuk keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Hanya aktifkan jika Ctrl ditekan
            if (e.ctrlKey) {
                switch(e.key.toLowerCase()) {
                    case 'l': // Ctrl + L untuk Login
                        e.preventDefault();
                        showTooltip();
                        window.location.href = '<?= base_url('login-user') ?>';
                        break;
                    case 'r': // Ctrl + R untuk Register
                        e.preventDefault();
                        showTooltip();
                        window.location.href = '<?= base_url('register') ?>';
                        break;
                    case 'f': // Ctrl + F untuk Forgot Password
                        e.preventDefault();
                        showTooltip();
                        window.location.href = '<?= base_url('forgot-password') ?>';
                        break;
                }
            }
        });

        // Tampilkan tooltip saat mouse hover di pojok kanan bawah
        const corner = document.createElement('div');
        corner.style.position = 'fixed';
        corner.style.bottom = '0';
        corner.style.right = '0';
        corner.style.width = '50px';
        corner.style.height = '50px';
        corner.style.cursor = 'help';
        document.body.appendChild(corner);

        corner.addEventListener('mouseenter', () => {
            if (tooltip) tooltip.style.display = 'block';
        });

        corner.addEventListener('mouseleave', () => {
            if (tooltip) tooltip.style.display = 'none';
        });
    });
    </script>
    <?php endif; ?>
</body>

</html>