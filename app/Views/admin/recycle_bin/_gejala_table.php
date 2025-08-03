<?php if (!empty($gejala)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="gejala">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="gejala">
        <i class="fas fa-trash mr-1"></i> Hapus Semua Permanen
    </button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered datatable-recycle" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th width="15%">Dihapus Pada</th>
                <th class="text-center" width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($gejala) && !empty($gejala)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($gejala as $item) : ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td><?= esc($item['kode_gejala']); ?></td>
                        <td><?= esc($item['nama_gejala']); ?></td>
                        <td><?= esc(format_indo($item['deleted_at'])); ?></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_gejala']; ?>" data-type="gejala" title="Pulihkan"><i class="fas fa-undo"></i></button>
                            <button class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_gejala']; ?>" data-type="gejala" title="Hapus Permanen"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
