<?php if (!empty($faq)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="faq">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="faq">
        <i class="fas fa-trash mr-1"></i> Hapus Semua Permanen
    </button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered datatable-recycle" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th width="15%">Dihapus Pada</th>
                <th class="text-center" width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($faq) && !empty($faq)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($faq as $item) : ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td><?= esc($item['pertanyaan']); ?></td>
                        <td><?= esc($item['jawaban']); ?></td>
                        <td><?= esc(format_indo($item['deleted_at'])); ?></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_faq']; ?>" data-type="faq" title="Pulihkan"><i class="fas fa-undo"></i></button>
                            <button class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_faq']; ?>" data-type="faq" title="Hapus Permanen"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
