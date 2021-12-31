<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Jumlah Penghuni</h3>
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
    <?= $this->include('JumlahPenghuni/grid'); ?>
    <!-- Container-fluid Ends-->
    <?= $this->include('JumlahPenghuni/modal'); ?>

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

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = {};
            $('[name="hari"]').val('').trigger('change');
            $('#aksi').html('Tambah');
            clearFlatPicker();

            $('textarea').val('');
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $.each(dataRow, function(i, v) {
                $(`#${i}`).val(v);
            });

            $('#hari').val(dataRow.hari).trigger('change');

            tanggal.setDate(dataRow.tanggal);

            $("[id^='er_']").html('');
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

        $('#btnSimpan').click(function(e) {
            e.preventDefault();

            let serialize = $("#form").serializeArray();
            console.log(serialize);
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
            order: [
                [1, 'desc'],
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
                        console.log(val);
                        return new moment(val).locale("id").format(`DD MMMM YYYY`);;
                    }
                },
                {
                    data: 'tahananDL',
                },
                {
                    data: 'tahananDP',
                },
                {
                    data: 'tahananTD',
                },
                {
                    data: 'tahananAL',
                },
                {
                    data: 'tahananAP',
                },
                {
                    data: 'kapasitas',
                    render: function(val, type, row, meta) {
                        let total = parseInt(row.tahananDL) + parseInt(row.tahananDP) + parseInt(row.tahananTD) + parseInt(row.tahananAL) + parseInt(row.tahananAP);
                        return total;
                    }
                },
                // {
                //     data: 'tahananTA',
                // },
                // {
                //     data: 'tahananTotal',
                // },
                {
                    data: 'napiDL',
                },
                {
                    data: 'napiDP',
                },
                {
                    data: 'napiTD',
                },
                {
                    data: 'napiAL',
                },
                {
                    data: 'napiAP',
                },
                {
                    data: 'napiTA',
                },
                {
                    data: 'kapasitas',
                    render: function(val, type, row, meta) {
                        let total = parseInt(row.napiDL) + parseInt(row.napiDP) + parseInt(row.napiTD) + parseInt(row.napiAL) + parseInt(row.napiAP) + parseInt(row.napiTA);
                        return total;
                    }
                },
                // {
                //     data: 'napiTotal',
                // },
                {
                    data: 'periode',
                    render: function(val, type, row, meta) {
                        // let napi = parseInt(row.napiTotal);
                        // let tahanan = parseInt(row.tahananTotal);
                        let napi = parseInt(row.napiDL) + parseInt(row.napiDP) + parseInt(row.napiTD) + parseInt(row.napiAL) + parseInt(row.napiAP) + parseInt(row.napiTA);
                        let tahanan = parseInt(row.tahananDL) + parseInt(row.tahananDP) + parseInt(row.tahananTD) + parseInt(row.tahananAL) + parseInt(row.tahananAP);

                        return napi + tahanan;
                    }
                },
                {
                    data: 'kapasitas',
                },
                {
                    data: 'kapasitas',
                    render: function(val, type, row, meta) {
                        // let napi = parseInt(row.napiTotal);
                        // let tahanan = parseInt(row.tahananTotal);

                        let napi = parseInt(row.napiDL) + parseInt(row.napiDP) + parseInt(row.napiTD) + parseInt(row.napiAL) + parseInt(row.napiAP) + parseInt(row.napiTA);
                        let tahanan = parseInt(row.tahananDL) + parseInt(row.tahananDP) + parseInt(row.tahananTD) + parseInt(row.tahananAL) + parseInt(row.tahananAP);
                        let total = napi + tahanan;
                        return ((total / val) * 100).toFixed(2);
                    }
                },
                {
                    data: 'kapasitas',
                    render: function(val, type, row, meta) {
                        // let napi = parseInt(row.napiTotal);
                        // let tahanan = parseInt(row.tahananTotal);
                        let napi = parseInt(row.napiDL) + parseInt(row.napiDP) + parseInt(row.napiTD) + parseInt(row.napiAL) + parseInt(row.napiAP) + parseInt(row.napiTA);
                        let tahanan = parseInt(row.tahananDL) + parseInt(row.tahananDP) + parseInt(row.tahananTD) + parseInt(row.tahananAL) + parseInt(row.tahananAP);
                        let total = napi + tahanan;

                        if (total > val) {
                            let kapasitas = ((total / val) * 100).toFixed(2);
                            return Math.abs((100 - kapasitas));
                        } else {
                            let nol = 0;
                            return nol.toFixed(2);
                        }


                    }
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
            $('#tangal')[0]._flatpickr.clear();
        }
    });
</script>
<?= $this->endSection(); ?>