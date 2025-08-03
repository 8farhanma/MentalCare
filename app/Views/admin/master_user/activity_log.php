<?= $this->extend('layout/app'); ?>
<?php helper('date'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= esc($title); ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Lengkap:</strong> <?= esc($user['nama_lengkap']); ?></p>
                    <p><strong>Email:</strong> <?= esc($user['email']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Role:</strong> <?= $user['role'] == 2 ? 'User' : 'Admin'; ?></p>
                    <p><strong>Akun Dibuat:</strong> <?= format_indo($user['created_at']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Log Aktivitas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Deskripsi Aktivitas</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($activities)) : ?>
                            <?php foreach ($activities as $activity) : ?>
                                <tr>
                                    <td></td> <!-- Dikosongkan untuk penomoran dinamis oleh DataTables -->
                                    <td><?= esc($activity['activity_description']); ?></td>
                                    <td data-order="<?= esc($activity['created_at']); ?>"><?= format_indo($activity['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="<?= site_url('admin/master_user'); ?>" class="btn btn-secondary">Kembali</a>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable if the table exists
    if ($.fn.DataTable) {
        var table = $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
            order: [[ 2, 'desc' ]], // Sort by 'Waktu' column descending
            columnDefs: [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }]
        });

        // Listener untuk penomoran ulang saat sorting atau searching
        table.on('order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
});
</script>
<?= $this->endSection() ?>

