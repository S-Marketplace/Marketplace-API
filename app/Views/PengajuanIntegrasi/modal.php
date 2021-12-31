<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <th width="200px">NIK</th>
                        <td width="15px">:</td>
                        <td class="nik"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td class="nama"></td>
                    </tr>
                    <tr>
                        <th>Nama Napi</th>
                        <td>:</td>
                        <td class="namaNapi"></td>
                    </tr>
                    <tr>
                        <th>Hubungan dengan Napi</th>
                        <td>:</td>
                        <td class="hubungan"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>:</td>
                        <td class="tanggal"></td>
                    </tr>
                    <tr>
                        <th>File Penjamin Integrasi</th>
                        <td>:</td>
                        <td id="penjaminIntegrasi"></td>
                    </tr>
                    <tr>
                        <th>File Pernyataan Integrasi</th>
                        <td>:</td>
                        <td id="pernyataanIntegrasi"></td>
                    </tr>
                    <tr>
                        <th>KTP Penjamin</th>
                        <td>:</td>
                        <td id="ktpPenjamin"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td class="statusPengajuan"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="">
                    <tr>
                        <th width="200px">NIK</th>
                        <td width="15px">:</td>
                        <td class="nik"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td class="nama"></td>
                    </tr>
                    <tr>
                        <th>Nama Napi</th>
                        <td>:</td>
                        <td class="namaNapi"></td>
                    </tr>
                    <tr>
                        <th>Hubungan dengan Napi</th>
                        <td>:</td>
                        <td class="hubungan"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>:</td>
                        <td class="tanggal"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td>
                            <?= form_dropdown('status', $status, '', ['class' => 'form-control status select2', 'id' => 'status']); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>