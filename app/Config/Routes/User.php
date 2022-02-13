<?php

$route->resource("data", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("register", 'Api\User::register');

$route->resource("alamat", ['controller' => 'Api\UserAlamat', 'only' => ['index', 'show', 'create', 'update']]);

$route->post("top_up/top_up_saldo", 'Api\TopUp::topUpSaldo');

$route->group("keranjang", function ($route) {
    $route->get("/", 'Api\Keranjang::index');
    $route->post("/", 'Api\Keranjang::ubahKeranjang');
    $route->post("checkout", 'Api\Keranjang::checkout');
});

$route->get("profile", 'Api\User::getMyProfile');

$route->get("saldo", 'Api\User::getMyProfile');
$route->get("saldo/riwayat", 'Api\UserSaldo::index');