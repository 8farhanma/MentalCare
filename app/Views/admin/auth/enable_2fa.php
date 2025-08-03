<?php $title = 'Aktifkan 2FA'; ?>
<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<div class="container d-flex flex-column align-items-center" style="padding-top:80px;">
    <h2 class="h3 mb-4 text-gray-800">Aktifkan 2-Faktor Autentikasi</h2>
    <?= view('components/alerts') ?>
    <div class="card p-4" style="background:rgba(255,255,255,.9)">
        <p>Pindai QR code di bawah menggunakan Google Authenticator / Authy, lalu masukkan 6-digit kode.</p>
        <div class="text-center mb-3">
            <img src="<?= $qr ?>" alt="QR Code">
        </div>
        <form method="post" action="<?= base_url('admin/enable-2fa') ?>">
            <?= csrf_field() ?>
                        <p class="text-center" style="font-size:0.95rem;color:#555;">Setelah memindai QR, masukkan 6 digit kode yang muncul di aplikasi autentikator Anda.</p>
            <div class="form-group mb-3 d-flex justify-content-center gap-2 flex-wrap">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric" pattern="[0-9]*" required>
                <?php endfor; ?>
                <input type="hidden" name="code" id="code">
            </div>
            <button class="btn w-100" style="background-color:#D56062;border-color:#D56062;color:#fff;box-shadow:0 4px 6px rgba(0,0,0,.15);transition:all .2s;">Aktifkan</button>
        </form>
    </div>
</div>
<style>
    .otp-input{
        width:60px;
        height:60px;
        font-size:24px;
        text-align:center;
        border-radius:8px;
    }
    .otp-input:focus{
        box-shadow:0 0 5px rgba(213,96,98,.8);
        border-color:#D56062;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const inputs = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('code');
    if(inputs.length){inputs[0].focus();}
    inputs.forEach((input, idx) => {
        input.addEventListener('input', function(){
            this.value=this.value.replace(/[^0-9]/g,'');
            if(this.value && idx < inputs.length-1){inputs[idx+1].focus();}
            hidden.value = Array.from(inputs).map(i=>i.value).join('');
        });
        input.addEventListener('keydown', function(e){
            if(e.key==='Backspace' && !this.value && idx>0){inputs[idx-1].focus();}
        });
    });
});
</script>

<?= $this->endSection() ?>
