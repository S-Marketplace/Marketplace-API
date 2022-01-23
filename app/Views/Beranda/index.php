<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>Beranda</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-success b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>
                      <div class="media-body"><span class="m-0">Pengguna</span>
                        <h4 class="mb-0 counter jlhPengguna">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus icon-bg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-primary b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                      <div class="media-body"><span class="m-0">Produk</span>
                        <h4 class="mb-0 counter jlhProduk">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-warning b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></div>
                      <div class="media-body"><span class="m-0">Stok < 5</span>
                        <h4 class="mb-0 counter jlhStokSedikit">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-secondary b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                      <div class="media-body"><span class="m-0">Stok Habis</span>
                        <h4 class="mb-0 counter jlhStokHabis">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="col-xl-6 xl-100 box-col-12">
                <div class="widget-joins card widget-arrow">
                  <div class="row">
                    <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3 text-start"><span class="mb-1">Sale</span>
                          <h5 class="mb-0">Today</h5>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down font-primary"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></div>
                        <div class="media-body">
                          <h5 class="mb-0">$<span class="counter">25698</span></h5><span class="mb-1">-$2658(36%)</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 ps-0">
                      <div class="media">
                        <div class="align-self-center me-3 text-start"><span class="mb-1">Sale</span>
                          <h5 class="mb-0">Month</h5>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up font-primary"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg></div>
                        <div class="media-body ps-2">
                          <h5 class="mb-0">$<span class="counter">6954</span></h5><span class="mb-1">+$369(15%)</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3 text-start"><span class="mb-1">Sale</span>
                          <h5 class="mb-0">Week</h5>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up font-primary"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg></div>
                        <div class="media-body">
                          <h5 class="mb-0">$<span class="counter">63147</span></h5><span class="mb-1">+$69(65%)</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 ps-0">
                      <div class="media">
                        <div class="align-self-center me-3 text-start"><span class="mb-1">Sale</span>
                          <h5 class="mb-0">Year</h5>
                        </div>
                        <div class="media-body align-self-center ps-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up font-primary"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg></div>
                        <div class="media-body ps-2">
                          <h5 class="mb-0">$<span class="counter">963198</span></h5><span class="mb-1">+$3654(90%)          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
           
          </div>
          <!-- Container-fluid Ends-->
        </div>
<!-- Container-fluid Ends-->
</div>

<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>

<script src="<?= base_url('assets'); ?>/js/chart/apex-chart/apex-chart.js"></script>
<script>
    var isRender = false;
    var chart;
    $(document).ready(function() {

        requestDataBeranda();
        function requestDataBeranda() {
            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/dataBeranda",
                data: $('#formChart').serialize(),
                dataType: "JSON",
                success: function(res) {
                  $('.jlhPengguna').html(res.card.jlhPengguna);
                  $('.jlhProduk').html(res.card.jlhProduk);
                  $('.jlhStokSedikit').html(res.card.jlhStokSedikit);
                  $('.jlhStokHabis').html(res.card.jlhStokHabis);
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $('#btnLihat').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Lihat');
                },
                complete: function(res) {
                    $('#btnLihat').removeAttr('disabled').html('<i class="fa fa-search"></i> Lihat');
                }
            });
        }
    });
</script>
<?= $this->endSection(); ?>