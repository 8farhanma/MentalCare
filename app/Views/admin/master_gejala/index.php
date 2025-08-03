<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data Gejala</font>
        </h5>
        <div class="btn-group">
            <a href="<?= base_url('/admin/master_gejala/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Gejala
            </a>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="8%">No</th>
                        <th width="20%">Kode Gejala</th>
                        <th>Nama Gejala</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($gejala as $item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><span class="badge badge-primary"><?= $item['kode_gejala'] ?></span></td>
                        <td><?= htmlspecialchars($item['nama_gejala']) ?></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="<?= $item['edit_url'] ?>" 
                                   class="btn btn-circle btn-sm btn-warning"
                                   data-toggle="tooltip" 
                                   title="Edit Gejala">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <span data-toggle="tooltip" title="Hapus Gejala">
                                    <button type="button" 
                                            class="btn btn-circle btn-sm btn-danger delete-btn"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-id="<?= $item['id_gejala'] ?>"
                                            data-name="<?= htmlspecialchars($item['nama_gejala']) ?>"
                                            data-url="<?= base_url('admin/master_gejala/delete/'.$item['id_gejala']) ?>">
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
                <p>Anda yakin ingin menghapus gejala <strong id="gejalaName"></strong>?</p>
                <p class="text-muted small">Data akan dipindahkan ke Recycle Bin dan dapat dipulihkan jika diperlukan.</p>
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
                { orderable: false, targets: [3] } // Disable sorting on action column
            ]
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize delete modal
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const url = $(this).data('url');
        
        $('#gejalaName').text(name);
        $('#deleteForm').attr('action', url);
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>