<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Narapidana</h3>
                </div>
                <div class="col-6">
                    <a href="<?= current_url() ?>/tambah" class="btn btn-sm btn-primary pull-right ml-1" id="btnTambah"><i class="fa fa-plus"></i> Tambah</a>
                    <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#importModal"><i class="fa fa-upload"></i> Import Data</button>
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
                        <p class="card-text">Data narapidana.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="15%">No Registrasi</th>
                                        <th width="20%">Nama</th>
                                        <th width="20%">Blok Kamar</th>
                                        <th width="20%">Jenis Kejahatan</th>
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

    <?= $this->include('Napi/modal'); ?>
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
    var dataImport;
    var berhasil = 0;
    var gagal = 0;
    var totalImport = 0;
    var totalData = 0;
    $(document).ready(function() {

        $('#viewTableImport, #btnImport, #viewImport').hide();

        $('#btnLihat').click(function(e) {

            $('#lihat').removeClass('fa-eye').addClass('fa-spin fa-spinner disabled').attr('disabled', 'disabled');
            e.preventDefault();
            let file = $('#fileImport')[0].files[0];
            let formData = new FormData();
            formData.append('fileImport', file);
            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/viewImport",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {

                        dataImport = res.data;
                        dataTableImport(res.data);

                        $('#viewTableImport, #btnImport').show();
                    } else {
                        Swal.fire('Info!', res.message, 'warning');
                    }
                }
            }).fail(function(xhr) {
                Swal.fire('Error', "Server gagal merespon", 'error');
            }).always(function() {
                $("#fileImport").val('');
                $('#lihat').removeClass('fa-spin fa-spinner disabled').addClass('fa-eye').removeAttr('disabled');
            });
        });

        $('#btnImport').click(function(e) {
            e.preventDefault();
            $('#viewImport').show();

            berhasil = 0;
            gagal = 0;
            totalImport = 0;
            totalData = Object.keys(dataImport).length;

            let data = Object.assign([], dataImport);
            importData(data);
        });

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#detailModal').modal('show');

            $.each(dataRow, function(index, val) {
                $(`#${index}`).html(val);
            });

            $('#agama').html(dataRow.agamaRef.nama);
            $('#jenisKelamin').html(dataRow.jenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan');
            $('#tanggalLahir').html(dateConvertToIndo(dataRow.tanggalLahir, {
                isDay: false
            }).date);
            $('#tanggalEkspirasi').html(dateConvertToIndo(dataRow.tanggalEkspirasi, {
                isDay: false
            }).date);

            link = `<?= base_url('File') ?>/get/napi/${dataRow.pasFoto}`;
            let pasFoto = `<a href="${link}" target="_BLANK"><img class="img-fluid img-thumbnail js-tilt" src="${link}" width="150px" alt="Pas Foto"></a>`;
            $('#pasFoto').html(pasFoto);
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            window.location = `<?= current_url() ?>/edit/${dataRow.id}`;
        });

        $(document).on('click', '#btnHapus', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Data yang terhapus tidak dapat dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: `<?= current_url() ?>/hapus/${dataRow.id}`,
                        // data: send,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                grid.draw(false);
                                Swal.fire('Terhapus!', 'Data berhasil dihapus', 'success')
                            } else {
                                Swal.fire('Info!', res.message, 'warning')
                            }
                        },
                        fail: function(xhr) {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                        },
                        beforeSend: function() {
                            btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function(res) {
                            btn.removeAttr('disabled').html('<i class="feather icon-trash"></i>');
                        }
                    });

                }
            });

            $("[id^='er_']").html('');
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
                [0, 'asc'],
            ],
            columnDefs: [{
                "className": "dt-tengah",
                "targets": [0],
            }],
            columns: [{
                    data: 'id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    data: 'noReg',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'blokKamar',
                },
                {
                    data: 'jenisKejahatan',
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
                        var btnHapus = btnDatatableConfig('delete', {
                            'id': 'btnHapus',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });
                        var btnEdit = btnDatatableConfig('update', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        return `${btnDetail} ${btnEdit} ${btnHapus}`;
                    }
                }
            ]
        });
    });

    function importData(data) {
        if (Object.keys(data).length > 0) {
            let dataShift = data.shift();

            let detailImport = `Import data  ${dataShift.noReg} - ${dataShift.nama} ...`;
            $('#detailImport').html(detailImport);

            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/importData",
                data: {
                    first: dataShift,
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {

                        dataImport = dataImport.filter(data => data.noReg !== dataShift.noReg);
                        berhasil += 1;

                    } else {
                        let index = dataImport.findIndex(data => data.noReg == dataShift.noReg);

                        if (typeof res.message === 'string' || res.message instanceof String || $.type(res.message) === "string") {
                            res.message = {
                                duplicate: res.message
                            };
                        }

                        dataImport[index].resMessage = res.message;
                        gagal += 1;
                    }

                    totalImport += 1;
                    progress = `${totalImport}/${totalData}`;

                    var percentage = (parseInt(totalImport) / parseInt(totalData) * 100).toFixed(2);
                    $('#progressImport').css('width', `${percentage}%`);

                    $('#progressView').html(progress);
                    $('.berhasil').html(berhasil);
                    $('.gagal').html(gagal);
                    $('.totalData').html(totalData);

                    if (Object.keys(data).length > 0) {
                        importData(data);
                    } else {
                        let message = `Data berhasil diimport. <br><br>
                        <span class="badge badge-light-success">Berhasil</span> : ${berhasil} 
                        <span class="badge badge-light-danger">Gagal</span> : ${gagal} 
                        <span class="badge badge-light-primary">Total Data</span> : ${totalData}`;

                        Swal.fire(
                            'Berhasil!',
                            message,
                            'success'
                        );

                        let detailImport = `Import data selesai.`;
                        $('#detailImport').html(detailImport);

                        if (gagal == 0) {
                            $('#importModal').modal('hide');
                        } else {
                            dataTableImport(dataImport);
                        }

                    }
                }
            });

        } else {
            Swal.fire('Error', "Tidak ada data yang bisa diimport.", 'error');
        }
    }

    function detailImport(row, event) {

        let tr = $(event.currentTarget).closest('tr');
        var row = gridImport.row(tr);
        let data = gridImport.row(row).data();
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            format(row.child, data);
            tr.addClass('shown');
        }
    }

    function format(callback, data) {

        let tanggalEkspirasi = dateConvertToIndo(data.tanggalEkspirasi, {
            isDay: false
        }).date

        let errorTanggalEkspirasi = (data.error.hasOwnProperty('tanggalEkspirasi')) ? `<span class="font-medium-2 font-danger">
                <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="${data.error.tanggalEkspirasi}"></i>
            </span>` : '';

        var text = $('<div/>');
        text.html(`
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Blok Kamar</p>
                            <span class="font-small-3">${data.blokKamar}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Undang-undang</p>
                            <span class="font-small-3">${data.uu}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Pasal Utama</p>
                            <span class="font-small-3">${data.pasalUtama}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Lama Pidana</p>
                            <span class="font-small-3">${data.lamaPidanaTahun} Tahun ${data.lamaPidanaBulan} Bulan ${data.lamaPidanaHari} Hari</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Jenis Kejahatan</p>
                            <span class="font-small-3">${data.jenisKejahatan}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Jenis Kejahatan Narkotika</p>
                            <span class="font-small-3">${data.jenisKejahatanNarkotika}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Tanggal Ekspirasi</p>
                            <span class="font-small-3">${tanggalEkspirasi} ${errorTanggalEkspirasi}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">UPT Asal</p>
                            <span class="font-small-3">${data.uptAsal}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Status Kerja Wali</p>
                            <span class="font-small-3">${data.statusKerjaWali}</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="timeline-info">
                            <p class="font-weight-bold mb-0">Nama File Foto</p>
                            <span class="font-small-3">${data.pasFoto}</span>
                        </div>
                    </div>
                </div>
            `);

        callback(text).show();
        text.closest('td').addClass((Object.keys(data.error).length == 0) ? 'colorValidDetail' : 'colorInvalidDetail');
    }

    function dataTableImport(data = []) {
        gridImport = $("#datatableImport").DataTable({
            destroy: true,
            data: data,
            dom: '<"customSearching">rltip',
            initComplete: function(settings, json) {
                $("div.customSearching").html(`<div class="col-md-4 col-12 pull-right mb-1">
                        <fieldset>
                            <div class="input-group">
                                <input type="text" class="form-control field-cari-importreset" placeholder="Pencarian" aria-describedby="button-addon2">
                                <div class="input-group-append" id="button-addon2">
                                    <button class="btn btn-primary waves-effect waves-light btn-cari-importreset" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </fieldset>
                    </div>`);
            },
            createdRow: function(row, data, dataIndex) {
                if (Object.keys(data.error).length > 0) {
                    $(row).addClass('colorInvalid');
                }
            },
            columns: [{
                    data: 'noReg',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "noReg",
                    render: function(val, type, row, meta) {
                        if (row.resMessage != '') {
                            return `${val} <button type="button" onclick="infoGagal('${meta.row}')" class="btn btn-sm btn-outline-danger waves-effect waves-light">Info Gagal</button>`;
                        } else {
                            return val;
                        }
                    }
                },
                {
                    data: "nama"
                },
                {
                    data: 'tanggalLahir',
                    render: function(val, type, row, meta) {
                        tanggalLahir = dateConvertToIndo(val, {
                            isDay: false
                        }).date;

                        error = '';
                        if (row.error.hasOwnProperty('tanggalLahir')) {
                            error = `<span class="font-medium-2 font-danger">
                                    <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="${row.error.tanggalLahir}"></i>
                                </span>`
                        }

                        return `${tanggalLahir}${error}`;
                    },
                },
                {
                    data: 'jenisKelamin',
                    render: function(val, type, row, meta) {
                        if (val == 'L') {
                            jenisKelamin = 'Laki-laki';
                        } else if (val == 'P') {
                            jenisKelamin = 'Perempuan';
                        } else {
                            jenisKelamin = val;
                        }

                        error = '';
                        if (row.error.hasOwnProperty('jenisKelamin')) {
                            error = `<span class="font-medium-2 font-danger">
                                    <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="${row.error.jenisKelamin}"></i>
                                </span>`
                        }

                        return `${jenisKelamin}${error}`;
                    },
                },
                {
                    data: 'agama',
                    render: function(val, type, row, meta) {
                        error = '';
                        if (row.error.hasOwnProperty('agama')) {
                            error = `<span class="font-medium-2 font-danger">
                                    <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="${row.error.agama}"></i>
                                </span>`
                        }

                        return `${row.agamaNama ? row.agamaNama : 'Tidak tersedia'}${error}`;
                    },
                },
                {
                    data: 'kewarganegaraan',
                    render: function(val, type, row, meta) {
                        error = '';
                        if (row.error.hasOwnProperty('kewarganegaraan')) {
                            error = `<span class="font-medium-2 font-danger">
                                    <i tabindex="0" class="feather icon-help-circle cursor-pointer manual" data-trigger="focus" data-toggle="popover" data-placement="right" data-content="${row.error.kewarganegaraan}"></i>
                                </span>`
                        }

                        return `${val}${error}`;
                    },
                },
                {
                    data: "noReg",
                    render: function(val, type, row, meta) {
                        var btnInfo = btnDatatableConfig('custom', {
                            'onclick': `detailImport('${meta.row}',event)`,
                        }, {
                            iconBtn: 'feather icon-info',
                            classBtn: 'info',
                            textBtn: 'Info',
                            show: true,
                        });
                        return `${btnInfo}`;
                    }
                }
            ]
        });
    }

    function infoGagal(row) {
        dataRow = gridImport.row(row).data();
        detailData = `${dataRow.noReg} - ${dataRow.nama}`;

        detailGagal = `<ul>`;
        $.each(dataRow.resMessage, function(index, val) {
            detailGagal += `<li>${val}</li>`
        });
        detailGagal += `</ul>`;

        $('#detailData').html(detailData);
        $('#detailGagal').html(detailGagal);

        $('#modalInfoGagal').modal('show');
    }
</script>
<?= $this->endSection(); ?>