<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Jadwal Kunjungan Khusus</h3>
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
                    <button class="btn btn-sm btn-primary pull-right" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button>
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
                        <p class="card-text">Data jadwal kunjungan khusus.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">Tanggal</th>
                                        <th width="20%">Waktu</th>
                                        <th width="30%">Keterangan</th>
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

    <?= $this->include('JadwalKhusus/modal'); ?>
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

        tanggal = flatpickr('#tanggal', {
            locale: "id",
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
        });

        jamMulai = flatpickr('#jamMulai', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        jamSelesai = flatpickr('#jamSelesai', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = {};

            $('[name="hari"]').val('').trigger('change');
            $('textarea').val('');
            $('#aksi').html('Tambah');
            clearFlatPicker();
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $('#hari').val(dataRow.hari).trigger('change');
            $('#keterangan').val(dataRow.keterangan);

            tanggal.setDate(dataRow.tanggal);
            jamMulai.setDate(dataRow.jamMulai);
            jamSelesai.setDate(dataRow.jamSelesai);

            $("[id^='er_']").html('');
        });

        $(document).on('click', '#btnHapus', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            console.log($(e.currentTarget));
            let btn = $(e.currentTarget);
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

        $('#btnSimpan').click(function(e) {
            e.preventDefault();

            let serialize = $("#form").serializeArray();
            var objectSerialize = {};
            $.each(serialize, function(i, v) {
                objectSerialize[v.name] = v.value;
            });

            let send = {
                ...dataRow,
                ...objectSerialize,
            }

            console.log(send);
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan/id`,
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
            columns: [{
                    data: 'id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tanggal',
                    render: function(val, type, row, meta) {
                        return dateConvertToIndo(val).date;
                    }
                },
                {
                    data: 'jamMulai',
                    render: function(val, type, row, meta) {
                        return `${moment(val, "HH:mm:ss").format("HH:mm")} - ${moment(row.jamSelesai, "HH:mm:ss").format("HH:mm")}`;
                    }
                },
                {
                    data: 'keterangan',
                },
                {
                    data: 'id',
                    render: function(val, type, row, meta) {
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

                        return `${btnEdit} ${btnHapus}`;
                    }
                }
            ]
        });

        /**
         * clearFaltPicker
         * 
         * set inputan flatpickr menjadi null
         *
         * @return void
         */
        function clearFlatPicker() {
            $('#jamMulai')[0]._flatpickr.clear();
            $('#jamSelesai')[0]._flatpickr.clear();
            $('#tanggal')[0]._flatpickr.clear();
        }
    });
</script>
<?= $this->endSection(); ?>