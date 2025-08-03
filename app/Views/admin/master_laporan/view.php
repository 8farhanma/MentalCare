<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<!-- Table Biodata -->
<div class="card shadow mb-4">
    <div class="card-header" id="biodata-header" data-toggle="collapse" data-target="#biodata-collapse">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Biodata</font>
        </h5>
    </div>
    <div class="collapse" id="biodata-collapse">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td><?= $diagnosis['nama'] ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?= $diagnosis['jk'] ?></td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td><?= $diagnosis['pekerjaan'] ?></td>
                        </tr>

                        <tr>
                            <th>Tanggal Diagnosis</th>
                            <td><?= date('d-m-Y', strtotime($diagnosis['tgl_diagnosis'])) ?></td>
                        </tr>
                        <tr>
                            <th>Tingkat Depresi</th>
                            <td><?= $penyakit['kode_penyakit']; ?> <?= $penyakit['nama_penyakit']; ?></td>
                        </tr>
                        <tr>
                            <th>CF Akhir</th>
                            <td><?= $diagnosis['cf_akhir'] ?></td>
                        </tr>
                        <tr>
                            <th>Persentase</th>
                            <td><?= $diagnosis['presentase'] ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Table Biodata -->
<div class="card shadow mb-4">
    <div class="card-header" id="biodata-header" data-toggle="collapse" data-target="#tentang-collapse">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Tentang</font>
        </h5>
    </div>
    <div class="collapse" id="tentang-collapse">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Berapa rentang usia Anda?</th>
                            <td><?= esc($diagnosis['p_1']) ?></td>
                        </tr>
                        <tr>
                            <th>Apakah Anda sedang menjalani pengobatan untuk kondisi medis lain saat ini?</th>
                            <td><?= esc($diagnosis['p_2']) ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsikan masalah utama yang Anda hadapi saat ini:</th>
                            <td><?= esc($diagnosis['p_3']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Table Detail Penyakit -->
<div class="card shadow mb-4">
    <div class="card-header" id="detail-penyakit-header" data-toggle="collapse" data-target="#detail-penyakit-collapse">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Tingkat Depresi Yang Dialami</font>
        </h5>
    </div>
    <div class="collapse" id="detail-penyakit-collapse">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Kode Penyakit</th>
                            <td><?= $penyakit['kode_penyakit']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Penyakit</th>
                            <td><?= $penyakit['nama_penyakit']; ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsi Penyakit</th>
                            <td><?= $penyakit['deskripsi_penyakit']; ?></td>
                        </tr>
                        <tr>
                            <th>Solusi Penanganan <?= $penyakit['kode_penyakit']; ?></th>
                            <td><?= $penyakit['solusi_penyakit']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header" id="detail-depresi-header" data-toggle="collapse" data-target="#detail-depresi-collapse">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Perbandingan Nilai Depresi Terbesar</font>
        </h5>
    </div>
    <div class="collapse" id="detail-depresi-collapse">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="tabel-warning">
                            <th>No</th>
                            <th>Kode Penyakit</th>
                            <th>Nama Penyakit</th>
                            <th>CF Hasil</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2">CF Terbesar</th>
                            <th><?= $penyakit['kode_penyakit'] ?> | <?= $penyakit['nama_penyakit'] ?></th>
                            <th><?= $diagnosis['cf_akhir'] ?></th>
                            <th><?= $diagnosis['presentase'] ?>%</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($diagnosisGejala as $data) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $data['kode_penyakit']; ?></td>
                                <td><?= $data['nama_penyakit']; ?></td>
                                <td><?= $data['cf_hasil']; ?></td>
                                <td><?= $data['cf_hasil'] * 100; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Table Detail Diagnosis -->
<div class="card shadow mb-4">
    <div class="card-header" id="detail-diagnosis-header" data-toggle="collapse" data-target="#detail-diagnosis-collapse">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Detail Diagnosis</font>
        </h5>
    </div>
    <div class="collapse" id="detail-diagnosis-collapse">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Gejala</th>
                            <th>Nama Gejala</th>
                            <th>Kode Penyakit</th>
                            <th>Nama Penyakit</th>
                            <th>Nama Nilai</th>
                            <th>CF User</th>
                            <th>CF Pakar</th>
                            <th>CFU * CFP</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="8">CF Combine</th>
                            <th><?= $diagnosis['cf_akhir'] ?></th>
                        </tr>
                        <tr>
                            <th colspan="8">Persentase</th>
                            <th><?= $diagnosis['presentase'] ?>%</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($diagnosisGejala as $data) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $data['kode_gejala'] ?></td>
                                <td><?= $data['nama_gejala'] ?></td>
                                <td><?= $data['kode_penyakit'] ?></td>
                                <td><?= $data['nama_penyakit'] ?></td>
                                <td><?= $data['nama_nilai'] ?></td>
                                <td><?= $data['cf'] ?></td>
                                <td><?= $data['cf_pakar'] ?? '0' ?></td>
                                <td><?= $data['cf'] * ($data['cf_pakar'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="<?= base_url('admin/master_laporan') ?>" class="btn btn-warning btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
</a>
<a href="<?= base_url('admin/master_laporan/unduhDiagnosis/' . $diagnosis['id_diagnosis']) ?>" class="btn btn-danger btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-print"></i>
    </span>
    <span class="text">Unduh PDF</span>
</a>

<?= $this->endSection() ?>