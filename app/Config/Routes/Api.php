<?php

$route->resource("user", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("user/register", 'Api\User::register');
$route->put("user", 'Api\User::update');

$route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
$route->resource("kategori", ['controller' => 'Api\KAtegori', 'only' => ['index', 'show']]);
$route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);