<?= $this->extend('layout/app'); ?>

<?= $this->section('content'); ?>
<?= $this->include('components/alerts'); ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                <font color="#0A2342">Keranjang Sampah</font>
            </h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="recycleBinTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="aturan-tab" data-toggle="tab" href="#aturan" role="tab" aria-controls="aturan" aria-selected="true">Aturan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="gejala-tab" data-toggle="tab" href="#gejala" role="tab" aria-controls="gejala" aria-selected="false">Gejala</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="penyakit-tab" data-toggle="tab" href="#penyakit" role="tab" aria-controls="penyakit" aria-selected="false">Penyakit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="faq-tab" data-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-selected="false">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="laporan-tab" data-toggle="tab" href="#laporan" role="tab" aria-controls="laporan" aria-selected="false">Laporan Diagnosis</a>
                </li>
            </ul>
            <div class="tab-content" id="recycleBinTabContent">
                <div class="tab-pane fade show active pt-3" id="aturan" role="tabpanel" aria-labelledby="aturan-tab">
                    <?= $this->include('admin/recycle_bin/_aturan_table') ?>
                </div>
                <div class="tab-pane fade pt-3" id="gejala" role="tabpanel" aria-labelledby="gejala-tab">
                    <?= $this->include('admin/recycle_bin/_gejala_table') ?>
                </div>
                <div class="tab-pane fade pt-3" id="penyakit" role="tabpanel" aria-labelledby="penyakit-tab">
                    <?= $this->include('admin/recycle_bin/_penyakit_table') ?>
                </div>
                <div class="tab-pane fade pt-3" id="users" role="tabpanel" aria-labelledby="users-tab">
                    <?= $this->include('admin/recycle_bin/_users_table') ?>
                </div>
                <div class="tab-pane fade pt-3" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    <?= $this->include('admin/recycle_bin/_faq_table') ?>
                </div>
                <div class="tab-pane fade pt-3" id="laporan" role="tabpanel" aria-labelledby="laporan-tab">
                    <?= $this->include('admin/recycle_bin/_laporan_table') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pemulihan Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memulihkan data ini?</p>
                <p class="text-info small">
                    <i class="fas fa-info-circle mr-1"></i>
                    Data akan dipulihkan ke daftar aktif.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="restoreForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-undo mr-1"></i> Pulihkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Permanent Confirmation Modal -->
<div class="modal fade" id="deletePermanentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Permanen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus permanen data ini?</p>
                <div class="alert alert-danger">
                    <p class="mb-0">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>PERHATIAN:</strong> Data akan dihapus secara permanen dan tidak dapat dipulihkan.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deletePermanentForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Restore All Confirmation Modal -->
<div class="modal fade" id="restoreAllModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pulihkan Semua</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memulihkan <strong>semua</strong> data dalam kategori ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="restoreAllForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success"><i class="fas fa-undo mr-1"></i> Ya, Pulihkan Semua</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete All Permanent Confirmation Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Permanen Semua</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus permanen <strong>semua</strong> data dalam kategori ini?</p>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-2"></i><strong>PERHATIAN:</strong> Aksi ini tidak dapat diurungkan.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteAllForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> Ya, Hapus Semua</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const dataTableOptions = {
        responsive: true,
        autoWidth: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            emptyTable: "Tidak ada data yang tersedia di dalam tabel"
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting on last column (Aksi)
        ],
    };

    // Initialize the first visible table on page load
    $('#aturan .datatable-recycle').DataTable(dataTableOptions);

    // Handle tab changes
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        const targetPane = $(e.target).attr('href');
        const table = $(targetPane).find('.datatable-recycle');

        if ($.fn.DataTable.isDataTable(table)) {
            // If table is already a DataTable, just redraw and adjust columns
            table.DataTable().columns.adjust().responsive.recalc();
        } else {
            // Otherwise, initialize it
            table.DataTable(dataTableOptions);
        }
    });

    // Restore button click handler
    $(document).on('click', '.restore-btn', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const url = `<?= base_url('admin/recycle_bin/restore/') ?>${type}/${id}`;
        $('#restoreForm').attr('action', url);
        $('#restoreModal').modal('show');
    });

    // Delete permanent button click handler
    $(document).on('click', '.delete-permanent-btn', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const url = `<?= base_url('admin/recycle_bin/force_delete/') ?>${type}/${id}`;
        $('#deletePermanentForm').attr('action', url);
        $('#deletePermanentModal').modal('show');
    });

    // Restore All button click handler
    $(document).on('click', '.restore-all-btn', function() {
        const type = $(this).data('type');
        const url = `<?= base_url('admin/recycle_bin/restore_all/') ?>${type}`;
        $('#restoreAllForm').attr('action', url);
        $('#restoreAllModal').modal('show');
    });

    // Delete All Permanent button click handler
    $(document).on('click', '.delete-all-btn', function() {
        const type = $(this).data('type');
        const url = `<?= base_url('admin/recycle_bin/force_delete_all/') ?>${type}`;
        $('#deleteAllForm').attr('action', url);
        $('#deleteAllModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>
