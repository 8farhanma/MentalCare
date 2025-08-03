<?php if (!empty($laporan)) : ?>
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-success btn-sm mr-2 restore-all-btn" data-type="laporan">
        <i class="fas fa-undo mr-1"></i> Pulihkan Semua
    </button>
    <button type="button" class="btn btn-danger btn-sm delete-all-btn" data-type="laporan">
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
                <th>Penyakit Terdiagnosis</th>
                <th>Tanggal Diagnosis</th>
                <th width="15%">Dihapus Pada</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($laporan as $item) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= esc($item['nama_pasien']); ?></td>
                                                <td><?= esc($item['nama_penyakit']); ?></td>
                        <td><?= esc(isset($item['tgl_diagnosis']) ? date('d/m/Y', strtotime($item['tgl_diagnosis'])) : '-'); ?></td>
                        <td><span class="badge badge-info"><?= esc($item['deleted_at']); ?></span></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm restore-btn" data-id="<?= $item['id_diagnosis']; ?>" data-type="laporan" title="Pulihkan"><i class="fas fa-undo"></i></button>
                            <button class="btn btn-danger btn-sm delete-permanent-btn" data-id="<?= $item['id_diagnosis']; ?>" data-type="laporan" title="Hapus Permanen"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
