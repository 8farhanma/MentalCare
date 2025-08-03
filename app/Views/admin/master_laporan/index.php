<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- Data Laporan Diagnosis -->
<div class="card shadow mb-4">
<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data Laporan Diagnosis</font>
        </h5>
        <div class="btn-group float-right">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" 
                aria-expanded="false"><i class="fas fa-cog"></i>&nbsp; Aksi
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?= base_url('admin/master_laporan/cetakPdf') ?>">
                    <i class="fas fa-download" style="color: #3643b5;"></i>&nbsp; Unduh PDF
                </a>
                <a class="dropdown-item" href="<?= base_url('admin/master_laporan/cetakExcel') ?>">
                    <i class="fas fa-download" style="color: #3643b5;"></i>&nbsp; Unduh Excel
                </a>
                <a class="dropdown-item" href="<?= base_url('admin/master_laporan/cetakLangsung') ?>">
                    <i class="fas fa-print" style="color: #3643b5;"></i>&nbsp; Cetak Langsung
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteAllModal">
                    <i class="fas fa-trash" style="color: #dc3545;"></i>&nbsp; Hapus Semua Data
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Usia</th>
                        <th>Tanggal</th>
                        <th>Penyakit</th>
                        <th>CF Akhir</th>
                        <th>Persentase</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($laporan as $item) : ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td class="font-weight-bold"><?= htmlspecialchars($item['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($item['p_1'] ?? '-') ?></td>
                            <td data-order="<?= !empty($item['tanggal_diagnosis']) ? date('Ymd', strtotime($item['tanggal_diagnosis'])) : '0' ?>">
                                <?= !empty($item['tanggal_diagnosis']) ? date('d-m-Y', strtotime($item['tanggal_diagnosis'])) : '-' ?>
                            </td>
                            <td><?= htmlspecialchars($item['hasil_diagnosis'] ?? '-') ?></td>
                            <td><?= isset($item['cf_akhir']) ? number_format($item['cf_akhir'], 2) : '0.00' ?></td>
                            <td><?= isset($item['presentase']) ? number_format($item['presentase'], 2) . '%' : '0%' ?></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/master_laporan/lihat/' . $item['id_diagnosis']) ?>" 
                                       class="btn btn-circle btn-sm btn-info"
                                       data-toggle="tooltip"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-circle btn-sm btn-danger delete-btn"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-id="<?= $item['id_diagnosis'] ?>"
                                            data-name="<?= htmlspecialchars($item['nama_lengkap']) ?>"
                                            data-date="<?= isset($item['created_at']) ? date('d/m/Y H:i', strtotime($item['created_at'])) : date('d/m/Y H:i') ?>"
                                            data-url="<?= base_url('admin/master_laporan/delete/' . $item['id_diagnosis']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pemindahan ke Recycle Bin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memindahkan laporan diagnosis ini ke Recycle Bin?</p>
                <div class="alert alert-light">
                    <p class="font-weight-bold mb-1" id="reportName"></p>
                    <p class="text-muted small mb-0" id="reportDate"></p>
                </div>
                <p class="text-info small">
                    <i class="fas fa-info-circle mr-1"></i>
                    Data akan tetap tersimpan dan dapat dikembalikan kapan saja melalui Recycle Bin.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Pindahkan ke Recycle Bin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete All Confirmation Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pemindahan Semua Data ke Recycle Bin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memindahkan semua data laporan diagnosis ke Recycle Bin?</p>
                <div class="alert alert-info">
                    <p class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>PERHATIAN:</strong> Tindakan ini akan memindahkan SEMUA data laporan ke Recycle Bin.
                    </p>
                </div>
                <p class="small text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    Total data yang akan dipindahkan: <strong><?= count($laporan) ?></strong> laporan.
                </p>
                <p class="small text-muted">
                    <i class="fas fa-recycle mr-1"></i>
                    Data dapat dikembalikan kapan saja melalui Recycle Bin.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= base_url('admin/master_laporan/softDeleteAll') ?>" method="post" class="d-inline"><!-- <script src="<?= base_url('js/demo/datatables-demo.js') ?>"></script> -->
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-recycle mr-1"></i> Pindahkan ke Recycle Bin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    if ($.fn.DataTable) {
        $('#dataTable').DataTable({
            responsive: true,
            columns: [
                { width: '5%' },          // No
                null,                     // Nama
                { width: '10%' },         // Pekerjaan
                { width: '15%', type: 'date-eu' }, // Tanggal
                { width: '15%' },         // Penyakit
                { width: '10%' },         // CF Akhir
                { width: '10%' },         // Presentase
                { width: '10%', orderable: false } // Aksi
            ],
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
            order: [[3, 'desc']], // Default sort by date (column index 3)
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting on action column (index 7)
            ]
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize delete modal
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const date = $(this).data('date');
        const url = $(this).data('url');
        
        $('#reportName').text(name);
        $('#reportDate').text('Tanggal: ' + date);
        $('#deleteForm').attr('action', url);
    });

    // Add date sorting plugin for DataTables (dd/mm/yyyy format)
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-eu-pre": function (date) {
            if (!date) return -Infinity;
            
            date = date.trim();
            
            // Handle date format: dd/mm/yyyy HH:MM
            let parts = date.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
            
            if (parts) {
                return Date.UTC(parts[3], parts[2] - 1, parts[1], parts[4], parts[5]);
            }
            
            return -Infinity;
        },
        "date-eu-asc": function (a, b) {
            return a - b;
        },
        "date-eu-desc": function (a, b) {
            return b - a;
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>