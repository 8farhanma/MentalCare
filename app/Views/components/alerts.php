<!-- Alerts Unutuk menampilkan pemberitahuan sukses/gagal -->
<?php 
/**
 * Komponen Alert untuk MentalCare
 * 
 * File ini berisi fungsi-fungsi untuk menampilkan alert/notifikasi
 * dengan format yang konsisten di seluruh aplikasi.
 */

/**
 * Menampilkan alert berdasarkan session flashdata
 * 
 * @return void
 */
if (!function_exists('showAlerts')) {
function showAlerts()
{
    $session = session();
    $types = ['success', 'info', 'warning', 'error', 'errorr', 'logSuccess', 'errorVal'];
    
    foreach ($types as $type) {
        $message = $session->getFlashdata($type);
        if ($message) {
            // Konversi 'error' dan 'errorr' menjadi 'danger' untuk Bootstrap
            $alertType = ($type === 'error' || $type === 'errorr') ? 'danger' : $type;
            
            // Custom icon & style
            $icon = '';
            switch ($alertType) {
                case 'success':
                case 'logSuccess':
                    $icon = '<i class="bi bi-check-circle-fill alert-icon"></i>';
                    break;
                case 'info':
                    $icon = '<i class="bi bi-info-circle-fill alert-icon"></i>';
                    break;
                case 'warning':
                    $icon = '<i class="bi bi-exclamation-triangle-fill alert-icon"></i>';
                    break;
                case 'danger':
                    $icon = '<i class="bi bi-x-circle-fill alert-icon"></i>';
                    break;
                default:
                    $icon = '';
            }
            $alertId = 'alert-' . uniqid();
            if ($type === 'errorVal') {
                echo '<div id="'.$alertId.'" class="alert alert-' . $alertType . ' alert-fade custom-alert-ui" role="alert">' . $icon;
            } else {
                echo '<div id="'.$alertId.'" class="alert alert-' . $alertType . ' alert-dismissible fade show custom-alert-ui" role="alert">' . $icon;
            }
            
            // Jika pesan berbentuk array (dari validasi), tampilkan sebagai list
            if (is_array($message)) {
                echo '<ul class="mb-0 ps-3">';
                foreach ($message as $error) {
                    echo '<li>' . esc($error) . '</li>';
                }
                echo '</ul>';
            } else {
                // Pastikan hanya pesan yang bersih yang tampil, tanpa karakter tambahan
                echo esc($message);
            }
            
            if ($type !== 'errorVal') {
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            }
            echo '</div>';
            // Auto-dismiss seragam untuk semua alert
            ?>
            <script>
            setTimeout(function() {
                var alertBox = document.getElementById('<?= $alertId ?>');
                if(alertBox) {
                    alertBox.classList.add('fade-out');
                    setTimeout(function(){
                        if(alertBox) {
                            alertBox.style.display = 'none';
                        }
                    }, 550); // Waktu untuk animasi fade-out
                }
            }, 5000); // Waktu tunda 5 detik untuk semua alert
            </script>
            <?php
        }
    }
}

/**
 * Menampilkan alert manual (tidak dari session)
 * 
 * @param string $message Pesan yang akan ditampilkan
 * @param string $type Tipe alert (success, info, warning, danger)
 * @param bool $dismissible Apakah alert bisa ditutup
 * @return void
 */
function showAlert($message, $type = 'info', $dismissible = true)
{
    $dismissClass = $dismissible ? 'alert-dismissible fade show' : '';
    
    echo '<div class="alert alert-' . $type . ' ' . $dismissClass . '" role="alert">';
    echo esc($message);
    
    if ($dismissible) {
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    }
    
    echo '</div>';
}

}

showAlerts();
?>

<style>
/* Custom Alert UI - Modern, Kontras, dan Auto-dismiss */
.custom-alert-ui {
    border-width: 2px;
    border-radius: 0.9rem;
    box-shadow: 0 6px 24px rgba(0,0,0,0.13), 0 1.5px 6px rgba(0,0,0,0.09);
    padding: 1rem 2.2rem 1rem 2.9rem !important;
    font-size: 1.09rem;
    position: relative;
    animation: alert-slide-in 0.6s cubic-bezier(.77,0,.18,1);
    margin-bottom: 1.2rem;
    margin-top: 1.6rem;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    align-items: center;
    min-height: 50px;
    border-style: solid;
    background: #fff;
}
.alert-success.custom-alert-ui, .alert-logSuccess.custom-alert-ui {
    border-color: #198754;
    background: #e6f9f0;
    color: #198754;
}
.alert-info.custom-alert-ui {
    border-color: #0dcaf0;
    background: #eaf6fb;
    color: #0a6fa2;
}
.alert-warning.custom-alert-ui {
    border-color: #ffc107;
    background: #fffbe6;
    color: #b88600;
}
.alert-danger.custom-alert-ui {
    border-color: #dc3545;
    background: #fff0f0;
    color: #b02a37;
}
.alert-icon {
    position: absolute;
    top: 50%;
    left: 1.1rem;
    transform: translateY(-50%);
    font-size: 1.5rem;
    opacity: 0.97;
    color: inherit;
    pointer-events: none;
}
@keyframes alert-slide-in {
    0% { opacity: 0; transform: translateY(-20px) scale(0.96); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
.alert-fade {
    transition: opacity 0.5s ease-out;
}
.fade-out {
    opacity: 0;
    transition: opacity 0.5s ease-out;
}
@media (max-width: 700px) {
    .custom-alert-ui { max-width: 97vw; padding-left: 2.1rem !important; font-size: 0.97rem; }
    .alert-icon { left: 0.5rem; font-size: 1.1rem; }
}
</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>