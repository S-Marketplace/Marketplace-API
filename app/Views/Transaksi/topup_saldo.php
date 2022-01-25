<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Top Up Saldo</h3>
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
                        <p class="card-text">Data Top Up Saldo.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal & Waktu</th>
                                        <th>ID Pesanan</th>
                                        <th>Email Pelanggan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
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
                    data: 'paymentType',
                    render: function(val, type, row, meta) {
                        if(val == 'bank_transfer') return 'Transfer Bank';
                        else if(val == 'echannel') return 'Mandiri Bill';
                    }
                },
                {
                    data: 'time',
                },
                {
                    data: 'orderId',
                },
                {
                    data: 'userEmail',
                },
                {
                    data: 'grossAmount',
                },
                {
                    data: 'status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if(val == 'pending') return `<span class="badge badge-light text-dark">Pending</span>`;
                        else if(val == 'settlement') return `<span class="badge badge-success text-light">Settelment</span>`;
                        else if(val == 'cancel') return `<span class="badge badge-danger text-light">Cancel</span>`;
                        else if(val == 'expire') return `<span class="badge badge-danger text-light">Expire</span>`;
                        else if(val == 'failure') return `<span class="badge badge-danger text-light">Failure</span>`;
                        
                        text = val;

                        return text;
                    }
                },
            ]
        });

    });
</script>
<?= $this->endSection(); ?>