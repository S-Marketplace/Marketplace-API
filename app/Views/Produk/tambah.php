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
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <div class="card">
                  <div class="card-header">
                    <h5>Data Produk</h5>
                  </div>
                  <form class="form theme-form" id="form">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Kode Produk</label>
                            <div class="col-sm-9">
                                <input type="text" name="id" id="id" class="form-control readonly-background" value="<?= $produk->produkId ?? ''; ?>" placeholder="Id">
                                <p class="text-danger" id="er_id"></p>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" id="nama" class="form-control readonly-background" value="<?= $produk->produkNama ?? ''; ?>" placeholder="Nama">
                                <p class="text-danger" id="er_nama"></p>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-6">
                                <input type="text" name="harga" id="harga" class="form-control readonly-background" value="<?= $produk->produkHarga ?? ''; ?>" placeholder="Harga">
                                <p class="text-danger" id="er_harga"></p>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="hargaPer" id="hargaPer" class="form-control readonly-background" value="<?= $produk->produkHargaPer ?? ''; ?>" placeholder="/ pcs">
                                <p class="text-danger" id="er_hargaPer"></p>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Diskon</label>
                            <div class="col-sm-9">
                                <input type="text" name="diskon" id="diskon" class="form-control readonly-background" value="<?= $produk->produkDiskon ?? ''; ?>" placeholder="Diskon %">
                                <p class="text-danger" id="er_diskon"></p>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-6">
                                <input type="text" name="stok" id="stok" class="form-control readonly-background" value="<?= $produk->produkStok ?? ''; ?>" placeholder="Stok">
                                <p class="text-danger" id="er_stok"></p>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="berat" id="berat" class="form-control readonly-background" value="<?= $produk->produkBerat ?? ''; ?>" placeholder="Berat (gram)">
                                <p class="text-danger" id="er_berat"></p>
                            </div>
                          </div>
                        
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"><?= $produk->produkDeskripsi ?? ''; ?></textarea>
                                <p class="text-danger" id="er_deskripsi"></p>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <?= form_dropdown('kategoriId', $kategori, $produk->produkKategoriId ?? '', ['class' => 'form-control kategoriId select2', 'id' => 'kategoriId']); ?>
                                <p class="text-danger" id="er_kategoriId"></p>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Gambar</label>
                            <div class="col-sm-9">
                                <input class="form-control gambar" type="file" name="gambar[]" multiple placeholder="icon">
                                <p class="text-danger" id="er_gambar"></p>
                                <div class="row">
                                    <?php foreach($produkGambar ?? [] as $key => $value):?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card cardGambar" >
                                            <div class="product-box">
                                                <div class="product-img" >
                                                <?php if($key == 0):?>
                                                    <div class="ribbon ribbon-danger">Foto Utama</div>
                                                <?php endif;?>
                                                <img class="img-fluid" src="<?=base_url('File/get/produk_gambar/'.$value->prdgbrFile)?>" alt="">
                                                <div class="product-hover">
                                                    <ul>
                                                        <li>
                                                            <button data-toggle="tooltip" data-title="Hapus"  data-id="<?= $value->prdgbrId?>" data-produkid="<?= $value->prdgbrProdukId?>" class="btn btnHapus" type="button" data-bs-original-title="" title=""><i class="icofont icofont-trash"></i></button>
                                                        </li>
                                                        <?php if($value->prdgbrIsThumbnail == '0'):?>
                                                            <li>
                                                                <button data-toggle="tooltip" data-title="Jadikan Foto Utama" data-id="<?= $value->prdgbrId?>" data-produkid="<?= $value->prdgbrProdukId?>" class="btn btnSetThumbnail" type="button" data-bs-original-title="" title=""><i class="icofont icofont-pencil"></i></button>
                                                            </li>
                                                        <?php endif;?>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="card cardGambar">
                                            <div class="blog-box blog-shadow " style="min-height: 100px;"><img class="img-fluid" src="<?=base_url('File/get/produk_gambar/'.$value->prdgbrFile)?>" alt="">
                                                <div class="blog-details">
                                                    <ul class="blog-social">
                                                        <li class="btnHapus" data-id="<?= $value->prdgbrId?>"><i class="feather icon-trash"></i>Hapus Gambar</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <img class="img-fluid" alt="" src="<?=base_url('File/get/produk_gambar/'.$value->prdgbrFile)?>"> -->
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end">
                      <div class="col-12">
                        <button class="btn btn-primary pull-right" id="btnSimpan" type="submit" >Simpan</button>
                        <a class="btn btn-light" href="<?= base_url('Produk')?>" data-bs-original-title="" title="">Kembali</a>
                      </div>
                    </div>
                  </form>
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

        
        var id = '<?= $id ?? '';?>';
        
        $('[name="harga"]').val(formatRupiah($('[name="harga"]').val()));
        krajeeConfig('.gambar', {
            type: 'image'
        });

        $('[name="kategoriId"]').select2().trigger('change');

        $(document).on('keyup', '[name="harga"]', function(e) {
            $('[name="harga"]').val(formatRupiah($(this).val()));
        });
        $(document).on('click', '.btnHapus', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let gambarId = $(this).data('id');
            let produkId = $(this).data('produkid');
            let ini = $(this);

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
                        url: `<?= base_url('Produk') ?>/hapusGambar/${gambarId}/${produkId}`,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                ini.parents('.cardGambar').remove();
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
                            btn.removeAttr('disabled').html('<i class="icofont icofont-trash"></i>');
                        }
                    });

                }
            });

        });

        $(document).on('click', '.btnSetThumbnail', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let id = $(this).data('id');
            let ini = $(this);

            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Mengubah jadi foto utama!",
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
                        url: `<?= base_url('Produk') ?>/setThumbnail/${id}`,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                Swal.fire('Berhasil', res.message, 'success')
                                location.reload();
                            } else {
                                Swal.fire('Gagal', res.message, 'error')
                            }
                        },
                        fail: function(xhr) {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                        },
                        beforeSend: function() {
                            btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function(res) {
                            btn.removeAttr('disabled').html('<i class="icofont icofont-pencil"></i>');
                        }
                    });

                }
            });

        });
       
       
        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('idBefore', id);

            $.ajax({
                type: "POST",
                url: `<?= base_url('Produk') ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');

                        setTimeout(() => {
                            window.location = '<?= base_url('Produk')?>';
                        }, 400);
                    } else {
                        $.each(res.message, function(index, val) {
                            if(index == 'gambar[]') index = 'gambar';
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

      
    });
</script>
<?= $this->endSection(); ?>