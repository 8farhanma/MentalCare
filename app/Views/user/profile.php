<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Profil Pengguna</h1>
                                </div>

                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger">
                                        <?php
                                        $errors = session()->getFlashdata('error');
                                        if (is_array($errors)) {
                                            foreach ($errors as $error) {
                                                echo $error . '<br>';
                                            }
                                        } else {
                                            echo $errors;
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('success')) : ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>

                                <form method="POST" action="<?= base_url('user/profile/update') ?>" class="user">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                            value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                            value="<?= old('email', $user['email']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" <?= old('jenis_kelamin', $user['jenis_kelamin']) === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= old('jenis_kelamin', $user['jenis_kelamin']) === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" 
                                            value="<?= old('pekerjaan', $user['pekerjaan']) ?>" required>
                                    </div>

                                    <hr>
                                    <h5 class="text-center mb-4">Ubah Password (Opsional)</h5>

                                    <div class="form-group">
                                        <label for="password">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" 
                                                placeholder="Kosongkan jika tidak ingin mengubah password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                                    <i class="fa fa-eye-slash" id="eyeSlashIcon"></i>
                                                    <i class="fa fa-eye" id="eyeIcon" style="display: none;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Password minimal 8 karakter dengan huruf kapital, angka, dan karakter khusus</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirm">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" 
                                            placeholder="Konfirmasi password baru">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Update Profil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');

    if (password.type === 'password') {
        password.type = 'text';
        eyeIcon.style.display = 'inline';
        eyeSlashIcon.style.display = 'none';
    } else {
        password.type = 'password';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'inline';
    }
});
</script>

<?= $this->endSection() ?>
