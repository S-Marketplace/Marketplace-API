<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="">Tanggal</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control readonly-background" placeholder="Tanggal">
                        <p class="block-tag text-left" id="er_tanggal"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jam Mulai</label>
                        <input type="text" name="jamMulai" id="jamMulai" class="form-control readonly-background" placeholder="Jam Mulai">
                        <p class="block-tag text-left" id="er_jamMulai"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jam Selesai</label>
                        <input type="text" name="jamSelesai" id="jamSelesai" class="form-control readonly-background" placeholder="Jam Selesai">
                        <p class="block-tag text-left" id="er_jamSelesai"></p>
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Keterangan</label>
                        <textarea id="keterangan" class="form-control" name="keterangan" placeholder="Keterangan"></textarea>
                        <p class="block-tag text-left" id="er_keterangan"></p>
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