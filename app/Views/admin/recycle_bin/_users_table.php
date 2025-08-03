<?php if (!empty($users)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="user">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="user">
        <i class="fas fa-trash mr-1"></i> Hapus Semua Permanen
    </button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered table-hover datatable-recycle" width="100%" cellspacing="0">
        <thead class="bg-light">
            <tr>
                <th width="5%">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th width="15%">Dihapus Pada</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($users as $item) : ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= esc($item['nama_lengkap']) ?></td>
                <td><?= esc($item['email']) ?></td>
                <td>
                    <span class="badge badge-info"><?= esc($item['deleted_at']) ?></span>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_user'] ?>" data-type="user" title="Pulihkan">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_user'] ?>" data-type="user" title="Hapus Permanen">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
