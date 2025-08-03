<?= $this->extend('layout/homepage') ?>

<?= $this->section('disable_shortcuts') ?>
true
<?= $this->endSection() ?>

<?= $this->section('contentHome') ?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
        <h5 class="logo me-auto" style="font-size: 20px;">
            <img src="<?= base_url('img/logo.png') ?>" class="mb-1" style="height: 28px; width: 28px;" alt="">
            <a href="#home"><span class="mental-brand" style="color: #D56062">Mental</span><span class="care-brand" style="color: #A9A9A9">Care</span> </a>
        </h5>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="#cek">Cek Diagnosis</a></li>
                <li><a class="nav-link" href="<?= site_url('mentalbot') ?>">MentalBot</a></li>
                <li><a class="nav-link scrollto" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header>
<!-- End Header -->

<!-- ======= Home Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
            data-aos="fade-up" data-aos-delay="200">
            <h1>Cek Tingkat Depresimu</h1>
            <h2 class="mb-4">Selamat Datang <?= session()->get('nama_lengkap') ?><br> Silahkan Pilih <strong class="mental-brand" style="color: #D56062">Gejala</strong>
            Yang Kamu Alami!</h2>
            <div class="d-flex justify-content-center justify-content-lg-start mt-3">
                <a href="#cek" class="btn-get-started scrollto">Pilih Gejala</a>
            </div>
        </div>
        <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
            <img src="<?= base_url('landing/assets/img/doctor.png') ?>" class="img-fluid animated"
            style="height: 280px; width: 280px; margin-bottom: 50px; margin-top: -50px;">
        </div>
    </div>
</div>
</section>
<!-- End Home -->

<!-- ======= FAQ Section ======= -->
<main id="main">
    <section id="cek" class="faq section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Form Diagnosis</h2>
                <p><strong>Tidak semua gejala harus dipilih!</strong>, jadi pastikan untuk memberikan pilihan gejala yang tepat sesuai dengan yang dialami oleh anda. Silahkan cek panduan untuk informasi lebih detail.</p>
            </div>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <form id="formDiagnosis" action="<?= site_url('user/hasil_diagnosis') ?>" method="post">
                        <!-- Form Step 1 - Biodata -->
                        <div id="step1">
                            <div class="card-header">
                                <a type="button" class="btn btn-outline-danger btn-sm mt-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#panduan">
                                    <i class="fas fa-book"></i> Panduan
                                </a>
                                <h5 class="m-0 font-weight-bold text-primary m-2">
                                    <font color="#0A2342">Biodata</font>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" maxlength="50" name="nama" value="<?= session()->get('nama_lengkap') ?>" readonly required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" id="pekerjaan" placeholder="Status Pekerjaan" name="pekerjaan" required>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <select class="form-select" aria-label="Default select example" name="jk" id="jk" required>
                                            <option selected disabled>Pilih Jenis Kelamin</option>
                                            <option>Laki - Laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <div class="input-group-text">Tanggal</div>
                                        <input type="date" name="tgl_diagnosis" id="tgl_diagnosis" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Step 2 - Pertanyaan Internal -->
                        <div id="step2">
                            <div class="card-header">
                                <a type="button" class="btn btn-outline-danger btn-sm mt-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#panduan">
                                    <i class="fas fa-book"></i> Panduan
                                </a>
                                <h5 class="m-0 font-weight-bold text-primary m-2">
                                    <font color="#0A2342">Pertanyaan Tentang Anda</font>
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- p_1: Usia -->
                                <div class="form-group mt-4">
                                    <label for="p_1" class="mb-2">Berapa rentang usia anda?</label>
                                    <select class="form-select" aria-label="Default select example" name="p_1" id="p_1" required>
                                        <option selected disabled>--Pilih--</option>
                                        <option>15-24 Tahun (Remaja hingga Awal Dewasa)</option>
                                        <option>25-34 Tahun (Dewasa Muda)</option>
                                        <option>35-44 Tahun (Dewasa Tengah)</option>
                                        <option>45-54 Tahun (Dewasa Tengah Lebih)</option>
                                        <option>55-64 Tahun (Menjelang Pensiun)</option>
                                    </select>
                                </div>

                                <!-- p_2: Pengobatan Medis -->
                                <div class="form-group mt-4">
                                    <label class="mb-2">Apakah Anda sedang menjalani pengobatan untuk kondisi medis lain saat ini?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="p_2_radio" id="p_2_ya" value="Ya" required>
                                        <label class="form-check-label" for="p_2_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="p_2_radio" id="p_2_tidak" value="Tidak">
                                        <label class="form-check-label" for="p_2_tidak">Tidak</label>
                                    </div>
                                    <textarea rows="3" class="form-control mt-2" id="p_2_detail" name="p_2_detail" placeholder="Jelaskan pengobatan yang sedang Anda jalani (misal: obat, terapi, dll.)" style="display: none;"></textarea>
                                </div>

                                <!-- p_3: Masalah Utama -->
                                <div class="form-group mt-4">
                                    <label for="p_3" class="mb-2">Apakah ada masalah berikut yang menggambarkan anda sekarang?</label>
                                    <select class="form-select" aria-label="Default select example" name="p_3" id="p_3" required>
                                        <option selected disabled>--Pilih--</option>
                                        <option>Tidak Ada</option>
                                        <option>Masalah ekonomi keluarga</option>
                                        <option>Masalah orang tua (bercerai atau konflik keluarga)</option>
                                        <option>Masalah hubungan (keluarga, teman, pasangan)</option>
                                        <option>Tekanan akademik (Skripsi, ujian, atau beban studi)</option>
                                        <option>Masalah pekerjaan (stres, tekanan karier, atau pengangguran)</option>
                                        <option>Kehilangan seseorang yang berharga (meninggal dunia)</option>
                                        <option>Masalah keuangan pribadi (pembayaran kuliah, utang, dll.)</option>
                                        <option>Kesulitan mengatur waktu antara pekerjaan dan kehidupan pribadi</option>
                                        <option>Kecemasan atau stres terkait masa depan (karier, pensiun, keluarga)</option>
                                        <option value="lainnya">Lainnya...</option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="p_3_lainnya" name="p_3_lainnya" placeholder="Tuliskan masalah Anda di sini" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Form Step 3 - Pilih Gejala -->
                        <div id="step3">
                            <div class="card-header">
                                <a type="button" class="btn btn-outline-danger btn-sm mt-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#panduan">
                                    <i class="fas fa-book"></i> Panduan
                                </a>
                                <h5 class="m-0 font-weight-bold text-primary m-2">
                                    <font color="#0A2342">Pilih Gejala</font>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item mt-4">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                <i class="fas fa-clipboard-list"></i>&nbsp;Pilih Gejala
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <!-- Stack untuk Undo -->
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <!-- <button type="button" class="btn btn-outline-primary btn-sm" id="undoButton" onclick="undoLastAction()">
                                                            <i class="fas fa-undo"></i> Batalkan Pilihan
                                                        </button> -->
                                                        <button type="button" class="btn btn-outline-danger btn-sm ms-2" id="resetButton" onclick="showResetConfirmation()">
                                                            <i class="fas fa-times-circle"></i> Reset Semua
                                                        </button>
                                                    </div>
                                                    <div class="text-end">
                                                        <span id="selectedCount" class="badge bg-black">0 gejala dipilih</span>
                                                    </div>
                                                </div>
                                                <div id="lastActionContainer" class="mb-3">
                                                    <small class="text-muted" id="lastAction"></small>
                                                </div>

                                                <!-- Ringkasan Gejala Terpilih -->
                                                <div class="selected-symptoms-card card mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">
                                                            <i class="fas fa-clipboard-check"></i> Gejala yang Dipilih
                                                        </h6>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <ul id="selectedSymptomsList" class="list-group list-group-flush">
                                                            <!-- Diisi secara dinamis -->
                                                        </ul>
                                                        <div id="noSymptomsSelected" class="text-center py-3 text-muted">
                                                            <i class="fas fa-info-circle"></i> Belum ada gejala yang dipilih
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gejala-list-container mt-4">
                                                    <?php foreach ($result as $gejala) : ?>
                                                        <div class="gejala-item card card-body mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input gejala-checkbox" type="checkbox" name="selectedGejala[]" value="<?= $gejala['id_gejala'] ?>" id="check<?= $gejala['id_gejala'] ?>" data-gejala-name="<?= $gejala['nama_gejala'] ?>">
                                                                <label class="form-check-label" for="check<?= $gejala['id_gejala'] ?>">
                                                                    <strong><?= $gejala['kode_gejala'] ?>:</strong> Apakah <?= $gejala['nama_gejala'] ?>?
                                                                </label>
                                                            </div>
                                                            <div class="cf-options-container mt-3" id="cf-container-<?= $gejala['id_gejala'] ?>" style="display: none;">
                                                                <label class="mb-2 d-block">Tingkat Keyakinan:</label>
                                                                <div class="cf-radio-group">
                                                                    <?php
                                                                    // Definisikan pemetaan dari kata kunci di nama keyakinan ke kelas warna
                                                                    $colorMap = [
                                                                        'Sangat Pasti'      => 'bg-danger',
                                                                        'Pasti'             => 'bg-warning',
                                                                        'Kemungkinan Besar' => 'bg-primary',
                                                                        'Mungkin'           => 'bg-info',
                                                                        'Tidak Yakin'       => 'bg-secondary',
                                                                        'Tidak Sama Sekali' => 'bg-dark'
                                                                    ];

                                                                    foreach ($listCFUser as $item) :
                                                                        $namaNilai = $item['nama_nilai'];
                                                                        $colorClass = 'bg-dark'; // Warna default jika tidak ada yang cocok

                                                                        // Cari padanan warna yang paling cocok berdasarkan kata kunci
                                                                        foreach ($colorMap as $key => $color) {
                                                                            if (stripos($namaNilai, $key) !== false) {
                                                                                $colorClass = $color;
                                                                                break; // Hentikan setelah menemukan kecocokan pertama
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input cf-radio"
                                                                               type="radio"
                                                                               name="cf[<?= $gejala['id_gejala'] ?>]"
                                                                               id="cf_<?= $gejala['id_gejala'] ?>_<?= $item['id_cf_user'] ?>"
                                                                               value="<?= $item['id_cf_user'] ?>"
                                                                               data-cf-name="<?= $item['nama_nilai'] ?>"
                                                                               data-color-class="<?= $colorClass ?>"
                                                                               disabled
                                                                               required>
                                                                        <label class="form-check-label" for="cf_<?= $gejala['id_gejala'] ?>_<?= $item['id_cf_user'] ?>"><?= $item['nama_nilai'] ?></label>
                                                                    </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="mx-auto mb-4 mt-2 text-center">
                            <button type="button" class="btn btn-outline-danger" id="prevBtn"><i class="fas fa-chevron-left"></i>Sebelumnya</button>
                            <button type="button" class="btn btn-outline-danger" id="nextBtn">Selanjutnya <i class="fas fa-chevron-right"></i></button>
                            <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;"><i class="fas fa-play-circle"></i> Mulai Diagnosis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Reset -->
<div class="modal fade" id="resetConfirmModal" tabindex="-1" aria-labelledby="resetConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="resetConfirmModalLabel">Konfirmasi Reset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus semua pilihan gejala?</p>
                <p class="text-muted small">Semua gejala yang telah Anda pilih akan dihapus dan tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmResetBtn">Ya, Reset Semua</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar dari sesi ini?</p>
                <p class="text-muted small">Anda akan diarahkan kembali ke halaman login.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Ya, Logout</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ukuran teks default */
    :root {
        --base-font-size: 16px;
    }

    /* Ukuran teks untuk berbagai elemen */
    body.font-small {
        --base-font-size: 14px;
    }

    body.font-medium {
        --base-font-size: 16px;
    }

    body.font-large {
        --base-font-size: 18px;
    }

    /* Terapkan ukuran teks ke elemen-elemen dengan font family yang sesuai */
    .form-control,
    .form-select,
    .btn,
    .nav-link,
    .accordion-button,
    p,
    label,
    .form-check-label {
        font-size: var(--base-font-size) !important;
        font-family: "Open Sans", sans-serif !important;
    }

    /* Logo style */
    .logo {
        font-family: "Jost", sans-serif !important;
    }

    /* Heading menggunakan font dan skala relatif yang sesuai */
    h1, h2, h5 { 
        font-family: "Jost", sans-serif !important;
    }
    h1 { font-size: calc(var(--base-font-size) * 2.5) !important; }
    h2 { font-size: calc(var(--base-font-size) * 2) !important; }
    h5 { font-size: calc(var(--base-font-size) * 1.25) !important; }

    /* Teks kecil menggunakan skala relatif */
    .small, small {
        font-size: calc(var(--base-font-size) * 0.875) !important;
        font-family: "Open Sans", sans-serif !important;
    }

    /* Animasi transisi untuk perubahan ukuran teks */
    * {
        transition: font-size 0.3s ease;
    }

    /* Style untuk dropdown ukuran teks */
    .dropdown-menu {
        min-width: 120px;
        font-family: "Open Sans", sans-serif !important;
    }

    .dropdown-item {
        padding: 8px 16px;
        font-family: "Open Sans", sans-serif !important;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* Warna brand MentalCare */
    .mental-brand {
        color: #D56062 !important;
    }

    .care-brand {
        color: #A9A9A9 !important;
    }

    /* Style untuk ringkasan gejala */
    .selected-symptoms-card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        max-height: 300px;
        overflow-y: auto;
    }

    .selected-symptoms-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 0.75rem 1rem;
    }

    .selected-symptoms-card .card-header h6 {
        color: #495057;
        font-size: 0.9rem;
        margin: 0;
    }

    .selected-symptoms-card .list-group-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-left: none;
        border-right: none;
    }

    .selected-symptoms-card .list-group-item:first-child {
        border-top: none;
    }

    .selected-symptoms-card .list-group-item:last-child {
        border-bottom: none;
    }

    .selected-symptoms-card .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }

    #noSymptomsSelected {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Animasi untuk item baru */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .symptom-item-new {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // --- Inisialisasi Awal ---
    let currentStep = 0;
    const formSteps = $('[id^="step"]').not('#step-display');
    const resetModal = new bootstrap.Modal($('#resetConfirmModal')[0]);
    const FORM_STATE_KEY = 'diagnosisFormState';

    // --- Manajemen State dengan sessionStorage ---
    function saveFormState() {
        const state = {
            currentStep: currentStep,
            formData: {}
        };
        const formArray = $('#formDiagnosis').serializeArray();
        $.each(formArray, function(i, field) {
            if (state.formData[field.name]) {
                if (!Array.isArray(state.formData[field.name])) {
                    state.formData[field.name] = [state.formData[field.name]];
                }
                state.formData[field.name].push(field.value);
            } else {
                state.formData[field.name] = field.value;
            }
        });
        sessionStorage.setItem(FORM_STATE_KEY, JSON.stringify(state));
    }

    function loadFormState() {
        const savedState = sessionStorage.getItem(FORM_STATE_KEY);
        if (savedState) {
            const state = JSON.parse(savedState);
            $.each(state.formData, function(name, value) {
                const field = $(`[name="${name}"]`);
                if (field.length > 0) {
                    const type = field.attr('type');
                    if (type === 'radio' || type === 'checkbox') {
                        field.each(function() {
                            if (Array.isArray(value)) {
                                $(this).prop('checked', $.inArray($(this).val(), value) !== -1);
                            } else {
                                $(this).prop('checked', $(this).val() === value);
                            }
                        });
                    } else {
                        field.val(value);
                    }
                }
            });
            currentStep = state.currentStep || 0;
            showStep(currentStep);
            $('.gejala-checkbox').trigger('change');
            setTimeout(() => {
                updateSelectedSymptomsList();
                updateGejalaCount();
            }, 350);
        } else {
            showStep(currentStep);
            updateSelectedSymptomsList();
            updateGejalaCount();
            $('#tgl_diagnosis').val(new Date().toISOString().substr(0, 10));
        }
    }

    function clearFormState() {
        sessionStorage.removeItem(FORM_STATE_KEY);
    }

    loadFormState();

    $('.modal-footer a[href*="logout"]').on('click', function(e) {
        clearFormState();
    });

    function showStep(stepIndex) {
        formSteps.hide();
        $(formSteps[stepIndex]).show();
        $('#prevBtn').toggle(stepIndex > 0);
        $('#nextBtn').toggle(stepIndex < formSteps.length - 1);
        $('#submitBtn').toggle(stepIndex === formSteps.length - 1);
    }

    function validateStep(step) {
        let isValid = true;
        let errorMsg = '';
        const inputs = $(formSteps[step]).find('input[required], select[required]');
        inputs.each(function() {
            if (!$(this).val() || $(this).val().trim() === '') {
                isValid = false;
                const label = $(this).closest('.form-group').find('label').text() || $(this).attr('placeholder');
                errorMsg = `Harap lengkapi isian: "${label.replace(':', '').trim()}"`;
                return false;
            }
        });
        if (!isValid) {
            Swal.fire('Validasi Gagal', errorMsg, 'warning');
        }
        return isValid;
    }

    $('#formDiagnosis').on('change keyup', 'input, select, textarea', function() {
        saveFormState();
    });

    $('#nextBtn').on('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
            saveFormState();
        }
    });

    $('#prevBtn').on('click', function() {
        currentStep--;
        showStep(currentStep);
        saveFormState();
    });

    $('.gejala-checkbox').on('change', function() {
        const gejalaId = $(this).val();
        const cfContainer = $(`#cf-container-${gejalaId}`);
        const cfRadios = cfContainer.find('.cf-radio');
        if ($(this).is(':checked')) {
            cfContainer.slideDown();
            cfRadios.prop('disabled', false);
        } else {
            cfContainer.slideUp();
            cfRadios.prop('disabled', true).prop('checked', false);
        }
        setTimeout(() => {
            updateSelectedSymptomsList();
            updateGejalaCount();
        }, 300);
    });

    $(document).on('change', '.cf-radio', function() {
        updateSelectedSymptomsList();
    });

    function updateSelectedSymptomsList() {
        const list = $('#selectedSymptomsList');
        const noSymptomsDiv = $('#noSymptomsSelected');
        list.empty();
        let hasSelection = false;
        $('.gejala-checkbox:checked').each(function() {
            const gejalaName = $(this).data('gejala-name');
            const radioGroup = $(this).closest('.gejala-item').find('.cf-radio');
            const selectedRadio = radioGroup.filter(':checked');
            const cfName = selectedRadio.data('cf-name');
            const colorClass = selectedRadio.data('color-class') || 'bg-secondary';
            const displayText = selectedRadio.length ? cfName : 'Belum dipilih';
            const listItem = `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${gejalaName}</span>
                                <span class="badge ${colorClass} rounded-pill">${displayText}</span>
                            </li>`;
            list.append(listItem);
            hasSelection = true;
        });
        noSymptomsDiv.toggle(!hasSelection);
        list.toggle(hasSelection);
    }

    function updateGejalaCount() {
        const count = $('.gejala-checkbox:checked').length;
        $('#selectedCount').text(`${count} gejala dipilih`);
    }

    $('#p_3').on('change', function() {
        if ($(this).val() === 'lainnya') {
            $('#p_3_lainnya').show().prop('required', true);
        } else {
            $('#p_3_lainnya').hide().prop('required', false).val('');
        }
    });

    $('input[name="p_2_radio"]').on('change', function() {
        if ($(this).val() === 'Ya') {
            $('#p_2_detail').show().prop('required', true);
        } else {
            $('#p_2_detail').hide().prop('required', false).val('');
        }
    });

    $('#resetButton').on('click', function() {
        if ($('.gejala-checkbox:checked').length > 0) {
            resetModal.show();
        } else {
            Swal.fire('Informasi', 'Tidak ada gejala yang dipilih untuk direset.', 'info');
        }
    });

    $('#confirmResetBtn').on('click', function() {
        clearFormState();
        $('#formDiagnosis')[0].reset();
        $('.gejala-checkbox').prop('checked', false).trigger('change');
        setTimeout(() => {
            resetModal.hide();
            Swal.fire('Berhasil', 'Semua pilihan gejala telah direset.', 'success').then(() => {
                window.location.reload();
            });
        }, 350);
    });

    // --- Submit Form ---
    $('#formDiagnosis').on('submit', function(e) {

        const checkedGejala = $('.gejala-checkbox:checked');
        let allCfSelected = true;
        checkedGejala.each(function() {
            const radioGroup = $(this).closest('.gejala-item').find('.cf-radio');
            if (radioGroup.filter(':checked').length === 0) {
                allCfSelected = false;
                const gejalaName = $(this).data('gejala-name');
                e.preventDefault(); // Hentikan submit jika validasi gagal
                Swal.fire('Validasi Gagal', `Harap pilih tingkat keyakinan untuk gejala: "${gejalaName}"`, 'error');
                return false; // Keluar dari loop
            }
        });

        // Jika validasi gagal, form sudah dihentikan oleh e.preventDefault() di atas.
        if (!allCfSelected) {
            return;
        }

        // Jika semua validasi lolos, bersihkan session storage dan biarkan form dikirim.
        clearFormState();
    });
});
</script>

<!-- Modal - Panduan -->
<div class="modal fade" id="panduan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Panduan Cek Diagnosis</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol>
                    <li>Pilih gejala yang Anda alami dengan cara mencentang kode gejala yang ingin dipilih.</li>
                    <li>Selanjutnya, pilih nilai pada gejala yang telah Anda centang.</li>
                    <li>Lanjutkan memilih gejala selanjutnya dengan cara yang sama.</li>
                    <li>Setelah semua gejala terpilih, klik tombol "Mulai Diagnosis" untuk memulai proses diagnosis.</li>
                </ol>
                <hr>
                <p><strong>Catatan:</strong></p>
                <ol>
                    <li>Sistem akan mengalami error jika biodata tidak diisi dengan lengkap.</li>
                    <li>Sistem juga akan mengalami error jika kode gejala yang Anda pilih tidak dicentang.</li>
                    <li>Pastikan untuk mengisi nilai pada gejala yang Anda pilih.</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>