<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>User Terdaftar</h3>
                </div>
                <div class="col-6">
                    <!-- <button class="btn btn-sm btn-primary pull-right" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button> -->
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
                        <p class="card-text">Data User Aplikasi Web.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">Email</th>
                                        <th width="20%">Nama</th>
                                        <th width="20%">Status</th>
                                        <!-- <th width="15%">Aksi</th> -->
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
    $(document).ready(function() {

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
                    data: 'email',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'email',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'isActive',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if(val == '1'){
                            text = 'Aktif';
                        }else{
                            text = 'Belum Aktif';
                        }

                        return text;
                    }
                },
                // {
                //     data: 'username',
                //     render: function(val, type, row, meta) {
                //         var btnHapus = btnDatatableConfig('delete', {
                //             'id': 'btnHapus',
                //             'data-row': meta.row,
                //         }, {
                //             show: true
                //         });
                //         var btnEdit = btnDatatableConfig('update', {
                //             'id': 'btnEdit',
                //             'data-row': meta.row,
                //         }, {
                //             show: true
                //         });

                //         return `${btnEdit} ${btnHapus}`;
                //     }
                // }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>