<?php

$route->resource("data", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("register", 'Api\User::register');

$route->resource("alamat", ['controller' => 'Api\UserAlamat', 'only' => ['index', 'show', 'create', 'update']]);

$route->post("top_up/top_up_saldo", 'Api\TopUp::topUpSaldo');
$route->get("keranjang", 'Api\Keranjang::index');
$route->post("keranjang", 'Api\Keranjang::ubahKeranjang');
$route->get("profile", 'Api\User::getMyProfile');

$route->get("saldo", 'Api\User::getMyProfile');
$route->get("saldo/riwayat", 'Api\UserSaldo::index');