<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid pt-4">

        <div class="row">
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <a href="<?= base_url('AntrianKunjungan') ?>">
                    <div class="card o-hidden">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="bell"></i></div>
                                <div class="media-body"><span class="m-0">Antrian Kunjungan hari ini</span>
                                    <h4 class="mb-0 counter"><span class="counter kunjunganHariIni">0</span></h4><i class="icon-bg" data-feather="bell"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <a href="<?= base_url('AntrianPenitipan') ?>">
                    <div class="card o-hidden">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="archive"></i></div>
                                <div class="media-body"><span class="m-0">Antrian Penitipan hari ini</span>
                                    <h4 class="mb-0 counter"><span class="counter penitipanHariIni">0</span></h4><i class="icon-bg" data-feather="archive"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <a href="<?= base_url('Napi') ?>">
                    <div class="card o-hidden">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="user"></i></div>
                                <div class="media-body"><span class="m-0">Jumlah Narapidana</span>
                                    <h4 class="mb-0 counter"><span class="counter jumlahNapi">0</span></h4><i class="icon-bg" data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 xl-100 dashboard-sec box-col-12">
                <div class="card earning-card">
                    <div class="card-body p-0">
                        <div class="row m-0">
                            <div class="col-xl-12 earning-content p-0" style="padding: 30px;">
                                <form id="formChart" class="row m-0 chart-left align-items-center pl-4 pr-4 pb-4">
                                    <div class="col-xl-3 mb-1">
                                        <select name="filter" id="filter" class="form-control">
                                            <!-- <option value="hari">Harian</option> -->
                                            <option value="bulan">Bulanan</option>
                                            <option value="tahun">Tahunan</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-1">
                                        <input class="form-control" id="dari" type="text">
                                        <input class="form-control" name="dari" type="hidden">
                                    </div>
                                    <div class=" col-xl-1 text-center">
                                        <label class="text-center">sampai</label>
                                    </div>
                                    <div class="col-xl-3 mb-1">
                                        <input class="form-control" id="sampai" type="text">
                                        <input class="form-control" name="sampai" type="hidden">
                                    </div>
                                    <div class="col-xl-2 mb-1 pl-3">
                                        <button class="btn btn-primary btn-block" id="btnLihat" type="submit"><i class="fa fa-search"></i> Lihat</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-12 p-0">
                                <div class="chart-right">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card-body p-0">
                                                <div class="current-sale-container">
                                                    <div id="chart-currently"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row border-top m-0">
                                    <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
                                        <div class="media p-0">
                                            <div class="media-left"><i class="icofont icofont-crown"></i></div>
                                            <div class="media-body">
                                                <h6>Referral Earning</h6>
                                                <p>$5,000.20</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-6">
                                        <div class="media p-0">
                                            <div class="media-left bg-secondary"><i class="icofont icofont-heart-alt"></i></div>
                                            <div class="media-body">
                                                <h6>Cash Balance</h6>
                                                <p>$2,657.21</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-12 pe-0">
                                        <div class="media p-0">
                                            <div class="media-left"><i class="icofont icofont-cur-dollar"></i></div>
                                            <div class="media-body">
                                                <h6>Sales forcasting</h6>
                                                <p>$9,478.50 </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
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
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>

<script src="<?= base_url('assets'); ?>/js/chart/apex-chart/apex-chart.js"></script>
<script>
    var isRender = false;
    var chart;
    $(document).ready(function() {

        let oneYearFromNow = new Date();
        oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() - 1);

        let optHari = {
            language: 'id',
            dateFormat: 'dd MM yyyy',
            altFieldDateFormat: 'yyyy-mm-dd',
            view: 'years',
        }
        let dari = $('#dari').datepicker($.extend({
            altField: '[name="dari"]',
        }, optHari)).data('datepicker').selectDate(oneYearFromNow);

        let sampai = $('#sampai').datepicker($.extend({
            altField: '[name="sampai"]',
        }, optHari)).data('datepicker').selectDate(new Date());

        $('#filter').select2().val('bulan').trigger('change');

        requestDataBeranda();

        $('#formChart').submit(function(e) {
            e.preventDefault();
            requestDataBeranda();
        });

        function requestDataBeranda() {
            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/dataBeranda",
                data: $('#formChart').serialize(),
                dataType: "JSON",
                success: function(res) {
                    $('.kunjunganHariIni').html(res.antrianHariIni.kunjungan);
                    $('.penitipanHariIni').html(res.antrianHariIni.penitipan);
                    $('.jumlahNapi').html(res.jumlahNapi);
                    chartRender(res.dataChart.categories, res.dataChart.penitipan, res.dataChart.kunjungan)
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

        function chartRender(categories, penitipan, kunjungan) {

            if (isRender) {
                chart.destroy();
            }
            var options = {
                series: [{
                    name: 'Kunjungan',
                    data: kunjungan
                }, {
                    name: 'Penitipan',
                    data: penitipan
                }],
                chart: {
                    id: 'mychart',
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'category',
                    low: 0,
                    offsetX: 0,
                    offsetY: 0,
                    show: false,
                    categories: categories,
                    labels: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                    axisBorder: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                },
                markers: {
                    strokeWidth: 3,
                    colors: "#ffffff",
                    strokeColors: [CubaAdminConfig.primary, CubaAdminConfig.secondary],
                    hover: {
                        size: 6,
                    }
                },
                yaxis: {
                    low: 0,
                    offsetX: 0,
                    offsetY: 0,
                    show: false,
                    labels: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                    axisBorder: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0,
                        bottom: -15,
                        top: -40
                    }
                },
                colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.5,
                        stops: [0, 80, 100]
                    }
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    x: {
                        format: 'MM'
                    },
                },
            };
            chart = new ApexCharts(document.querySelector("#chart-currently"), options);
            chart.render().then(() => isRender = true);
            // isRender = chart.isRender;
        }
    });
</script>
<?= $this->endSection(); ?>