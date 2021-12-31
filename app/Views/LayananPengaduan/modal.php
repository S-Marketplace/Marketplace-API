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
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="block-tag text-left" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3" id="c-jamMulai">
                        <label for="">Link</label>
                        <input type="text" name="link" id="link" class="form-control readonly-background" placeholder="Link">
                        <p class="block-tag text-left" id="er_link"></p>
                    </div>
                    <div class="form-group mb-3" id="c-jamMulai">
                        <label for="">Warna</label>
                        <input type="color" name="color" id="color" class="form-control readonly-background" placeholder="Color">
                        <p class="block-tag text-left" id="er_color"></p>
                    </div>
                    <div class="form-group mb-3" id="c-jamSelesai">
                        <label for="">Icon</label>
                        <input type="text" name="icon" id="icon" class="form-control readonly-background" readonly placeholder="Class Icon">
                        <br>
                        <button class="btn btn-light" type="button" id="preview"><span class="icon-preview-item text-aqua"><i class="fa fa-lg fa-battery-1"></i></span></button>
                        <p class="block-tag text-left" id="er_icon"></p>
                    </div>
                </form>
                <hr>
                <div class="form-group mb-0" id="c-jamSelesai">
                    <label for="">Cari Icon</label>
                    <div class="input-group">
                        <input id="find-icon" class="form-control" name="find-icon" placeholder="Find icons" type="text">
                        <div class="input-group-prepend">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <br>
                    <?= $this->include('LayananPengaduan/icon'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>