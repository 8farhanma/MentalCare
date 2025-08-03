<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data Penyakit</font>
        </h5>
        <div class="btn-group">
            <a href="<?= base_url('/admin/master_penyakit/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Penyakit
            </a>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                        <th>Deskripsi</th>
                        <th>Solusi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($penyakit as $item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><span class="badge badge-primary"><?= $item['kode_penyakit'] ?></span></td>
                        <td><?= htmlspecialchars($item['nama_penyakit']) ?></td>
                        <td>
                            <?php 
                            $deskripsi = $item['deskripsi_penyakit'] ?? '';
                            if (!empty($deskripsi)) {
                                if (strlen($deskripsi) > 100) {
                                    echo htmlspecialchars(substr($deskripsi, 0, 100)) . '...';
                                    echo ' <a href="#" class="view-more" data-toggle="modal" data-target="#viewContentModal" data-title="Deskripsi: ' . htmlspecialchars($item['nama_penyakit']) . '" data-content="' . htmlspecialchars($deskripsi) . '">Selengkapnya</a>';
                                } else {
                                    echo htmlspecialchars($deskripsi);
                                }
                            } else {
                                echo '<span class="text-muted">Tidak ada deskripsi</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            $solusi = $item['solusi_penyakit'] ?? '';
                            if (!empty($solusi)) {
                                if (strlen($solusi) > 100) {
                                    echo htmlspecialchars(substr($solusi, 0, 100)) . '...';
                                    echo ' <a href="#" class="view-more" data-toggle="modal" data-target="#viewContentModal" data-title="Solusi: ' . htmlspecialchars($item['nama_penyakit']) . '" data-content="' . htmlspecialchars($solusi) . '">Selengkapnya</a>';
                                } else {
                                    echo htmlspecialchars($solusi);
                                }
                            } else {
                                echo '<span class="text-muted">Tidak ada solusi</span>';
                            }
                            ?>
                        </td>
                        <td align="center">
                            <div class="d-flex justify-content-center">
                                <a href="<?= $item['edit_url'] ?>" 
                                   class="d-none d-sm-inline-block btn btn-circle btn-sm btn-warning shadow-sm mr-1"
                                   data-toggle="tooltip" 
                                   title="Edit Penyakit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <span data-toggle="tooltip" title="Hapus Penyakit">
                                    <button type="button" 
                                       class="d-none d-sm-inline-block btn btn-circle btn-sm btn-danger shadow-sm"
                                       data-toggle="modal" 
                                       data-target="#deleteModal"
                                       data-id="<?= $item['id_penyakit'] ?>"
                                       data-name="<?= htmlspecialchars($item['nama_penyakit']) ?>">
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
                <p>Anda yakin ingin menghapus data penyakit <strong id="penyakitName"></strong>?</p>
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

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- View Content Modal -->
<div class="modal fade" id="viewContentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contentModalTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify" id="modalContentBody"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        <i class="fas fa-trash-alt fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold mb-1">Hapus Data Penyakit</h6>
                        <p class="mb-0">Anda akan menghapus: <strong id="penyakitName"></strong></p>
                        <small class="text-muted">Data akan dipindahkan ke Recycle Bin dan dapat dipulihkan jika diperlukan.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus Semua Data -->
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
                Apakah Anda yakin ingin memindahkan seluruh data penyakit ke Recycle Bin?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= base_url('admin/master_penyakit/truncate') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Pindahkan Semua</button>
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
        var id = button.data('id');
        var name = button.data('name');
        var deleteUrl = '<?= base_url('admin/master_penyakit') ?>/' + id;
        
        $(this).find('#penyakitName').text(name);
        $(this).find('#deleteForm').attr('action', deleteUrl);
    });

    // Initialize view content modal
    $('.view-more').on('click', function(e) {
        e.preventDefault();
        const title = $(this).data('title');
        const content = $(this).data('content');
        
        $('#contentModalTitle').text(title);
        $('#modalContentBody').text(content);
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
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
            columnDefs: [
                { orderable: false, targets: [4] } // Disable sorting on action column
            ]
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<?= $this->endSection() ?>