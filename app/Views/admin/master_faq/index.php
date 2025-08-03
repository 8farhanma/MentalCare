<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <font color="#0A2342">Data FAQ (Pertanyaan Umum)</font>
        </h5>
        <div class="btn-group">
            <a href="<?= base_url('admin/master_faq/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> Tambah FAQ
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($faq as $faq_item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= htmlspecialchars($faq_item['pertanyaan']) ?></td>
                        <td>
                            <?= strlen($faq_item['jawaban']) > 100 ? 
                                htmlspecialchars(substr($faq_item['jawaban'], 0, 100)) . '...' : 
                                htmlspecialchars($faq_item['jawaban']) ?>
                            <?php if (strlen($faq_item['jawaban']) > 100): ?>
                                <a href="#" class="view-more" data-toggle="modal" data-target="#viewAnswerModal" 
                                   data-question="<?= htmlspecialchars($faq_item['pertanyaan']) ?>"
                                   data-answer="<?= htmlspecialchars($faq_item['jawaban']) ?>">Selengkapnya</a>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('admin/master_faq/edit/'.$faq_item['id_faq']) ?>" 
                                   class="d-none d-sm-inline-block btn btn-circle btn-sm btn-warning shadow-sm"
                                   data-toggle="tooltip" 
                                   title="Edit FAQ">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <span data-toggle="tooltip" title="Hapus FAQ">
                                    <button type="button" 
                                            class="d-none d-sm-inline-block btn btn-circle btn-sm btn-danger shadow-sm delete-btn"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-id="<?= $faq_item['id_faq'] ?>"
                                            data-question="<?= htmlspecialchars($faq_item['pertanyaan']) ?>"
                                            data-url="<?= base_url('admin/master_faq/delete/'.$faq_item['id_faq']) ?>">
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

<!-- View Answer Modal -->
<div class="modal fade" id="viewAnswerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerModalTitle">Detail Jawaban</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify" id="faqAnswer"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
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
                <p>Anda yakin ingin menghapus FAQ berikut?</p>
                <div class="alert alert-light">
                    <p class="font-weight-bold mb-1" id="faqDeleteQuestion"></p>
                    <p class="text-muted small mb-0">Data yang dihapus akan dipindahkan ke Recycle Bin.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
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
                { orderable: false, targets: [3] }, // Disable sorting on action column
                { width: '5%', targets: 0 },    // No column width (5%)
                { width: '35%', targets: 1 },   // Question column width (35%)
                { width: '50%', targets: 2 },   // Answer column width (50%)
                { 
                    width: '10%', 
                    targets: 3,                 // Action column width (10%)
                    className: 'text-center'   // Center align action column
                }
            ],
            order: [[0, 'asc']], // Default sort by first column
            drawCallback: function() {
                // Re-initialize tooltips after table draw
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            }
        });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // Initialize view answer modal
    $('.view-more').on('click', function(e) {
        e.preventDefault();
        const question = $(this).data('question');
        const answer = $(this).data('answer');
        
        // Set the modal title with the question
        $('#answerModalTitle').text(question);
        // Set only the answer in the modal body
        $('#faqAnswer').text(answer);
    });

    // Initialize delete modal
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const question = $(this).data('question');
        const url = $(this).data('url');
        
        $('#faqDeleteQuestion').text(question);
        const form = $('#deleteForm');
        form.attr('action', url);
        
        // Update CSRF token in the form
        form.find('input[name="csrf_test_name"]').remove();
        form.prepend('<?= csrf_field() ?>');
    });
    
    // Handle form submission
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Close the modal
                $('#deleteModal').modal('hide');
                
                // Check if we have a success message in the response
                if (response.success) {
                    // Show success message
                    const alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                    
                    // Append alert before the card
                    $('.card').first().before(alertHtml);
                    
                    // Reload the page after a short delay to show the message
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // If no success message, just reload
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                // Show error message
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Terjadi kesalahan saat menghapus data
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                
                // Append alert before the card
                $('.card').first().before(alertHtml);
                
                // Close the modal
                $('#deleteModal').modal('hide');
                
                console.error('Error:', error);
            }
        });
    });

    // Confirm before toggling status
    $('.btn-toggle-status').on('click', function(e) {
        const action = $(this).hasClass('btn-success') ? 'mengaktifkan' : 'menonaktifkan';
        if (!confirm(`Anda yakin ingin ${action} FAQ ini?`)) {
            e.preventDefault();
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>