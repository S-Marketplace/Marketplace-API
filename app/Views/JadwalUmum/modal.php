<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-group mb-3">
                        <label for="">Hari</label>
                        <?= form_dropdown('hari', $hari, '', ['class' => 'form-control hari select2', 'id' => 'hari']); ?>
                        <p class="block-tag text-left" id="er_hari"></p>
                    </div>
                    <div class="form-group mb-3" id="c-jamMulai">
                        <label for="">Jam Mulai</label>
                        <input type="text" name="jamMulai" id="jamMulai" class="form-control readonly-background" placeholder="Jam Mulai">
                        <p class="block-tag text-left" id="er_jamMulai"></p>
                    </div>
                    <div class="form-group mb-0" id="c-jamSelesai">
                        <label for="">Jam Selesai</label>
                        <input type="text" name="jamSelesai" id="jamSelesai" class="form-control readonly-background" placeholder="Jam Selesai">
                        <p class="block-tag text-left" id="er_jamSelesai"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>