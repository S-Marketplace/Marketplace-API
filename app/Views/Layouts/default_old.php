<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr" style="overflow: scroll;">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>SILAKI</title>
    <link rel="apple-touch-icon" href="<?= base_url('app-assets'); ?>/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets'); ?>/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <script src="<?= base_url('assets'); ?>/js/vendors/flatpickr/flatpickr.js"></script>
    <script src="<?= base_url('assets'); ?>/js/vendors/flatpickr/flatpickr.id.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/vendors/css/forms/selects/select2.min.css">

    <?= $this->renderSection('css'); ?>
    <!-- END VENDOR CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/components.css">
    <!-- END: Theme CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/app.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/plugins/forms/checkboxes-radios.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendors/flatpickr/flatpickr.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <!-- END Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN : Custom CSS -->
<style>
    th.dt-tengah,
    td.dt-tengah {
        text-align: center;
    }
</style>
<!-- END : Custom CSS -->
<?php
$nama = @$session['nama'];
$username = @$session['username'];
?>

<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header expanded">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" href="#">
                            <i class="ft-menu font-large-1"></i>
                        </a>
                    </li>
                    <li class="nav-item mr-auto">
                        <a class="navbar-brand" href="index.html">
                            <img class="brand-logo" alt="modern admin logo" src="<?= base_url('app-assets'); ?>/images/logo/logo.png">
                            <h3 class="brand-text">SILAKI</h3>
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block nav-toggle">
                        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                            <i class="toggle-icon icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon feather ft-toggle-right" data-ticon="ft-toggle-right"></i>
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
                            <i class="la la-ellipsis-v"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1 user-name text-bold-700"><?= $nama ?></span>
                                <span class="avatar avatar-online">
                                    <img src="<?= base_url('app-assets'); ?>/images/portrait/small/avatar-s-19.png" alt="avatar">
                                    <i></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?= base_url('Login/logout') ?>">
                                    <i class="ft-power">
                                    </i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" id="sideMenu">
        <div class="shadow-bottom">
        </div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <?php if (isset($MENUS)) {
                    foreach ($MENUS as $firstLevel) {
                        $class = isset($firstLevel['class']) ? $firstLevel['class'] : "nav-item";
                        if (isset($ACTIVE_URL))
                            $class .= (isset($firstLevel['url']) && $firstLevel['url'] == $ACTIVE_URL) ? " active" : "";
                        echo "<li class='$class'>";
                        if (isset($firstLevel['url']))
                            echo "<a href='" . base_url($firstLevel['url']) . "'>
                            <i class='$firstLevel[icon]'></i> $firstLevel[title]</a>";
                        else
                            echo "<span>$firstLevel[title]</span>";

                        if (isset($firstLevel['children'])) {
                            echo "<ul class='menu-content'>";
                            foreach ($firstLevel['children'] as $secondLevel) {
                                $class = "";
                                if (isset($ACTIVE_URL))
                                    $class = (isset($secondLevel['url']) && $secondLevel['url'] == $ACTIVE_URL) ? " active" : "";

                                echo "<li class='$class'>";
                                echo "<a href='" . base_url($secondLevel['url']) . "'>
                                <i class='feather icon-circle'>
                                </i> $secondLevel[title]</a>";

                                if (isset($secondLevel['children'])) {
                                    echo "<ul class='menu-content'>";
                                    foreach ($secondLevel['children'] as $thirdLevel) {
                                        $class = "";
                                        if (isset($ACTIVE_URL))
                                            $class = (isset($thirdLevel['url']) && $thirdLevel['url'] == $ACTIVE_URL) ? " active" : "";

                                        echo "<li class='$class'>
                                        <a href='" . base_url($thirdLevel['url']) . "'>
                                        <i class='feather icon-minus'>
                                        </i> $thirdLevel[title]</a>
                                        </li>";
                                    }
                                    echo "</ul>";
                                }
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                        echo "</li>";
                    }
                }; ?>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <?= $this->renderSection('content'); ?>
    <!-- END: Content-->

    <div class="sidenav-overlay">
    </div>
    <div class="drag-target">
    </div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT </a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i class="ft-heart pink">
                </i>
            </span>
        </p>
    </footer>
    <!-- END: Footer-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url('app-assets'); ?>/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?= base_url('assets'); ?>/js/vendors/moment.js"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/extensions/polyfill.min.js"></script>
    <script src="<?= base_url('app-assets'); ?>/js/scripts/extensions/ex-component-sweet-alerts.min.js"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/buttons.flash.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/jszip.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/tables/buttons.print.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/forms/select/select2.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/js/vendors/flatpickr/flatpickr.min.css">
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN MODERN JS-->
    <script src="<?= base_url('app-assets'); ?>/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/js/core/app.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/js/scripts/customizer.js" type="text/javascript"></script>
    <!-- END MODERN JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?= base_url('app-assets'); ?>/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->

    <!-- BEGIN: Custom App-->
    <script src="<?= base_url('assets'); ?>/app/custom.js"></script>
    <!-- END: Custom App-->

    <script>
        $.fn.select2.defaults.set('language', 'id');

        $(function() {

            $('#sideMenu').on({
                mouseenter: function() {
                    $('#textLogout').show('fast');
                },
                mouseleave: function() {
                    if ($('#buttonToggle').hasClass("icon-circle")) {
                        $('#textLogout').hide('fast');
                    }
                }
            });

            $('body').click(function() {
                $('[data-toggle="tooltip"]').tooltip("hide");
            });

            $(document).on('mouseover', '.manual', function() {
                $(this).popover('show');
            });
            $(document).on('mouseout', '.manual', function() {
                $(this).popover('hide');
            });

            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"customSearching">rltip',
                initComplete: function(settings, json) {
                    $("div.customSearching").html(`<div class="col-md-4 col-12 pull-right mb-1">
                        <fieldset>
                            <div class="input-group">
                                <input type="text" class="form-control" id="field-cari" placeholder="Pencarian" aria-describedby="button-addon2">
                                <div class="input-group-append" id="button-addon2">
                                    <button class="btn btn-primary waves-effect waves-light" id="btn-cari" type="button">
                                    <i class="fa fa-search">
                                    </i>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>`);
                },
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip({
                        trigger: "hover",
                        placement: "top",
                    });
                },
            });
        })

        $(document).ready(function() {
            $('#semester').on('change', function() {
                let semester = $(this).val();
                console.log('SEMESTER', semester);

                $.post("<?= base_url('session'); ?>/semester", {
                    'semester': semester
                }, function(res) {
                    if (typeof grid != 'undefined') {
                        grid.draw(false);
                    }
                    if (typeof gridAjax != 'undefined') {
                        gridAjax.ajax.reload();
                    }
                    if (typeof oTable != 'undefined') {
                        oTable.ajax.reload();
                    }
                }).fail(function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                }).always(function() {
                    // app.form.isSaving = false;
                })
            });

            $(document).on('keyup', '#field-cari', function(e) {
                var code = e.which;
                if (code == 13)
                    e.preventDefault();
                if (code == 13 || code == 188 || code == 186) {
                    grid.search($("#field-cari").val()).draw();
                }
            });

            $(document).on('click', '#btn-cari', function() {
                grid.search($("#field-cari").val()).draw();
            });
        });
    </script>

    <!-- BEGIN: Page JS-->
    <?= $this->renderSection('js'); ?>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>