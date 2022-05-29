<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Produk</h3>
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
                        <p class="card-text">Data Kategori.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="13%">Kode</th>
                                        <th width="13%">Nama</th>
                                        <th width="13%">Jenis</th>
                                        <th width="13%">Kategori</th>
                                        <th width="13%">Harga</th>
                                        <th width="13%">Kode Suplier</th>
                                        <th width="13%">Poin</th>
                                        <th width="13%">Jam Operasional</th>
                                        <th width="5%">Aksi</th>
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

    <?= $this->include('ProdukPulsa/modal'); ?>
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

        $('.select2').select2().trigger('change');

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = null;
            $('#aksi').html('Tambah');
            $('input').val('');
            $('.select2').val('').trigger('change');
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $('[name="nama"]').val(dataRow.nama);
            $('[name="harga"]').val(dataRow.harga);
            $('[name="deskripsi"]').val(dataRow.deskripsi);
            $('[name="jenis"]').val(dataRow.jenis).trigger('change');
            $('[name="kategoriId"]').val(dataRow.kategoriId).trigger('change');
            $('[name="kode"]').val(dataRow.kode);
            $('[name="kodeSuplier"]').val(dataRow.kodeSuplier);
            $('[name="poin"]').val(dataRow.poin);
            $('[name="jamOperasional"]').val(dataRow.jamOperasional);
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

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('id', dataRow ? dataRow.id : '');

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        grid.draw(false);
                        $('.modal').modal('hide');
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
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

        // <th width="1%">No</th>
        // <th width="13%">Nama</th>
        // <th width="13%">Jenis</th>
        // <th width="13%">Kategori</th>
        // <th width="13%">Kode</th>
        // <th width="13%">Kode Suplier</th>
        // <th width="13%">Poin</th>
        // <th width="13%">Jam Operasional</th>
        // <th width="5%">Aksi</th>
        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= current_url(); ?>/grid?with[]=kategori",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            columns: [
                {
                    data: 'kode',
                },
                {
                    data: 'kodeSuplier',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'jenis',
                    render: function(data){
                        if(data == 'elektrik'){
                            return `<span class="badge badge-primary text-light">Elektrik</span>`;
                        }

                        return `<span class="badge badge-primary text-light">${data.toUpperCase()}</span>`;
                    }
                },
                {
                    data: 'kategori.nama',
                },
                {
                    data: 'harga',
                    render: function(data){
                        return 'Rp. '+formatRupiah(data.toString());
                    }
                },
                {
                    data: 'poin',
                },
                {
                    data: 'jamOperasional',
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

    });
</script>
<?= $this->endSection(); ?>