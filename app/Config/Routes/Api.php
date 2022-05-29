<?php

$route->post("user/register", 'Api\User::register');
$route->post("user/reset_password", 'Api\User::resetPassword');
$route->post("user/resend_otp_code", 'Api\User::resendOtpCode');
$route->post("user/verifikasi_otp_code", 'Api\User::verifikasiOtpCode');

$route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
$route->resource("kategori", ['controller' => 'Api\Kategori', 'only' => ['index', 'show']]);
$route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Setting', 'only' => ['index', 'show']]);
$route->resource("metode_pembayaran", ['controller' => 'Api\MetodePembayaran', 'only' => ['index', 'show']]);

$route->group("raja_ongkir", function ($route) {
    $route->get("kota", 'Api\RajaOngkir::getKota');
    $route->get("provinsi", 'Api\RajaOngkir::getProvinsi');
    $route->get("kecamatan", 'Api\RajaOngkir::getKecamatan');
    $route->get("ongkir", 'Api\RajaOngkir::getOngkir', ['filter' => 'apiFilter']);
    $route->get("status_perjalanan/(:segment)", 'Api\RajaOngkir::getStatusPerjalanan/$1', ['filter' => 'apiFilter']);
});

$route->group("background", function ($route) {
    $route->put("pembayaran_to_expired", 'BackgroundProcess::pembayaranToExpired');
});

$route->group("pulsa_bridge", function ($route) {
    $route->get("/", 'Api\PulsaBridge::index');
});

// TEST EMAIL
$route->resource("user/test_email", ['controller' => 'Api\User::TestEmail']);

$route->group("pulsa", function ($route) {
    $route->resource("kategori/kelompok", ['controller' => 'Api\Pulsa\KategoriPulsa::kelompok']);
    $route->resource("kategori", ['controller' => 'Api\Pulsa\KategoriPulsa']);
    $route->resource("produk", ['controller' => 'Api\Pulsa\ProdukPulsa']);
});
