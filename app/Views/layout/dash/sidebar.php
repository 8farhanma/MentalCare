<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #0A2342;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin') ?>">
        <div class="sidebar-brand-icon">
            <span class="logo-lg"> <img src="<?= base_url('img/logo.png') ?>" width="30px" height="30px"></span>
        </div>
        <div class="sidebar-brand-text mx-2 text-lg"><span style="color: #D56062">Mental</span><span style="color: #A9A9A9">Care</span></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= service('request')->uri->getPath() == 'admin' || service('request')->uri->getPath() == '/admin/' ? 'active' : '' ?>">
        <a href="<?= base_url('/admin') ?>" class="nav-link">
            <i class="fas fa-home"></i>
            <span class="mx-1">Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_user') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/master_user') ?>" class="nav-link">
            <i class="fas fa-user-graduate"></i>
            <span class="mx-2">Data Pengguna</span>
        </a>
    </li>
    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_gejala') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/master_gejala') ?>" class="nav-link">
            <i class="fas fa-notes-medical"></i>
            <span class="mx-2">Data Gejala</span>
        </a>
    </li>
    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_penyakit') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/master_penyakit') ?>" class="nav-link">
            <i class="fas fa-briefcase-medical"></i>
            <span class="mx-1">Data Penyakit</span>
        </a>
    </li>
    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_aturan') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/master_aturan') ?>" class="nav-link">
            <i class="fas fa-book-medical"></i>
            <span class="mx-2">Data Aturan</span>
        </a>
    </li>
    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_faq') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/master_faq') ?>" class="nav-link">
            <i class="fas fa-question"></i>
            <span class="mx-2">Data Faq</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan & Alat
    </div>

    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/master_laporan') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/master_laporan') ?>">
            <i class="fas fa-chart-bar"></i>
            <span class="mx-2">Laporan Diagnosis</span>
        </a>
    </li>
    <li class="nav-item <?= strpos(service('request')->uri->getPath(), 'admin/recycle_bin') !== false ? 'active' : '' ?>">
        <a href="<?= base_url('admin/recycle_bin') ?>" class="nav-link">
            <i class="fas fa-trash-restore"></i>
            <span class="mx-2">Keranjang Sampah</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan Akun
    </div>

    <?php if (!session()->get('is_2fa_enabled')) : ?>
    <li class="nav-item <?= service('request')->uri->getPath() == 'admin/enable-2fa' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/enable-2fa') ?>" class="nav-link">
            <i class="fas fa-shield-alt"></i>
            <span class="mx-2">Aktifkan 2FA</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if (session()->get('is_2fa_enabled')) : ?>
    <li class="nav-item">
        <!-- Button trigger modal -->
        <button type="button" class="nav-link btn btn-link w-100 text-left px-3" data-toggle="modal" data-target="#disable2FAModal" style="color:#fff;text-align:left;width:100%">
            <i class="fas fa-unlock-alt"></i>
            <span class="mx-2">Nonaktifkan 2FA</span>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="disable2FAModal" tabindex="-1" aria-labelledby="disable2FALabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="disable2FALabel">Konfirmasi Nonaktifkan 2FA</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"></button>
              </div>
              <div class="modal-body">
                Apakah Anda yakin ingin menonaktifkan Two-Factor Authentication?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="post" action="<?= base_url('admin/disable-2fa') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>