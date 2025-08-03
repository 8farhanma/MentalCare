<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Keluar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah Anda yakin ingin mengakhiri sesi Anda? Klik "Logout" untuk melanjutkan.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                <a class="btn" style="background-color: #D56062; color: white;" href="<?= base_url ('logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>