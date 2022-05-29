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
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">harga</label>
                        <input type="text" name="harga" id="harga" class="form-control readonly-background" placeholder="harga">
                        <p class="text-danger" id="er_harga"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">kode</label>
                        <input type="text" name="kode" id="kode" class="form-control readonly-background" placeholder="kode">
                        <p class="text-danger" id="er_kode"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">kodeSuplier</label>
                        <input type="text" name="kodeSuplier" id="kodeSuplier" class="form-control readonly-background" placeholder="kodeSuplier">
                        <p class="text-danger" id="er_kodeSuplier"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">poin</label>
                        <input type="text" name="poin" id="poin" class="form-control readonly-background" placeholder="poin">
                        <p class="text-danger" id="er_poin"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">jamOperasional</label>
                        <input type="text" name="jamOperasional" id="jamOperasional" class="form-control readonly-background" placeholder="jamOperasional">
                        <p class="text-danger" id="er_jamOperasional"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">jenis</label>
                        <input type="text" name="jenis" id="jenis" class="form-control readonly-background" placeholder="jenis">
                        <p class="text-danger" id="er_jenis"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">kategori</label>
                        <input type="text" name="kategoriId" id="kategoriId" class="form-control readonly-background" placeholder="kategoriId">
                        <p class="text-danger" id="er_kategoriId"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Deskripsi</label>
                        <textarea id="editor1" class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"></textarea>
                        <p class="text-danger" id="er_deskripsi"></p>
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