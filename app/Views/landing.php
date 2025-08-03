<?= $this->extend('layout/homepage') ?>
<?= $this->section('contentHome') ?>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

        <h5 class="logo me-auto" style="font-size: 20px;">
            <img src="<?= base_url('img/logo.png') ?>" class="mb-1" style="height: 28px; width: 28px;" alt="">
            <a href="#home" style="text-transform: none;"><span style="color: #D56062">MENTAL</span><span style="color: #A9A9A9">CARE</span></a>
        </h5>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#tentang">Tentang</a></li>
                <li><a class="nav-link scrollto" href="#informasi">Informasi</a></li>
                <li><a class="nav-link scrollto" href="#faq">Faq</a></li>
                <li><a class="nav-link scrollto" href="#footer">Kontak</a></li>
              <li><a class="getstarted scrollto" href="<?= base_url('login-user') ?>">Masuk / Buat Akun</a></li>
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
            <h1>Smart Mental Health Assement</h1>
            <h2 class="mb-4">Sistem Pakar Diagnosis <strong style="color: #D56062">Tingkat Depresi</strong>
            yang dirancang khusus untuk kalangan masyarakat usia produktif</h2>
            <div class="d-flex justify-content-center justify-content-lg-start mt-3">
                <a href="<?= base_url ('login-user') ?>" class="btn-get-started scrollto">Cek Tingkat Depresimu
                Sekarang</a>
                <a class="btn-watch-video" id="liveToastBtn"><i class="fas fa-heartbeat"></i><span></span></a>
            </div>
        </div>
        <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
            <img src="<?= base_url('img/logo.png') ?>" class="img-fluid animated"
            style="height: 240px; width: 240px; margin-bottom: 50px; margin-top: -50px;">
        </div>
    </div>
</div>

</section>
<!-- End Home -->

<main id="main">

    <!-- ======= Tentang Section ======= -->
    <section id="tentang" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Tentang</h2>
            </div>

            <div class="row content">
                <div class="col-lg-6 text-center">
                    <p>
                        Aplikasi sistem pakar yang dirancang khusus untuk mendiagnosis tingkat depresi pada masyarakat
                        kalangan usia produktif (15 - 64 tahun) merupakan solusi inovatif untuk membantu dalam penilaian dan pemahaman
                        terhadap kondisi kesehatan mental. Dengan menggunakan metode perhitungan Certainty Factor dan
                        basis pengetahuan yang dikembangkan oleh pakar di bidang psikologi, aplikasi
                        ini dapat memberikan hasil diagnosis yang akurat dan rekomendasi yang tepat.
                    </p>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <ul>
                        <li><i class="ri-check-double-line"></i> Aplikasi ini didasarkan pada pengetahuan dan
                        pengalaman para pakar di bidang psikologi.</li>
                        <li><i class="ri-check-double-line"></i> Aplikasi ini memiliki gejala-gejala khas yang
                            berkaitan dengan depresi pada masyarakat kalangan usia produktif berdasarkan pengetahuan pakar.
                        </li>
                        <li><i class="ri-check-double-line"></i> Aplikasi sistem pakar ini menggunakan metode
                            Certainty Factor (CF) untuk menghitung tingkat keyakinan terhadap diagnosis yang
                        diberikan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Informasi Section ======= -->
    <section id="informasi" class="services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Informasi</h2>
                <p>Dalam Ilmu kesehatan khususnya penyakit depresi memiliki beberapa tingkatan, dan masing-masing
                    tingkatan tersebut mempunyai level waspada. berikut adalah tingkatan depresi yang terdapat pada
                aplikasi ini.</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                data-aos-delay="200">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-plus-medical" style="color: #54DA5D;"></i></div>
                    <h4><a href="#informasi">Mild Major Depressive Disorder </a></h4>
                    <p>tingkat depresi mayor yang memiliki gejala yang lebih ringan dibandingkan dengan tingkat yang lebih parah. Pada tingkat ini, gejala depresi biasanya memengaruhi kehidupan sehari-hari, namun individu masih dapat menjalani aktivitas sehari-hari dengan tingkat fungsionalitas yang relatif normal.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
            data-aos-delay="300">
            <div class="icon-box">
                <div class="icon"><i class="bx bx bx-plus-medical" style="color: #E6E44C;"></i></div>
                <h4><a href="#informasi">Moderate Major Depressive Disorder</a></h4>
                <p>tingkat depresi mayor yang memiliki gejala sedang. Pada tingkat ini, gejala depresi dapat lebih mengganggu kehidupan sehari-hari individu dan mempengaruhi fungsionalitas mereka dalam berbagai bidang, seperti pekerjaan, hubungan, atau aktivitas sosial.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
        data-aos-delay="400">
        <div class="icon-box">
            <div class="icon"><i class="bx bx-plus-medical" style="color: #DD3A3A;"></i></div>
            <h4><a href="#informasi">Severe Major Depressive Disorder</a></h4>
            <p>tingkat depresi mayor yang memiliki gejala yang sangat parah dan mengganggu. Pada tingkat ini, gejala depresi sangat menghambat individu dalam menjalani kehidupan sehari-hari. Mereka mungkin mengalami kesulitan dalam menjalankan tugas-tugas rutin, berinteraksi dengan orang lain, atau bahkan memiliki pemikiran atau perilaku yang berpotensi merugikan diri sendiri.</p>
        </div>
    </div>
</div>

<div class="row bagian-dua">
    <div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
    data-aos-delay="400">
    <div class="icon-box">
        <div class="icon"><i class="bx bx-plus-medical" style="color: #54DA5D;"></i></div>
        <h4><a href="#informasi">Mild Persistent Depressive Disorder (Dysthymia)</a></h4>
        <p>tingkat yang lebih ringan dari Dysthymia. Pada tingkat ini, gejala depresi ada dan terjadi secara terus-menerus selama setidaknya dua tahun, tetapi gejalanya cenderung lebih ringan dan dapat dikelola dengan lebih baik dibandingkan dengan tingkat yang lebih parah.</p>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
data-aos-delay="400">
<div class="icon-box">
    <div class="icon"><i class="bx bx-plus-medical" style="color: #E6E44C;"></i></div>
    <h4><a href="#informasi">Moderate Persistent Depressive Disorder (Dysthymia) </a></h4>
    <p>tingkat Dysthymia yang memiliki gejala sedang. Pada tingkat ini, gejala depresi dapat lebih mengganggu dan mempengaruhi kehidupan sehari-hari individu dengan lebih signifikan.</p>
</div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
data-aos-delay="400">
<div class="icon-box">
    <div class="icon"><i class="bx bx-plus-medical" style="color: #DD3A3A;"></i></div>
    <h4><a href="#informasi">Severe Persistent Depressive Disorder (Dysthymia)</a></h4>
    <p>tingkat Dysthymia yang memiliki gejala yang sangat parah dan menghambat. Pada tingkat ini, gejala depresi yang berat dan terus-menerus mengganggu fungsionalitas individu secara signifikan dalam berbagai aspek kehidupan, termasuk pekerjaan, hubungan, dan kesejahteraan umum.</p>
</div>
</div>
</div>
</div>
</section>
<!-- End Informasi Section -->

<!-- ======= FAQ Section ======= -->
<section id="faq" class="faq section-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>FAQ</h2>
            <p>Beberapa pertanyaan yang sering diajukan oleh pasien atau user yang akan melakukan diagnosis terkait
            tingkat depresi yang dialami.</p>
        </div>

        <div class="faq-list">
            <ul>
                <?php foreach ($faq as $row) : ?>
                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                        data-bs-target="#faq-list-<?= $row->id_faq ?>"> <?= $row->pertanyaan ?> <i
                        class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-<?= $row->id_faq ?>" class="collapse" data-bs-parent=".faq-list">
                            <p style="margin-left: 30px;""><?= $row->jawaban ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</section>
<!-- End FAQ Section -->

<!-- ======= Contact Section ======= -->
<!-- <section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Kontak</h2>
      <p>Informasi kontak universitas muhammadiyah cirebon yang dapat dihubungi. Dan berikan juga kritik dan saran anda terhadap Aplikasi MentalCare.</p>
    </div>

    <div class="row">

        <div class="col-lg-5 d-flex align-items-stretch">
        <div class="info">
          <div class="address">
            <i class="bi bi-geo-alt"></i>
            <h4>Lokasi:</h4>
            <p>Jalan Watubelah, Kab Cirebon, Jawa Barat</p>
        </div>

        <div class="email">
            <i class="bi bi-envelope"></i>
            <h4>Email:</h4>
            <p>mochsyarifhidayat24@gmail.com</p>
        </div>

        <div class="phone">
            <i class="bi bi-phone"></i>
            <h4>Call:</h4>
            <p>+628988658xxx</p>
        </div>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31697.83756220836!2d108.45726361083985!3d-6.741812499999993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1e22287a46eb%3A0x354ab97c26d6f778!2sGedung%20Fakultas%20FISIP%20%26%20TEKNIK%20Universitas%20Muhammadiyah%20Cirebon!5e0!3m2!1sen!2sid!4v1691069568198!5m2!1sen!2sid" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
    </div>

</div>

        <div class="toast-header">
            <img src="<?= base_url('img/logo.png') ?>" width="17px" height="17px" class="rounded me-2" alt="...">
            <strong class="me-auto">Jumlah Data Rekam Diagnosis</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-center">
            <h3 color="#0A2342" id="dataCount"><?= count($laporan) ?></h3>Diagnosis sudah dilakukan oleh berbagai pengguna
        </div>
    </div>
</div>

<script>
    const toastTrigger = document.getElementById('liveToastBtn');
    const toastLiveExample = document.getElementById('liveToast');
    const dataCountElement = document.getElementById('dataCount');
    const maxDataCount = <?php echo count($laporan); ?>;
    const animationDuration = 5000; // Durasi animasi dalam milidetik (ms)
    const updateInterval = 100; // Interval waktu antara dua perubahan nilai (ms)

    if (toastTrigger) {
        toastTrigger.addEventListener('click', () => {
            const toast = new bootstrap.Toast(toastLiveExample);
            toast.show();
            animateDataCount();
        });
    }

    function animateDataCount() {
        let currentValue = 0;
        const increment = Math.ceil(maxDataCount / (animationDuration / updateInterval));

        const interval = setInterval(() => {
            currentValue += increment;
            if (currentValue >= maxDataCount) {
                currentValue = maxDataCount;
                clearInterval(interval);
            }
            dataCountElement.textContent = currentValue;
        }, updateInterval);
    }
</script>

</main><!-- End #main -->

<?= $this->endSection() ?>