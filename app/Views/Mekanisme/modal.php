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
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control readonly-background" placeholder="Kode">
                        <p class="block-tag text-left badge badge-danger" id="er_kode"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="block-tag text-left badge badge-danger" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Foto</label>
                        <input class="form-control" type="file" name="foto" placeholder="Foto">
                        <p class="block-tag text-left badge badge-danger" id="er_foto"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>