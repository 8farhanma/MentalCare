<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= env('app.name') ?> Login</title>
    <link rel="icon" href="<?= base_url('img/logo.png') ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- Tambahkan style untuk tooltip shortcuts -->
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
        }

        /* Style untuk alert */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .alert-dismissible .btn-close {
            padding: 1rem;
        }
        .alert.fade {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gradient-grey">

    <?= $this->renderSection('content') ?>
    <!-- Tambahkan div untuk tooltip shortcuts -->
    <?php if (isset($this->sections['enable_shortcuts']) && $this->sections['enable_shortcuts']): ?>
    <div id="shortcutTooltip" class="shortcut-tooltip">
        Shortcuts: <br>
        Ctrl + L = Login<br>
        Ctrl + R = Register<br>
        Ctrl + F = Forgot Password
    </div>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script -->
    <?php include 'dash/script.php'; ?>

    <?= $this->renderSection('page_scripts') ?>

    <!-- Tambahkan script untuk keyboard shortcuts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($this->sections['enable_shortcuts']) && $this->sections['enable_shortcuts']): ?>
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
        <?php endif; ?>

        // Inisialisasi alert dismissible
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Auto hide alert setelah 5 detik
            setTimeout(function() {
                if (alert && alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }
            }, 5000);
        });
    });
    </script>
</body>

</html>