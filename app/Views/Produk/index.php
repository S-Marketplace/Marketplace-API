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
                    <div class="card-body">
                        <p class="card-text">Data Produk yang akan dijual.</p>
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

    <?= $this->include('Produk/modal'); ?>
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

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = {};

            $('[name="hari"]').val('').trigger('change');
            $('textarea').val('');
            $('#aksi').html('Tambah');
            clearFlatPicker();
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