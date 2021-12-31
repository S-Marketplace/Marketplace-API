<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3" id="c-tanggal">
                                <label for="">Periode</label>
                                <input type="text" name="tanggal" id="tanggal" class="form-control readonly-background" placeholder="Tanggal">
                                <p class="block-tag text-left" id="er_tanggal"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-kapasitas">
                                <label for="">Kapasitas</label>
                                <input type="text" name="kapasitas" id="kapasitas" class="form-control" placeholder="Kapasitas" value="800" readonly>
                                <p class="block-tag text-left" id="er_kapasitas"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananDL">
                                <label for="">AI</label>
                                <input type="text" name="tahananDL" id="tahananDL" class="form-control" placeholder="AI" value="0">
                                <p class="block-tag text-left" id="tahananDL"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananDP">
                                <label for="">AII</label>
                                <input type="text" name="tahananDP" id="tahananDP" class="form-control" placeholder="AII" value="0">
                                <p class="block-tag text-left" id="er_tahananDP"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananTD">
                                <label for="">AIII</label>
                                <input type="text" name="tahananTD" id="tahananTD" class="form-control" placeholder="AIII" value="0">
                                <p class="block-tag text-left" id="er_tahananTD"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananAL">
                                <label for="">AIV</label>
                                <input type="text" name="tahananAL" id="tahananAL" class="form-control" placeholder="AIV" value="0">
                                <p class="block-tag text-left" id="er_tahananAL"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananAP">
                                <label for="">AV</label>
                                <input type="text" name="tahananAP" id="tahananAP" class="form-control" placeholder="AV" value="0">
                                <p class="block-tag text-left" id="er_tahananAP"></p>
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananTA">
                                <label for="">Tahanan TA</label>
                                <input type="text" name="tahananTA" id="tahananTA" class="form-control" placeholder="Tahanan TA" value="0">
                                <p class="block-tag text-left" id="er_tahananTA"></p>
                            </div>
                        </div> -->
                        <!-- <div class="col-6">
                            <div class="form-group mb-0" id="c-tahananTotal">
                                <label for="">Tahanan Total</label>
                                <input type="text" name="tahananTotal" id="tahananTotal" class="form-control" placeholder="Tahanan Total" value="0">
                                <p class="block-tag text-left" id="er_tahananTotal"></p>
                            </div>
                        </div> -->
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiDL">
                                <label for="">BI</label>
                                <input type="text" name="napiDL" id="napiDL" class="form-control" placeholder="BI" value="0">
                                <p class="block-tag text-left" id="napiDL"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiDP">
                                <label for="">BIIa</label>
                                <input type="text" name="napiDP" id="napiDP" class="form-control" placeholder="BIIa" value="0">
                                <p class="block-tag text-left" id="er_napiDP"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiTD">
                                <label for="">BIIb</label>
                                <input type="text" name="napiTD" id="napiTD" class="form-control" placeholder="BIIb" value="0">
                                <p class="block-tag text-left" id="er_napiTD"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiAL">
                                <label for="">BIIIs</label>
                                <input type="text" name="napiAL" id="napiAL" class="form-control" placeholder="BIIIs" value="0">
                                <p class="block-tag text-left" id="er_napiAL"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiAP">
                                <label for="">Seumur Hidup</label>
                                <input type="text" name="napiAP" id="napiAP" class="form-control" placeholder="Seumur Hidup" value="0">
                                <p class="block-tag text-left" id="er_napiAP"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0" id="c-napiTA">
                                <label for="">Pidana Mati</label>
                                <input type="text" name="napiTA" id="napiTA" class="form-control" placeholder="Pidana Mati" value="0">
                                <p class="block-tag text-left" id="er_napiTA"></p>
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <div class="form-group mb-0" id="c-napiTotal">
                                <label for="">Napi Total</label>
                                <input type="text" name="napiTotal" id="napiTotal" class="form-control" placeholder="Napi Total" value="0">
                                <p class="block-tag text-left" id="er_napiTotal"></p>
                            </div>
                        </div> -->
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