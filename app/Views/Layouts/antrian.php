<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/silaki/logo_fix.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/silaki/logo_fix.png') ?>" type="image/x-icon">
    <title>SILAKI</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url('assets'); ?>/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/responsive.css">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-4 p-0">
                <div class="login-card">
                    <div>
                        <div class="mb-2 text-center"><img class="img-fluid for-light" src="<?= $logo ?>" width="300px"></div>
                        <div class="login-main">
                            <h1 class="text-center">No Antrian</h1>
                            <h1 class="text-center" style="font-size: 200px;" id="noAntrian">20</h1>
                            <h3 class="text-center">Silakan menuju loket 1</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/zjYzUqKYM18?autoplay=1&mute=1&loop=1"></iframe>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?= base_url('assets'); ?>/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="<?= base_url('assets'); ?>/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="<?= base_url('assets'); ?>/js/script.js"></script>
        <!-- login js-->
        <!-- Plugin used-->
        <script>
            $(document).ready(function() {

                setInterval(function() {
                    getData();
                }, 1000);
            });

            function getData() {
                $.ajax({
                    type: "GET",
                    url: `<?= current_url() ?>/getData`,
                    dataType: "JSON",
                    success: function(res) {
                        let noAntrian = parseInt(res.antrian.no);
                        console.log(res.antrian.no, noAntrian);

                        if (noAntrian < 10) {
                            noAntrian = `00${noAntrian}`;
                        } else if (noAntrian < 100) {
                            noAntrian = `0${noAntrian}`;
                        }

                        $('#noAntrian').html(noAntrian)
                    }
                });
            }
        </script>
    </div>
</body>

</html>