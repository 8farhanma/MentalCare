<!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then load Bootstrap and other jQuery plugins -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- Load DataTables and its extensions -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<!-- Custom scripts -->
<script>
    jQuery(document).ready(function($) {
        // Load admin template script after jQuery is ready
        $.getScript('<?= base_url('js/sb-admin-2.min.js') ?>');

        // Initialize DataTables for both tables if they exist
        if ($.fn.dataTable) {
            // Initialize Gejala table
            if ($('#gejalaTable').length > 0) {
                var gejalaTable = $('#gejalaTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    pageLength: 5,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                    columnDefs: [
                        { orderable: false, targets: [-1] }
                    ]
                });
            }

            // Initialize Penyakit table
            if ($('#penyakitTable').length > 0) {
                var penyakitTable = $('#penyakitTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    pageLength: 5,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                    columnDefs: [
                        { orderable: false, targets: [-1] }
                    ]
                });
            }
        }

        // Initialize password toggle if password field exists
        initializePasswordToggle();
    });

    // Password toggle functionality
    function initializePasswordToggle() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePassword && passwordInput && eyeSlashIcon && eyeIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeSlashIcon.classList.toggle('d-none');
                eyeIcon.classList.toggle('d-none');
            });
        }
    }
</script>