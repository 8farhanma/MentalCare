<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="m-0 font-weight-bold text-primary">
        <font color="#0A2342">Data Pengguna</font>
    </h5>
    <!-- <div class="btn-group">
        <?php if (!empty($dataUsers) && in_array(2, array_column($dataUsers, 'role'))) : ?>
        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#konfirmasiTruncate">
            <i class="fas fa-trash mr-1"></i> Hapus Semua
        </button>
        <?php endif; ?>

    </div> -->
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($dataUsers as $item) : ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $item['nama_lengkap'] ?></td>
                                <td><?= $item['email'] ?></td>
                                <td><?= $item['role'] == 1 ? 'Admin' : 'User' ?></td>                                
                                <td class="text-center">
                                    <?php if ($item['role'] == 2): ?>
                                        <a href="<?= base_url('admin/master_user/activity/' . $item['id_user']) ?>" class="d-none d-sm-inline-block btn btn-circle btn-sm btn-info shadow-sm" data-toggle="tooltip" title="Lacak Aktivitas">
                                            <i class="fas fa-history"></i>
                                        </a>
                                        <span data-toggle="tooltip" title="Hapus User">
                                            <button type="button" class="d-none d-sm-inline-block btn btn-circle btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#deleteModal" data-id="<?= $item['id_user'] ?>" data-name="<?= htmlspecialchars($item['nama_lengkap']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Protected</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Truncate Data -->
    <div class="modal fade" id="konfirmasiTruncate" tabindex="-1" role="dialog" aria-labelledby="confirmTruncateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmTruncateModalLabel">Konfirmasi Hapus Semua Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin memindahkan seluruh data pengguna (non-admin) ke Recycle Bin?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= base_url('admin/master_user/truncate') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Pindahkan Semua</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memindahkan data user <strong id="userName"></strong> ke Recycle Bin?</p>
                <p class="text-muted">Data yang dipindahkan ke Recycle Bin dapat dipulihkan kembali.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Pindahkan ke Recycle Bin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize delete modal
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id');
        var userName = button.data('name');
        var modal = $(this);
        
        modal.find('#userName').text(userName);
        modal.find('#deleteForm').attr('action', '<?= base_url('admin/master_user/hapus/') ?>' + userId);
    });

    // Initialize DataTable if the table exists
    if ($.fn.DataTable) {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]]
        });
    }
});
</script>
<?php $this->endSection() ?>
