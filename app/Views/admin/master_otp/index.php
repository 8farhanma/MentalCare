<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data OTP</font>
        </h5>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i> Aksi
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteAllModal">
                    <i class="fas fa-trash mr-2"></i> Hapus Semua Data
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>OTP</th>
                        <th>Email</th>
                        <th>Tanggal Dibuat</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($dataOtp as $item) : ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><code><?= $item['otp'] ?></code></td>
                            <td><?= $item['email'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-circle btn-sm btn-danger" 
                                    data-toggle="modal" data-target="#deleteModal" 
                                    data-id="<?= $item['id'] ?>"
                                    data-email="<?= htmlspecialchars($item['email']) ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
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
                <p>Anda yakin ingin menghapus data OTP untuk email <strong id="emailTarget"></strong>?</p>
                <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
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

<!-- Delete All Confirmation Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Semua Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus semua data OTP?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i> Tindakan ini akan menghapus semua data secara permanen dan tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="<?= base_url('admin/master_otp/truncateData') ?>" class="btn btn-danger">Hapus Semua</a>
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
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]]
        });
    }

    // Initialize delete modal
    $('#deleteModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const email = button.data('email');
        
        const modal = $(this);
        modal.find('#emailTarget').text(email);
        modal.find('#deleteForm').attr('action', '<?= base_url('admin/master_otp/') ?>' + id);
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>