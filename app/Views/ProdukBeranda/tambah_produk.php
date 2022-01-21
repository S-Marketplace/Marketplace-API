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
                            <label class="col-sm-3 col-form-label">Judul</label>
                            <div class="col-sm-9">
                                <input type="text" name="judul" id="judul" class="form-control readonly-background" value="<?= $produk->pbJudul ?? ''; ?>" placeholder="Judul">
                                <p class="text-danger" id="er_judul"></p>
                            </div>
                          </div>
                        
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"><?= $produk->pbDeskripsi ?? ''; ?></textarea>
                                <p class="text-danger" id="er_deskripsi"></p>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Banner</label>
                            <div class="col-sm-9">
                                <div class="card cardGambar">
                                    <div class="blog-box blog-shadow " style="min-height: 100px;"><img class="img-fluid" src="<?=base_url('File/get/banner_gambar/'.$produk->pbBanner)?>" alt="">
                                        <div class="blog-details">
                                            <ul class="blog-social">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control banner" type="file" name="banner" placeholder="Banner">
                                <p class="text-danger" id="er_banner"></p>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Produk</label>
                            <div class="col-sm-9">
                                <div class="card cardGambar">
                                    <div class="blog-box blog-shadow " style="min-height: 100px;"><img class="img-fluid" src="<?=base_url('File/get/banner_gambar/'.$produk->pbBanner)?>" alt="">
                                        <div class="blog-details">
                                            <ul class="blog-social">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control banner" type="file" name="banner" placeholder="Banner">
                                <p class="text-danger" id="er_banner"></p>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end">
                      <div class="col-12">
                        <button class="btn btn-primary pull-right" id="btnSimpan" type="submit" >Simpan</button>
                        <a class="btn btn-light" href="<?= base_url('ProdukBeranda')?>" data-bs-original-title="" title="">Kembali</a>
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

        var id = '<?= $id ?? '';?>';

        krajeeConfig('.banner', {
            type: 'image'
        });

        $(document).on('click', '.btnHapus', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let gambarId = $(this).data('id');
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
                        url: `<?= base_url('ProdukBeranda') ?>/hapusGambar/${gambarId}`,
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
                            btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Hapus Gambar');
                        },
                        complete: function(res) {
                            btn.removeAttr('disabled').html('<i class="feather icon-trash"></i> Hapus Gambar');
                        }
                    });

                }
            });

        });
       
        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('id', id);

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
                            window.location = '<?= base_url('ProdukBeranda')?>';
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