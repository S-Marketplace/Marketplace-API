<?php

$route->post("user/register", 'Api\User::register');

$route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
$route->resource("kategori", ['controller' => 'Api\Kategori', 'only' => ['index', 'show']]);
$route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);
