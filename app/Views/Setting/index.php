<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Setting</h3>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html" data-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a></li>
                        <li class="breadcrumb-item">Icons</li>
                        <li class="breadcrumb-item active">Feather Icons</li>
                    </ol> -->
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
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">
                                            Antrian Kunjungan
                                            <span class="font-medium-2">
                                                <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="Menonaktifkan/Mengaktifkan Antrian Kunjungan"></i>
                                            </span>
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="kunjungan" <?= $antrian_kunjungan == 1 ? 'checked' : '' ?>>
                                                <label class="custom-control-label" id="label_kunjungan" for="kunjungan"><?= $antrian_kunjungan == 1 ? 'Aktif' : 'Tidak Aktif' ?></label>
                                            </div>
                                            <input type="hidden" name="antrian_kunjungan" value="<?= $antrian_kunjungan ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">
                                            Antrian Penitipan
                                            <span class="font-medium-2">
                                                <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="Menonaktifkan/Mengaktifkan Antrian Penitipan"></i>
                                            </span>
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="penitipan" <?= $antrian_penitipan == 1 ? 'checked' : '' ?>>
                                                <label class="custom-control-label" id="label_penitipan" for="penitipan"><?= $antrian_penitipan == 1 ? 'Aktif' : 'Tidak Aktif' ?></label>
                                            </div>
                                            <input type="hidden" name="antrian_penitipan" value="<?= $antrian_penitipan ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">
                                            Image Background
                                            <span class="font-medium-2">
                                                <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="Menonaktifkan/Mengaktifkan Antrian Penitipan"></i>
                                            </span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="foto_background" placeholder="Image Background">
                                            <p class="block-tag text-left" id="er_foto_background"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">
                                            Image Header
                                            <span class="font-medium-2">
                                                <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="Menonaktifkan/Mengaktifkan Antrian Penitipan"></i>
                                            </span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="foto_header" placeholder="Image Header">
                                            <p class="block-tag text-left" id="er_foto_header"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary pull-right mb-4" id="btnSimpan">Simpan</button>
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
    var dataRow;
    var foto_background = '<?= $foto_background ?>';
    var foto_header = '<?= $foto_header ?>';
    $(document).ready(function() {

        if (foto_background != '') {
            krajeeConfig('[name="foto_background"]', {
                url: `<?= base_url('File/get/setting') ?>/${foto_background}`,
                filename: foto_background,
                caption: 'Image Background',
                action: true,
                type: 'image',
            });
        } else {
            krajeeConfig('[name="foto_background"]', {
                type: 'image'
            });
        }

        if (foto_header != '') {
            krajeeConfig('[name="foto_header"]', {
                url: `<?= base_url('File/get/setting') ?>/${foto_header}`,
                filename: foto_header,
                caption: 'Image Header',
                action: true,
                type: 'image',
            });
        } else {
            krajeeConfig('[name="foto_header"]', {
                type: 'image'
            });
        }

        $('#penitipan').on('change.bootstrapSwitch', function(e) {
            let val = 0;
            let label = 'Tidak Aktif';
            if (e.target.checked) {
                val = 1
                label = 'Aktif';
            }
            $('[name="antrian_penitipan"]').val(val);
            $('#label_penitipan').html(label);
        });

        $('#kunjungan').on('change.bootstrapSwitch', function(e) {
            let val = 0;
            let label = 'Tidak Aktif';
            if (e.target.checked) {
                val = 1
                label = 'Aktif';
            }
            $('[name="antrian_kunjungan"]').val(val);
            $('#label_kunjungan').html(label);
        });

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
                    } else {
                        let start = `<small class="badge badge-danger">`;
                        let end = `</small>`;
                        $.each(res.message, function(index, val) {
                            $('#er_' + index).html(start + val + end);
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

        // $('#btnSimpan').click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         type: "POST",
        //         url: `?= current_url() ?>/simpan`,
        //         data: $("#form").serialize(),
        //         dataType: "JSON",
        //         success: function(res) {
        //             Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
        //         },
        //         fail: function(xhr) {
        //             Swal.fire('Error', "Server gagal merespon", 'error');
        //         },
        //         beforeSend: function() {
        //             $('#btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
        //         },
        //         complete: function(res) {
        //             $('#btnSimpan').removeAttr('disabled').html('Simpan');
        //         }
        //     });
        // });
    });
</script>
<?= $this->endSection(); ?>