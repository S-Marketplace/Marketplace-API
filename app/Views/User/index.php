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
                        <p class="card-text">Data User.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">Email</th>
                                        <th width="20%">Nama</th>
                                        <th width="20%">Saldo</th>
                                        <th width="20%">Status</th>
                                        <th width="8%">Aksi</th>
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

    <?= $this->include('User/modal'); ?>
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

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            loadKeranjangDetail(dataRow.email);
            $('.catatan_kurir').html(`${dataRow.alamat.keterangan}`);
            $('.alamat_pembeli').html(`${dataRow.alamat.jalan}, ${dataRow.alamat.kecamatanNama}, ${dataRow.alamat.kotaTipe} ${dataRow.alamat.kotaNama}, ${dataRow.alamat.provinsiNama}`);

            $('#modal-detail').modal('show');
            $('#aksi').html('Detail Keranjang');
        });

        function loadKeranjangDetail(id){
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/keranjangDetail/`+id,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#keranjangDetail').html(templateKeranjangDetail(res.data));
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $('#keranjangDetail').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                }
            });
        }

        function templateKeranjangDetail(dataDetail){
            let text = '';
            
            dataDetail.forEach(element => {
                let hargaNormal = element.products.harga;
                let hargaDiskon = element.products.harga;
                let diskonText = '';
    
                if(element.products.diskon != 0){
                    hargaNormal = hargaNormal - (hargaNormal * (element.products.diskon / 100));
                    diskonText = `<del>${formatRupiah(hargaDiskon.toString())}</del>`;
                }
                text +=  `<div class="prooduct-details-box"> 
                          <div class="media"><img class="align-self-center img-fluid img-100 mx-3" src="<?=base_url('File/get/produk_gambar/')?>/${element.products.gambar[0].file}" alt="#">
                            <div class="media-body ms-3">
                              <div class="product-name">
                                <h6><a href="#" data-bs-original-title="" title="">${element.products.nama}</a></h6>
                              </div>
                              <div class="price d-flex"> 
                                <div class="text-muted me-2">Harga</div>: Rp. ${formatRupiah(hargaNormal.toString())} &nbsp;&nbsp; ${diskonText}
                              </div>
                              <div class="price d-flex">
                                <div class="text-muted me-2">Jumlah</div>: ${element.quantity}
                            </div>
                              <a class="btn btn-success btn-xs" href="#" data-bs-original-title="" title="">Diskon ${element.products.diskon}%</a>
                            </div>
                          </div>
                        </div>`;
            });

            return `${text}`;
        }

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
                    data: 'saldo',
                    render: function(val, type, row, meta) {
                        if(val == null) return '-';
                        return `Rp. ${formatRupiah(val)}`;
                    }
                },
                {
                    data: 'isActive',
                    render: function(val, type, row, meta) {
                        if(val == '1') return `<span class="badge badge-success text-light">Aktif</span>`;
                        else return `<span class="badge badge-warning text-light">Belum Aktif</span>`;
                    }
                },
                {
                    data: 'username',
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