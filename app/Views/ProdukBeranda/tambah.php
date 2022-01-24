<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>ProdukBeranda</h3>
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
                        <h5>Data ProdukBeranda</h5>
                    </div>
                    <form class="form theme-form" id="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Judul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="judul" id="judul" class="form-control readonly-background" value="<?= $data->pbJudul ?? ''; ?>" placeholder="Judul">
                                            <p class="text-danger" id="er_judul"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"><?= $data->pbDeskripsi ?? ''; ?></textarea>
                                            <p class="text-danger" id="er_deskripsi"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Banner</label>
                                        <div class="col-sm-9">
                                            <?php if(isset($data->pbBanner)):?>
                                            <div class="card cardGambar">
                                                <div class="blog-box blog-shadow " style="min-height: 100px;"><img class="img-fluid" src="<?= base_url('File/get/banner_gambar/' . $data->pbBanner ?? '') ?>" alt="">
                                                    <div class="blog-details">
                                                        <ul class="blog-social">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                            <input class="form-control banner" type="file" name="banner" placeholder="Banner">
                                            <p class="text-danger" id="er_banner"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Produk</label>
                                        <div class="col-sm-9">

                                            <div class="row dataProduk">
                                               
                                            </div>

                                           <div class="row pr-3">
                                               <div class="col-10">
                                                    <input type="text" name="cari" id="cari" class="form-control readonly-background mb-3" placeholder="Cari...">
                                               </div>
                                               <div class="col-2">
                                                     <button class="btn btn-primary" id="btnCariProduk" >Cari</button>
                                               </div>
                                           </div>

                                            <div class="row dataPencarian">
                                             
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right" id="btnSimpan" type="submit">Simpan</button>
                                <a class="btn btn-light" href="<?= base_url('ProdukBeranda') ?>" data-bs-original-title="" title="">Kembali</a>
                            </div>
                        </div>
                    </form>
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
    var dataRow;
    
    $(document).ready(function() {
        var productData = <?= json_encode($data->products ?? [])?>;
        $('.dataProduk').html(templateDataProduk(productData));

        var productDataSearch = [];

        var id = '<?= $id ?? ''; ?>';

        krajeeConfig('.banner', {
            type: 'image'
        });

        function templateDataProduk(){
            let text = '';
            productData.forEach(produk => {
                text += `
                <div class="col-xl-3 col-sm-6 xl-4">
                    <div class="card">
                        <div class="product-box">
                            <div class="product-img" style="min-height: 220px;"><img class="img-fluid" src="<?=base_url('File/get/produk_gambar')?>/${produk.gambar[0].file}" alt="">
                                <div class="product-hover">
                                    <ul>
                                        <li>
                                            <button class="btn btnHapus" data-id="${produk.id}" type="button" data-bs-original-title="" title=""><i class="icofont icofont-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details">
                                <p>ID.${produk.id}</p>
                                <h4>${produk.nama}</h4>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            return text;
        }

        function templateProdukPencarian(){
            let text = '';
            productDataSearch.forEach(produk => {
                text += `
                <div class="col-xl-3 col-sm-6 xl-4">
                    <div class="card">
                        <div class="product-box">
                            <div class="product-img" style="min-height: 220px;"><img class="img-fluid" src="<?=base_url('File/get/produk_gambar')?>/${produk.gambar[0].file}" alt="">
                                <div class="product-hover">
                                    <ul>
                                        <li>
                                            <button class="btn btnTambah" data-id="${produk.id}" type="button" data-bs-original-title="" title=""><i class="icofont icofont-plus"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details">
                                <p>ID.${produk.id}</p>
                                <h4>${produk.nama}</h4>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            return text;
        }

        $(document).on('click',".btnTambah",function () {
            let id = $(this).data('id');

            let dataInsert = productDataSearch.find(data => data.id == id);

            let find = productData.find(data => data.id == id);
            if(find == null){
                productData.push(dataInsert);
                $('.dataProduk').html(templateDataProduk(productData));
            }
        });

        $(document).on('click',".btnHapus",function () {
            let id = $(this).data('id');

            productData = productData.filter(data => data.id != id);
            $('.dataProduk').html(templateDataProduk(productData));
        });

        $("#btnCariProduk").click(function () {
            let cari = $('[name="cari"]').val();
            let btn = $(this);

            $.ajax({
                type: "POST",
                url: `<?= base_url('ProdukBeranda') ?>/cari`,
                data:{
                    cari: cari
                },
                dataType: "JSON",
                success: function(res) {
                    productDataSearch = res;
                    $('.dataPencarian').html(templateProdukPencarian());
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Cari');
                },
                complete: function(res) {
                    btn.removeAttr('disabled').html('Cari');
                }
            });
        });

        $('[name="cari"]').on('keyup', function(e) {
            var key = e.which;
            if (key == 13) 
            { 
                $("#btnCariProduk").trigger('click');
            }
        });

      
        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('id', id);
            data.append('produkId', productData.map( el => el.id ));

            $.ajax({
                type: "POST",
                url: `<?= base_url('ProdukBeranda') ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');

                        setTimeout(() => {
                            window.location = '<?= base_url('ProdukBeranda') ?>';
                        }, 400);
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


    });
</script>
<?= $this->endSection(); ?>