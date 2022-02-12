<?php

$route->post("user/register", 'Api\User::register');

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
});
