<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
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
                        <th width="200px">Nomor Registrasi</th>
                        <td width="15px">:</td>
                        <td id="noReg"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td id="nama"></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>:</td>
                        <td id="jenisKelamin"></td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>:</td>
                        <td id="agama"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>:</td>
                        <td id="tanggalLahir"></td>
                    </tr>
                    <!-- <tr>
                        <th>Umur</th>
                        <td>:</td>
                        <td><span id="umur"></span> Tahun</td>
                    </tr> -->
                    <tr>
                        <th>Kewarganegaraan</th>
                        <td>:</td>
                        <td id="kewarganegaraan"></td>
                    </tr>
                    <tr>
                        <th>Blok Kamar</th>
                        <td>:</td>
                        <td id="blokKamar"></td>
                    </tr>
                    <tr>
                        <th>Undang-undang</th>
                        <td>:</td>
                        <td id="uu"></td>
                    </tr>
                    <tr>
                        <th>Pasal Utama</th>
                        <td>:</td>
                        <td id="pasalUtama"></td>
                    </tr>
                    <tr>
                        <th>Lama Pidana</th>
                        <td>:</td>
                        <td><span id="lamaPidanaTahun"></span> Tahun <span id="lamaPidanaBulan"></span> Bulan <span id="lamaPidanaHari"></span> Hari</td>
                    </tr>
                    <tr>
                        <th>Jenis Kejahatan</th>
                        <td>:</td>
                        <td id="jenisKejahatan"></td>
                    </tr>
                    <tr>
                        <th>Jenis Kejahatan Narkotika</th>
                        <td>:</td>
                        <td id="jenisKejahatanNarkotika"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Ekspirasi</th>
                        <td>:</td>
                        <td id="tanggalEkspirasi"></td>
                    </tr>
                    <tr>
                        <th>UPT Asal</th>
                        <td>:</td>
                        <td id="uptAsal"></td>
                    </tr>
                    <tr>
                        <th>Status Kerja Wali</th>
                        <td>:</td>
                        <td id="statusKerjaWali"></td>
                    </tr>
                    <tr>
                        <th>Pas Foto</th>
                        <td>:</td>
                        <td id="pasFoto"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="importModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Napi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5 theme-form">
                        <input class="form-control" type="file" id="fileImport" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <button class="btn btn-sm btn-success pull-right mr-1" id="btnLihat">
                            <span class="d-none d-md-block"><i id="lihat" class="fa fa-eye"></i> Lihat Data</span>
                            <i class="d-block d-sm-none fa fa-eye"></i>
                        </button>
                        <a href="<?= base_url('template/Template_Napi.xlsx') ?>" class="btn btn-sm btn-primary pull-right" id="btnTemplate">
                            <span class="d-none d-md-block"><i class="fa fa-download"></i> Download Template</span>
                            <i class="d-block d-sm-none fa fa-download"></i>
                        </a>
                    </div>
                </div>
                <div class="form-group mb-3 pt-3">
                    <button class="btn btn-sm colorInvalid"></button> Terdapat isian yang tidak valid
                </div>
                <div id="viewTableImport" class="table-responsive">
                    <hr>
                    <table class="display" id="datatableImport" width="100%">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">No Registrasi</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Kewarganegaraan</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div id="viewImport">
                    <div class="progress mt-3">
                        <div class="progress-bar-animated progress-bar-striped bg-success text-center" id="progressImport" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="progressView">0%</span></div>
                    </div>
                    <span class="d-none d-md-block">
                        <span id="detailImport"></span>
                        <span class="pull-right">
                            <span class="badge badge-light-success">Berhasil</span> : <span class="berhasil"></span> &nbsp;
                            <span class="badge badge-light-danger">Gagal</span> : <span class="gagal"></span> &nbsp;
                            <span class="badge badge-light-primary">Total Data</span> : <span class="totalData"></span>
                        </span>
                    </span>
                    <span class="text-center d-block d-sm-none d-xs-none">
                        <span class="badge badge-light-success">Berhasil</span> : <span class="berhasil"></span> &nbsp;
                        <span class="badge badge-light-danger">Gagal</span> : <span class="gagal"></span> &nbsp;
                        <span class="badge badge-light-primary">Total Data</span> : <span class="totalData"></span>
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm grey btn-outline-primary" id="btnImport">Import Data</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalInfoGagal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Infomasi Gagal Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5><b><span id="detailData"></span></b></h5>
                <hr>
                <span id="detailGagal"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>