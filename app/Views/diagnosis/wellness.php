<?= $this->extend('layout/homepage') ?>
<?= $this->section('contentHome') ?>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
	<div class="container d-flex align-items-center">

		<h5 class="logo me-auto" style="font-size: 20px;">
			<img src="<?= base_url('img/logo.png') ?>" class="mb-1" style="height: 28px; width: 28px;" alt="">
            <a href="#home"><span style="color: #D56062">Mental</span><span style="color: #A9A9A9">Care</span> </a>
		</h5>
		<!-- Uncomment below if you prefer to use an image logo -->
		<!-- <a href="index.html" class="logo me-auto"><img src="public/landing/assets/img/logo.png" alt="" class="img-fluid"></a> -->

		<nav id="navbar" class="navbar">
			<ul>
				<li><a class="nav-link scrollto active" href="#hero">Home</a></li>
				<li><a class="nav-link scrollto" href="<?= base_url('user/cek_diagnosis') ?>">Cek Diagnosis Kembali</a></li>
				<li><a class="nav-link scrollto" href="<?= base_url('logout') ?>">Logout</a></li>
			</ul>
			<i class="bi bi-list mobile-nav-toggle"></i>
		</nav><!-- .navbar -->

	</div>
</header>
<!-- End Header -->


<!-- ======= Wellness Section ======= -->
<section id="hero" class="d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                <h1>Program Wellness & Preventif</h1>
                <h2 class="mb-4">Selamat! Anda tidak menunjukkan gejala depresi saat ini. Mari jaga kesehatan mental Anda dengan program preventif kami.</h2>
                <div class="d-flex justify-content-center justify-content-lg-start mt-3">
                    <a href="#wellness" class="btn-get-started scrollto">Lihat Program Wellness <i class="fas fa-chevron-down"></i></a>
                    <!-- <a href="#" onclick="history.back('/')" class="btn-watch-video ms-4"><i class="fas fa-chevron-left"></i> Kembali</a> -->
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="<?= base_url('img/wellness.png') ?>" class="img-fluid animated" alt="Wellness Image">
            </div>
        </div>
    </div>
</section>

<!-- ======= Wellness Programs Section ======= -->
<section id="wellness" class="services section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Program Preventif & Wellness</h2>
            <p>Berikut berbagai program yang dapat membantu Anda menjaga kesehatan mental yang optimal</p>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box">
                    <div class="icon"><i class="fas fa-brain"></i></div>
                    <h4>Asesmen Faktor Risiko</h4>
                    <ul class="mt-3">
                        <li><strong>Evaluasi Riwayat Keluarga</strong>
                            <p class="small text-muted">Mengenali riwayat keluarga dengan gangguan mental untuk meningkatkan kesadaran terhadap faktor genetik.</p>
                        </li>
                        <li><strong>Penilaian Tingkat Stres</strong>
                            <p class="small text-muted">Mengukur dan memahami tingkat stres Anda untuk mencegah berkembangnya masalah yang lebih serius.</p>
                        </li>
                        <li><strong>Analisis Pola Hidup</strong>
                            <p class="small text-muted">Evaluasi kebiasaan tidur, olahraga, dan pola makan untuk menjaga keseimbangan mental dan fisik.</p>
                        </li>
                        <li><strong>Identifikasi Trigger Potensial</strong>
                            <p class="small text-muted">Membantu mengenali dan mengelola pemicu stres atau ketidaknyamanan emosional sejak dini.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box">
                    <div class="icon"><i class="fas fa-heart"></i></div>
                    <h4>Program Manajemen Stres</h4>
                    <ul class="mt-3">
                        <li><strong>Teknik Relaksasi Progresif</strong>
                            <p class="small text-muted">Metode sistematis untuk mengendurkan otot dan mengurangi ketegangan mental secara bertahap.</p>
                        </li>
                        <li><strong>Breathing Exercise</strong>
                            <p class="small text-muted">Latihan pernapasan yang membantu meningkatkan fokus dan ketenangan dalam aktivitas sehari-hari.</p>
                        </li>
                        <li><strong>Time Management</strong>
                            <p class="small text-muted">Strategi pengelolaan waktu efektif untuk menjaga produktivitas tanpa menimbulkan beban berlebih.</p>
                        </li>
                        <li><strong>Cognitive Restructuring</strong>
                            <p class="small text-muted">Teknik untuk mengubah pola pikir negatif menjadi lebih positif dan konstruktif.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box">
                    <div class="icon"><i class="fas fa-peace"></i></div>
                    <h4>Pelatihan Mindfulness</h4>
                    <ul class="mt-3">
                        <li><strong>Meditasi Harian</strong>
                            <p class="small text-muted">Praktik meditasi sederhana untuk meningkatkan fokus dan menciptakan ketenangan pikiran.</p>
                        </li>
                        <li><strong>Body Scanning</strong>
                            <p class="small text-muted">Teknik untuk meningkatkan kesadaran tubuh, membantu relaksasi dan koneksi mind-body.</p>
                        </li>
                        <li><strong>Mindful Eating</strong>
                            <p class="small text-muted">Pendekatan makan dengan penuh kesadaran untuk membangun hubungan sehat dengan makanan.</p>
                        </li>
                        <li><strong>Walking Meditation</strong>
                            <p class="small text-muted">Praktik meditasi sambil berjalan untuk mengurangi stres dan memperbaiki suasana hati.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="lead">Jaga kesehatan mental Anda dengan menerapkan program-program di atas secara rutin.</p>
            <p>Jika Anda membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi profesional kesehatan mental.</p>
            <div class="alert alert-info mt-4">
                <h5><i class="fas fa-info-circle"></i> Penting untuk Diingat:</h5>
                <p>Program-program ini dirancang sebagai tindakan preventif dan wellness. Jika Anda mengalami gejala yang mengganggu, segera hubungi profesional kesehatan mental.</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
