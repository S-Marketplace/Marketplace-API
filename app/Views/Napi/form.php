<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3><?= $aksi ?> Narapidana</h3>
                </div>
                <div class="col-6">
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <form id="form">
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="col-form-label">Nomor Regitrasi</label>
                                <input class="form-control" type="text" name="noReg" placeholder="Nomor Regitrasi" value="<?= @$data['noReg'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_noReg"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Nama</label>
                                <input class="form-control" type="text" name="nama" placeholder="Nama" value="<?= @$data['nama'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_nama"></p>
                            </div>
                            <div class="mb-0">
                                <label class="col-form-label">Jenis Kelamin</label>
                                <ul class="list-unstyled" style="margin-bottom: 0px">
                                    <li class="d-inline-block mr-1">
                                        <fieldset>
                                            <div class="vs-radio-con">
                                                <input type="radio" name="jenisKelamin" value="L" <?= @$data['jenisKelamin'] == 'L' ? 'checked' : '' ?>>
                                                <span class="vs-radio">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Laki-laki</span>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li class="d-inline-block ml-1">
                                        <fieldset>
                                            <div class="vs-radio-con">
                                                <input type="radio" name="jenisKelamin" value="P" <?= @$data['jenisKelamin'] == 'P' ? 'checked' : '' ?>>
                                                <span class="vs-radio">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Perempuan</span>
                                            </div>
                                        </fieldset>
                                    </li>
                                </ul>
                                <p class="block-tag text-left badge badge-danger" id="er_jenisKelamin"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Agama</label>
                                <?= form_dropdown('agama', $agama, @$data['agama'], ['class' => 'form-control agama select2', 'id' => 'agama']); ?>
                                <p class="block-tag text-left badge badge-danger" id="er_nama"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Tanggal Lahir</label>
                                <input class="form-control readonly-background" type="text" id="tanggalLahir" name="tanggalLahir" placeholder="Tanggal Lahir" value="<?= @$data['tanggalLahir'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_tanggalLahir"></p>
                            </div>
                            <!-- <div class="mb-2">
                                <label class="col-form-label">Umur</label>
                                <input class="form-control" type="text" name="umur" placeholder="Umur" value="?= @$data['umur'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_umur"></p>
                            </div> -->
                            <div class="mb-2">
                                <label class="col-form-label">Kewarganegaraan</label>
                                <?= form_dropdown('kewarganegaraan', $kewarganegaraan, @$data['kewarganegaraan'], ['class' => 'form-control kewarganegaraan select2', 'id' => 'kewarganegaraan']); ?>
                                <p class="block-tag text-left badge badge-danger" id="er_nama"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Blok Kamar</label>
                                <input class="form-control" type="text" name="blokKamar" placeholder="Blok Kamar" value="<?= @$data['blokKamar'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_blokKamar"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Undang-undang</label>
                                <input class="form-control" type="text" name="uu" placeholder="Undang-undang" value="<?= @$data['uu'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_uu"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Pasal Utama</label>
                                <input class="form-control" type="text" name="pasalUtama" placeholder="Pasal Utama" value="<?= @$data['pasalUtama'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_pasalUtama"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Lama Pidana (Tahun/Bulan/Hari)</label>
                                <div class="row">
                                    <div class="col-4">
                                        <input class="form-control" type="text" name="lamaPidanaTahun" placeholder="Lama Pidana (Tahun)" value="<?= @$data['lamaPidanaTahun'] ?>">
                                        <p class="block-tag text-left badge badge-danger" id="er_lamaPidanaTahun"></p>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control" type="text" name="lamaPidanaBulan" placeholder="Lama Pidana (Bulan)" value="<?= @$data['lamaPidanaBulan'] ?>">
                                        <p class="block-tag text-left badge badge-danger" id="er_lamaPidanaBulan"></p>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control" type="text" name="lamaPidanaHari" placeholder="Lama Pidana (Hari)" value="<?= @$data['lamaPidanaHari'] ?>">
                                        <p class="block-tag text-left badge badge-danger" id="er_lamaPidanaHari"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Jenis Kejahatan</label>
                                <input class="form-control" type="text" name="jenisKejahatan" placeholder="Jenis Kejahatan" value="<?= @$data['jenisKejahatan'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_jenisKejahatan"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Jenis Kejahatan Narkotika</label>
                                <input class="form-control" type="text" name="jenisKejahatanNarkotika" placeholder="Jenis Kejahatan Narkotika" value="<?= @$data['jenisKejahatanNarkotika'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_jenisKejahatanNarkotika"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Tanggal Ekspirasi</label>
                                <input class="form-control readonly-background" type="text" id="tanggalEkspirasi" name="tanggalEkspirasi" placeholder="Tanggal Ekspirasi" value="<?= @$data['tanggalEkspirasi'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_tanggalEkspirasi"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">UPT Asal</label>
                                <input class="form-control" type="text" name="uptAsal" placeholder="UPT Asal" value="<?= @$data['uptAsal'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_uptAsal"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Status Kerja Wali</label>
                                <input class="form-control" type="text" name="statusKerjaWali" placeholder="Status Kerja Wali" value="<?= @$data['statusKerjaWali'] ?>">
                                <p class="block-tag text-left badge badge-danger" id="er_statusKerjaWali"></p>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label">Pas Foto</label>
                                <input class="form-control" type="file" name="pasFoto" placeholder="Pas Foto">
                                <p class="block-tag text-left badge badge-danger" id="er_pasFoto"></p>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" id="btnSimpan" class="btn btn-primary pull-right mb-4">Simpan</button>
                            <a href="<?= base_url('Napi') ?>" class="btn btn-secondary pull-right mr-1">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<style>
    .readonly-background[readonly] {
        background-color: white !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    $(document).ready(function() {

        tanggal = flatpickr('#tanggalEkspirasi', {
            locale: "id",
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
        });

        tanggalLahir = flatpickr('#tanggalLahir', {
            locale: "id",
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
        });

        if ('<?= $aksi ?>' == 'Edit') {
            tanggal.setDate('<?= @$data['tanggalEkspirasi'] ?>');
            tanggalLahir.setDate('<?= @$data['tanggalLahir'] ?>');

            if ('<?= @$data['pasFoto'] ?>' != '') {
                krajeeConfig('[name="pasFoto"]', {
                    url: `<?= base_url('File/get/napi') . '/' . @$data['pasFoto'] ?>`,
                    filename: '<?= @$data['pasFoto'] ?>',
                    caption: 'Pas Foto',
                    action: true,
                    type: 'image',
                });
            } else {
                krajeeConfig('[name="pasFoto"]', {
                    type: 'image'
                });
            }
        } else {
            krajeeConfig('[name="pasFoto"]', {
                type: 'image'
            });
        }


        select2config("agama", "Agama");
        select2config("kewarganegaraan", "Kewarganegaraan");

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('id', '<?= $id ?>');

            $.ajax({
                type: "POST",
                url: `<?= base_url('Napi') ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success').then((result) => {
                            if (result.value) {
                                window.location = '<?= base_url('Napi') ?>';
                            }
                        });

                    } else {
                        $.each(res.message, function(index, val) {
                            $('#er_' + index).html(val);
                        });
                    }
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $("[id^='er_']").html('');
                    $('#btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnSimpan').removeAttr('disabled').html('Simpan');
                }
            });
        });

        /**
         * clearFaltPicker
         * 
         * set inputan flatpickr menjadi null
         *
         * @return void
         */
        function clearFlatPicker() {
            $('#tanggalEkspirasi')[0]._flatpickr.clear();
            $('#tanggalLahir')[0]._flatpickr.clear();
        }
    });
</script>
<?= $this->endSection(); ?>