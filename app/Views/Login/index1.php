<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Login with Background Image - Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
        + Bitcoin Dashboard</title>
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
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/app.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets'); ?>/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="<?= base_url('app-assets'); ?>/images/logo/logo-dark.png" alt="branding logo">
                                    </div>
                                </div>
                                <div class="card-content">

                                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                        <span>LOGIN
                                        </span>
                                    </p>
                                    <div class="card-body">
                                        <form class="form-horizontal" id="form">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="user-name" name="username" placeholder="Your Username" required="" autocomplete="off" value="bawaihi">
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control" id="user-password" name="password" placeholder="Enter Password" required="" autocomplete="off" value="bawaihi">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <div class="alert alert-danger errorMessage" style="display: none"></div>
                                        </form>
                                        <button id="login" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url('app-assets'); ?>/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?= base_url('app-assets'); ?>/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('app-assets'); ?>/vendors/js/extensions/polyfill.min.js"></script>
    <script src="<?= base_url('app-assets'); ?>/js/scripts/extensions/ex-component-sweet-alerts.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN MODERN JS-->
    <script src="<?= base_url('app-assets'); ?>/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?= base_url('app-assets'); ?>/js/core/app.js" type="text/javascript"></script>
    <!-- END MODERN JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?= base_url('app-assets'); ?>/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->

    <script>
        $(document).ready(function() {
            $('#login').click(function(e) {
                e.preventDefault();
                login();
            });

            function login() {
                $.ajax({
                    type: "POST",
                    url: "<?= current_url() ?>",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(res) {
                        if (res.code == 200) {
                            window.location = res.data.redirect;
                        } else {
                            $('.errorMessage').show().html(res.message);
                        }
                    },
                    beforeSend: function() {
                        $('#login').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                    },
                    fail: function() {
                        Swal.fire('Error', "Server gagal merespon", 'error');
                    },
                    complete: function() {
                        $('#login').removeAttr('disabled').html('Login');
                    }
                });
            }

        });
    </script>
</body>

</html>