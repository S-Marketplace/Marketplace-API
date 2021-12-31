<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="">
                    <tr>
                        <th width="150px">No Antrian</th>
                        <td width="15px">:</td>
                        <td id="noAntrianModal"></td>
                    </tr>
                    <tr>
                        <th>Nama Narapidana</th>
                        <td>:</td>
                        <td id="namaNarapidanaModal"></td>
                    </tr>
                    <tr>
                        <th>Nama Pengunjung</th>
                        <td>:</td>
                        <td id="namaPengunjungModal"></td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>:</td>
                        <td id="jenisModal"></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>:</td>
                        <td id="keterangan"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <div class="form-group mb-3">
                        <label for="">NIK</label>
                        <input type="text" name="nik" class="form-control" placeholder="NIK">
                        <p class="block-tag text-left" id="er_nik"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Pengunjung</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Pengunjung">
                        <p class="block-tag text-left" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama WBP</label>
                        <input type="text" name="namaWbp" class="form-control" placeholder="Nama WBP">
                        <p class="block-tag text-left" id="er_namaWbp"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Ayah Kandung</label>
                        <input type="text" name="namaAyah" class="form-control" placeholder="Nama Ayah Kandung">
                        <p class="block-tag text-left" id="er_namaAyah"></p>
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Jenis</label>
                        <div>
                            <input type="radio" name="jenisAntrian" value="Kunjungan">
                            <label>Kunjungan</label>
                        </div>
                        <div>
                            <input type="radio" name="jenisAntrian" value="Penitipan">
                            <label>Penitipan</label>
                        </div>
                        <p class="block-tag text-left" id=""></p>
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