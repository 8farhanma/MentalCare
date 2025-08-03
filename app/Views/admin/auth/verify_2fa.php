<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="bg-login" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0a2342 0%, #D56062 150%);
        z-index: -1;
    "></div>
<div class="d-flex align-items-center p-4" style="position: absolute; top: 0; left: 0;">
        <img src="<?= base_url('img/logo.png') ?>" width="40px" height="40px" alt="Logo">
        <a style="text-transform: none; text-decoration: none; margin-left: 10px; font-size: 24px; font-weight: bold;">
            <span style="color: #D56062">Mental</span><span style="color: #A9A9A9">Care</span>
        </a>
</div>
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height:100vh">
    <h2 class="text-white mb-4" style="font-family:'Jost',sans-serif">Verifikasi 2-Faktor</h2>
    <?= view('components/alerts') ?>
    <div class="card p-4" style="background:rgba(255,255,255,.9)">
        <form method="post" action="<?= base_url('admin/verify-2fa') ?>">
            <?= csrf_field() ?>
            <p class="text-center mb-3" style="font-size:0.95rem;color:#555;">Silakan masukkan 6 digit kode yang muncul di aplikasi autentikator Anda untuk menyelesaikan proses login.</p>
            <div class="form-group mb-3 d-flex justify-content-center gap-2 flex-wrap">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric" pattern="[0-9]*" required>
                <?php endfor; ?>
                <input type="hidden" name="code" id="code">
            </div>
            <button class="btn w-100" style="background-color:#D56062;border-color:#D56062;color:#fff;box-shadow:0 4px 6px rgba(0,0,0,.15);transition:all .2s;">Verifikasi</button>
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
    if(inputs.length){
        inputs[0].focus();
    }
    inputs.forEach((input, idx) => {
        input.addEventListener('input', function(){
            this.value = this.value.replace(/[^0-9]/g,'');
            if(this.value && idx < inputs.length -1){
                inputs[idx+1].focus();
            }
            hidden.value = Array.from(inputs).map(i=>i.value).join('');
        });
        input.addEventListener('keydown', function(e){
            if(e.key==='Backspace' && !this.value && idx>0){
                inputs[idx-1].focus();
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
