<?php if (!empty($penyakit)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="penyakit">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="penyakit">
        <i class="fas fa-trash mr-1"></i> Hapus Semua Permanen
    </button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered table-hover datatable-recycle" width="100%" cellspacing="0">
        <thead class="bg-light">
            <tr>
                <th width="5%">No</th>
                <th>Kode Penyakit</th>
                <th>Nama Penyakit</th>
                <th width="15%">Dihapus Pada</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($penyakit as $item) : ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= esc($item['kode_penyakit']) ?></td>
                <td><?= esc($item['nama_penyakit']) ?></td>
                <td>
                    <span class="badge badge-info"><?= esc($item['deleted_at']) ?></span>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_penyakit'] ?>" data-type="penyakit" title="Pulihkan">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_penyakit'] ?>" data-type="penyakit" title="Hapus Permanen">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
