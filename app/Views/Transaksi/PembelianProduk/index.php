<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Pembelian Produk</h3>
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
                        <p class="card-text">Data Pembelian Produk.</p>
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
                                        <th>Status Pembayaran</th>
                                        <th>Status Pembelian</th>
                                        <th width="70px">Aksi</th>
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

    <?= $this->include('Transaksi/PembelianProduk/modal'); ?>
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

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();


            $('[name="noResi"]').val(dataRow.kurir.noResi);
            $('#kurir_layanan').html(`${dataRow.kurir.deskripsi} (${dataRow.kurir.service})`);
            $('#kurir_nama').html(`${dataRow.kurir.nama} (${dataRow.kurir.kurir})`);
            $('#modal').modal('show');
            $('#aksi').html('Ubah');
        });

        function templateOrderDetail(dataDetail){
            let text = '';
            let total = 0;
            dataDetail.forEach(element => {
                text +=  `<tr>
                            <td>
                                <p class="m-0">${element.keterangan}</p>
                            </td>
                            <td>
                                <p class="itemtext">Rp. ${formatRupiah(element.biaya.toString())}</p>
                            </td>
                        </tr>`;

                total += element.biaya;
            });

            return `<table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td class="item">
                                        <h6 class="p-2 mb-0">Keterangan</h6>
                                    </td>
                                    <td class="subtotal">
                                        <h6 class="p-2 mb-0">Sub-total</h6>
                                    </td>
                                </tr>

                                ${text}
                               
                                <tr>
                                    <td class="Rate">
                                        <h6 class="mb-0 p-2">Total</h6>
                                    </td>
                                    <td class="payment">
                                        <h6 class="mb-0 p-2">Rp. ${formatRupiah(total.toString())}</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>`;
            
        }

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            $('[name="noResi"]').val(dataRow.kurir.noResi);
            $('#orderDetail').html(templateOrderDetail(dataRow.detail));

            loadKeranjangDetail(dataRow.id);

            $('#kurir_layanan').html(`${dataRow.kurir.deskripsi} (${dataRow.kurir.service})`);
            $('#kurir_nama').html(`${dataRow.kurir.nama} (${dataRow.kurir.kurir})`);
            $('#modal-detail').modal('show');
            $('#aksi').html('Ubah');
        });

        function templateKeranjangDetail(dataDetail){
            let text = '';
            dataDetail.forEach(element => {
                text +=  `<div class="prooduct-details-box"> 
                          <div class="media"><img class="align-self-center img-fluid img-100 mx-3" src="<?=base_url('File/get/produk_gambar/')?>/${element.products.gambar[0].file}" alt="#">
                            <div class="media-body ms-3">
                              <div class="product-name">
                                <h6><a href="#" data-bs-original-title="" title="">${element.products.nama}</a></h6>
                              </div>
                              <div class="price d-flex"> 
                                <div class="text-muted me-2">Harga</div>: Rp. ${formatRupiah(element.products.harga.toString())}
                              </div>
                              <div class="price d-flex">
                                <div class="text-muted me-2">Jumlah</div>: ${element.quantity}
                            </div>
                            </div>
                          </div>
                        </div>`;
            });

            return `${text}`;
            
        }

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
                        Swal.fire('Berhasil!', res.message, 'success');
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

        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, "desc"]
            ],
            ajax: {
                url: "<?= current_url(); ?>/grid",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            columns: [{
                    data: 'pembayaran.id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'pembayaran.paymentType',
                    render: function(val, type, row, meta) {
                        if (val == 'bank_transfer') return 'Transfer Bank';
                        else if (val == 'echannel') return 'Mandiri Bill';
                        else if (val == 'saldo') return 'Saldo';
                    }
                },
                {
                    data: 'pembayaran.time',
                },
                {
                    data: 'pembayaran.orderId',
                },
                {
                    data: 'pembayaran.userEmail',
                },
                {
                    data: 'pembayaran.grossAmount',
                    render: function(val, type, row, meta) {
                        return `Rp. ${formatRupiah(val.toString())}`;
                    }
                },
                {
                    data: 'pembayaran.status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if (val == 'pending') return `<span class="badge badge-light text-dark">Pending</span>`;
                        else if (val == 'settlement') return `<span class="badge badge-success text-light">Settelment</span>`;
                        else if (val == 'cancel') return `<span class="badge badge-danger text-light">Cancel</span>`;
                        else if (val == 'expire') return `<span class="badge badge-danger text-light">Expire</span>`;
                        else if (val == 'failure') return `<span class="badge badge-danger text-light">Failure</span>`;

                        text = val;

                        return text;
                    }
                },
                {
                    data: 'status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if (val == 'selesai') return `<span class="badge badge-success text-light">Selesai</span>`;
                        else if (val == 'dikirim') return `<span class="badge badge-primary text-light">Dikirim</span>`;
                        else if (val == 'dikemas') return `<span class="badge badge-primary text-light">Dikemas</span>`;
                        else if (val == 'belum_bayar') return `<span class="badge badge-danger text-light">Belum Dibayar</span>`;
                        else if (val == 'dibatalkan') return `<span class="badge badge-danger text-light">Dibatalkan</span>`;

                        text = val;

                        return text;
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

                        var btnDetail = btnDatatableConfig('detail', {
                            'id': 'btnDetail',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        var btnEdit = btnDatatableConfig('update', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            show: row.pembayaran.status == 'settlement' && (row.status == 'dikemas' || row.status == 'dikirim')
                        });

                        return `${btnDetail} ${btnEdit}`;
                    }
                }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>