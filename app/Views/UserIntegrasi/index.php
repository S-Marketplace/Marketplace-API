<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>User Integrasi</h3>
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
                        <p class="card-text">Data user integrasi.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">NIK</th>
                                        <th width="25%">Nama</th>
                                        <th width="30%">Tempat, Tanggal Lahir</th>
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

    <?= $this->include('UserIntegrasi/modal'); ?>
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

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#detailModal').modal('show');

            $('#nikModal').html(dataRow.nik);
            $('#namaModal').html(dataRow.nama);
            $('#ttlModal').html(`${dataRow.tempatLahir}, ${dateConvertToIndo(dataRow.tanggalLahir).date}`);
            $('#noHpModal').html(dataRow.noHp);
            $('#emailModal').html(dataRow.email);


            link = `<?= base_url('File') ?>/get/foto_user_integasi/${dataRow.fotoKtp}`;
            let fotoKtp = `<a href="${link}" target="_BLANK"><img class="img-fluid img-thumbnail js-tilt" src="${link}" width="150px" alt="Foto KTP"></a>`;
            $('#fotoKtpModal').html(fotoKtp);

            link = `<?= base_url('File') ?>/get/foto_user_integasi/${dataRow.fotoSelfie}`;
            let fotoSelfie = `<a href="${link}" target="_BLANK"><img class="img-fluid img-thumbnail js-tilt" src="${link}" width="150px" alt="Foto Selfie"></a>`;
            $('#fotoSelfieModal').html(fotoSelfie);
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
                    data: 'nik',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nik',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'tempatLahir',
                    render: function(val, type, row, meta) {
                        return `${val}, ${dateConvertToIndo(row.tanggalLahir).date}`;
                    }
                },
                {
                    data: 'nik',
                    render: function(val, type, row, meta) {
                        var btnDetail = btnDatatableConfig('detail', {
                            'id': 'btnDetail',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        return `${btnDetail}`;
                    }
                }
            ]
        });
    });
</script>
<?= $this->endSection(); ?>