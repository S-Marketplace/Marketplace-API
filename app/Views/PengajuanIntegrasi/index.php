<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Pengajuan Integrasi</h3>
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
                    <!-- <div class="card-header">
                        <h5 class="m-b-0">Feather Icons</h5>
                    </div> -->
                    <div class="card-body">
                        <p class="card-text">Data pengajuan integrasi.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">Tanggal Pengajuan</th>
                                        <th>Nama</th>
                                        <th>Narapidana</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <?= $this->include('PengajuanIntegrasi/modal'); ?>
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
    var grid = null;
    var dataRow;
    $(document).ready(function() {

        // Select2 untuk Inputan Status
        select2config("status", "Status");

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah Status');

            $('.nik').html(dataRow.nik);
            $('.nama').html(dataRow.user.nama);
            $('.namaNapi').html(dataRow.napi.nama);
            $('.hubungan').html(dataRow.hubungan);
            $('.tanggal').html(dataRow.tanggal ? dateConvertToIndo(dataRow.tanggal).datetime24 : '-');
            $('.status').val(dataRow.status).trigger('change');

            $("[id^='er_']").html('');
        });

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#detailModal').modal('show');

            $('.nik').html(dataRow.nik);
            $('.nama').html(dataRow.user.nama);
            $('.namaNapi').html(dataRow.napi.nama);
            $('.hubungan').html(dataRow.hubungan);
            $('.tanggal').html(dataRow.tanggal ? dateConvertToIndo(dataRow.tanggal).datetime24 : '-');
            $('.statusPengajuan').html(statusPengajuan(dataRow.status, dataRow.statusPengajuan.status));

            link = `<?= current_url() ?>/surat/penjamin/${dataRow.id}`;
            let penjaminIntegrasi = `<a href="${link}" target="_BLANK"><i class="fa fa-file-pdf-o"></i> File Penjamin Integrasi</a>`;
            $('#penjaminIntegrasi').html(penjaminIntegrasi);

            link = `<?= current_url() ?>/surat/pernyataan/${dataRow.id}`;
            let pernyataanIntegrasi = `<a href="${link}" target="_BLANK"><i class="fa fa-file-pdf-o"></i> File Pernyataan Integrasi</a>`;
            $('#pernyataanIntegrasi').html(pernyataanIntegrasi);

            link = `<?= base_url('File') ?>/get/foto_user_integrasi/${dataRow.user.fotoKtp}`;
            let ktpPenjamin = `<a href="${link}" rel='shortcut icon' target="_BLANK"><i class="fa fa-file-image-o"></i> KTP Penjamin</a>`;
            $('#ktpPenjamin').html(ktpPenjamin);

            // if (dataRow.status == 6) {
            //     $('.cetakSK').show();
            // } else {
            //     $('.cetakSK').hide();
            // }
        });

        $('#btnSimpan').click(function(e) {
            e.preventDefault();

            let serialize = $("#form").serializeArray();
            var objectSerialize = {};
            $.each(serialize, function(i, v) {
                objectSerialize[v.name] = v.value;
            });

            let send = {
                ...dataRow,
                status: $('.status').val(),
            }

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan`,
                data: send,
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
                        $('.modal').modal('hide');
                        grid.draw(false);
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
                    $('#btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnSimpan').removeAttr('disabled').html('Simpan');
                }
            });
        });

        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= current_url(); ?>/grid",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            order: [
                [1, "desc"]
            ],
            columns: [{
                    data: 'id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tanggal',
                    render: function(val, type, row, meta) {
                        return val ? dateConvertToIndo(val).datetime24 : '-'
                    }
                },
                {
                    data: 'user.nama',
                },
                {
                    data: 'napi.nama',
                },
                {
                    data: 'statusPengajuan.status',
                    render: function(val, type, row, meta) {
                        return statusPengajuan(row.status, val);
                    }
                },
                {
                    data: 'id',
                    render: function(val, type, row, meta) {
                        var btnDetail = btnDatatableConfig('detail', {
                            'id': 'btnDetail',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });
                        // var btnHapus = btnDatatableConfig('delete', {
                        //     'id': 'btnHapus',
                        //     'data-row': meta.row,
                        // }, {
                        //     show: true
                        // });
                        var btnEdit = btnDatatableConfig('update', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            textBtn: 'Ubah Status',
                            show: true
                        });

                        return `${btnDetail} ${btnEdit}`;
                    }
                }
            ]
        });

        function statusPengajuan(status, text) {
            if (status == 1) {
                labelClass = "primary";
            } else if (status == 2) {
                labelClass = "info";
            } else if (status == 3) {
                labelClass = "info";
            } else if (status == 4) {
                labelClass = "info";
            } else if (status == 5) {
                labelClass = "info";
            } else if (status == 6) {
                labelClass = "success";
            } else {
                labelClass = "danger";
            }

            let labelStart = `<span class="badge badge-pill badge-light-${labelClass}">`;
            let labelEnd = `</span>`;

            statusView = `${labelStart}${text}${labelEnd}`;

            return statusView;
        }
    });
</script>
<?= $this->endSection(); ?>