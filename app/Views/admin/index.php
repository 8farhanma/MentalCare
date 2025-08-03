<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<?= $this->include('components/alerts') ?>

<!-- Content Row -->
<div class="row">

    <!-- Baris 1: Data Inti -->

    <!-- Data Gejala -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Gejala</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($gejala) ?> Gejala</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Penyakit -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Data Penyakit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($penyakit) ?> Penyakit</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-briefcase-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Aturan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Data Aturan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($aturan) ?> Aturan</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Diagnosis -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Laporan Diagnosis</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($diagnosis) ?> Laporan</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Baris 2: Data Pendukung -->

    <!-- Data FAQ -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Data FAQ</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($faq) ?> FAQ</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pengguna -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($user) ?> Pengguna</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data OTP -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Data OTP</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($otp) ?> Data</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Token -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Data Token</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($token) ?> Data</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-key fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Data Gejala</font>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="gejalaTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Gejala</th>
                        <th>Gejala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($gejala as $item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><a href="<?= base_url('admin/master_gejala') ?>"><?= $item['kode_gejala'] ?></a></td>
                        <td><?= $item['nama_gejala'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary m-2">
            <font color="#0A2342">Data Penyakit</font>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="penyakitTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($penyakit as $item) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><a href="<?= base_url('admin/master_penyakit') ?>"><?= $item['kode_penyakit'] ?></a></td>
                        <td><?= $item['nama_penyakit'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>