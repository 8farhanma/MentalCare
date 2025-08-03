<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data Aturan</font>
        </h5>
        <div class="btn-group">
            <a href="<?= base_url('admin/master_aturan/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Aturan
            </a>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="8%">No</th>
                        <th>Penyakit</th>
                        <th>Gejala</th>
                        <th width="10%" class="text-center">Nilai CF</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($aturan as $item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td>
                            <div><?= htmlspecialchars($item['penyakit']['nama_penyakit']) ?></div>
                            <small class="text-muted"><span class="badge badge-primary"><?= $item['penyakit']['kode_penyakit'] ?></span></small>
                        </td>
                        <td>
                            <div><?= htmlspecialchars($item['gejala']['nama_gejala']) ?></div>
                            <small class="text-muted"><span class="badge badge-primary"><?= $item['gejala']['kode_gejala'] ?></span></small>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-info" style="font-size: 0.9em;">
                                <?= number_format((float)$item['cf'], 2) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('/admin/master_aturan/edit/'.$item['id_aturan']) ?>" 
                                   class="btn btn-circle btn-sm btn-warning"
                                   data-toggle="tooltip" 
                                   title="Edit Aturan">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <span data-toggle="tooltip" title="Hapus Aturan">
                                    <button type="button" 
                                            class="btn btn-circle btn-sm btn-danger delete-btn"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-id="<?= $item['id_aturan'] ?>"
                                            data-kode="<?= $item['kode_aturan'] ?? '' ?>"
                                            data-url="<?= base_url('admin/master_aturan/delete/'.$item['id_aturan']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </span>
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
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus aturan <strong id="kodeAturan"></strong>?</p>
                <p class="text-muted small">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Data akan dipindahkan ke Recycle Bin dan dapat dipulihkan jika diperlukan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
            columnDefs: [
                { orderable: false, targets: [4] } // Disable sorting on action column
            ],
            order: [[0, 'asc']] // Default sort by No column
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize delete modal
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const kode = $(this).data('kode');
        const url = $(this).data('url');
        
        $('#kodeAturan').text(kode);
        $('#deleteForm').attr('action', url);
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>