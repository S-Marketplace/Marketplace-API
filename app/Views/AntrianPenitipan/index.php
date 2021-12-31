<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Antrian Penitipan</h3>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item">Antrian Online</li>
                        <li class="breadcrumb-item active">Penitipan</li>
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
                        <p class="card-text">Data antrian penitipan hari ini.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th with="1%">No</th>
                                        <th with="10%">No Antrian</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Panggil</th>
                                        <th with="5%">Aksi</th>
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

    <?= $this->include('AntrianPenitipan/modal'); ?>
</div>

<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=td816rJt"></script>
<script>
    var grid = null;
    var dataRow;
    $(document).ready(function() {

        responsiveVoice.setDefaultVoice("Indonesian Male");
        // responsiveVoice.setDefaultRate(1);

        $(document).on('click', '#btnCall', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            let send = {
                ...dataRow,
            };

            send.isCall = 1;
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan/id`,
                data: send,
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        responsiveVoice.speak(`Antrian No ${dataRow.no}, harap menuju loket 1`, "Indonesian Male", {
                            rate: 0.9
                        });
                        grid.draw(false);
                    } else {
                        Swal.fire('Error', "Server gagal merespon", 'error');
                    }
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function(res) {
                    btn.removeAttr('disabled').html('<i class="fa fa-microphone"></i>');
                }
            });
        });

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#detailModal').modal('show');

            $('#noAntrianModal').html(dataRow.no);
            $('#namaNarapidanaModal').html(dataRow.napi.nama);
            $('#namaPengunjungModal').html(dataRow.pengunjung.nama);
            $('#jenisModal').html(dataRow.jenis);
            $('#keterangan').html(dataRow.keterangan);
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#editModal').modal('show');

            $('[name="nik"]').val(dataRow.nik);
            $('[name="nama"]').val(dataRow.pengunjung.nama);
            $('[name="namaWbp"]').val(dataRow.pengunjung.namaWbp);
            $('[name="namaAyah"]').val(dataRow.pengunjung.namaAyah);
            $("[name=jenisAntrian][value=" + dataRow.jenis + "]").attr('checked', 'checked');

            $("[id^='er_']").html('');
        });

        // $(document).on('click', '#btnHapus', function(e) {
        //     e.preventDefault();
        // let btn = $(e.currentTarget);
        //     let row = $(this).data('row');
        //     dataRow = grid.row(row).data();

        //     // send = {
        //     //     'id': dataRow.id,
        //     //     'nik': dataRow.nik,
        //     // }

        //     Swal.fire({
        //         title: 'Anda Yakin ?',
        //         text: "Data yang terhapus tidak dapat dikembalikan!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         cancelButtonText: 'Tidak',
        //         confirmButtonText: 'Ya'
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 type: "POST",
        //                 url: `<?= current_url() ?>/hapus/${dataRow.id}`,
        //                 // data: send,
        //                 dataType: "JSON",
        //                 success: function(res) {
        //                     if (res.code == 200) {
        //                         grid.draw(false);
        //                         Swal.fire('Terhapus!', 'Data berhasil dihapus', 'success')
        //                     } else {
        //                         Swal.fire('Info!', res.message, 'warning')
        //                     }
        //                 },
        //                 fail: function(xhr) {
        //                     Swal.fire('Error', "Server gagal merespon", 'error');
        //                 },
        //                 beforeSend: function() {
        //                     btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
        //                 },
        //                 complete: function(res) {
        //                     btn.removeAttr('disabled').html('<i class="feather icon-trash"></i>');
        //                 }
        //             });

        //         }
        //     });

        //     $("[id^='er_']").html('');
        // });

        // $('#btnSimpan').click(function(e) {
        //     e.preventDefault();

        //     let pengunjung = dataRow.pengunjung;
        //     let serialize = $("#formEdit").serializeArray();
        //     var objectSerialize = {};
        //     $.each(serialize, function(i, v) {
        //         objectSerialize[v.name] = v.value;
        //     });

        //     let send = {
        //         ...pengunjung,
        //         ...dataRow,
        //         ...objectSerialize,
        //     }

        //     send.jenis = send.jenisAntrian;

        //     console.log(send);
        //     $.ajax({
        //         type: "POST",
        //         url: `<?= current_url() ?>/simpan/${send.id}`,
        //         data: send,
        //         dataType: "JSON",
        //         success: function(res) {
        //             if (res.code == 200) {
        //                 Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
        //                 $('.modal').modal('hide');
        //                 grid.draw(false);
        //             } else {
        //                 let start = `<small class="badge badge-danger">`;
        //                 let end = `</small>`;
        //                 $.each(res.message, function(index, val) {
        //                     $('#er_' + index).html(start + val + end);
        //                 });
        //             }
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
                    data: 'no',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'no',
                },
                {
                    data: 'nik'
                },
                {
                    data: 'pengunjung.nama'
                },
                {
                    data: 'isCall',
                    render: function(val, type, row, meta) {

                        let isCall = val ? `<span class="badge badge-pill badge-light-success">Dipanggil</span>` : '';
                        var btnCall = btnDatatableConfig('custom', {
                            'id': 'btnCall',
                            'data-row': meta.row,
                        }, {
                            show: true,
                            iconBtn: 'fa fa-microphone',
                            classBtn: 'success',
                            textBtn: 'Panggil',
                            isTooltip: false,
                        });
                        return `${isCall} ${btnCall}`;
                    }
                },
                {
                    data: 'kode',
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
                        // var btnEdit = btnDatatableConfig('update', {
                        //     'id': 'btnEdit',
                        //     'data-row': meta.row,
                        // }, {
                        //     show: true
                        // });

                        // return `${btnDetail} ${btnEdit} ${btnHapus}`;
                        return `${btnDetail}`;
                    }
                }
            ]
        });
    });
</script>
<?= $this->endSection(); ?>