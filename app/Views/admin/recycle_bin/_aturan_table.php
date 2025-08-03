<?php if (!empty($aturan)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="aturan">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="aturan">
        <i class="fas fa-trash mr-1"></i> Hapus Semua Permanen
    </button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered table-hover datatable-recycle" width="100%" cellspacing="0">
        <thead class="bg-light">
            <tr>
                <th width="5%">No</th>
                <th>Penyakit</th>
                <th>Gejala</th>
                <th width="15%">Dihapus Pada</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($aturan as $item) : ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td>
                    <div class="font-weight-bold"><?= esc($item['penyakit']['nama_penyakit'] ?? 'Data Penyakit Terhapus') ?></div>
                    <small class="text-muted"><?= esc($item['penyakit']['kode_penyakit'] ?? 'N/A') ?></small>
                </td>
                <td>
                    <div class="font-weight-bold"><?= esc($item['gejala']['nama_gejala'] ?? 'Data Gejala Terhapus') ?></div>
                    <small class="text-muted"><?= esc($item['gejala']['kode_gejala'] ?? 'N/A') ?></small>
                </td>
                <td>
                    <span class="badge badge-info"><?= esc($item['deleted_at']) ?></span>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_aturan'] ?>" data-type="aturan" title="Pulihkan">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_aturan'] ?>" data-type="aturan" title="Hapus Permanen">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
