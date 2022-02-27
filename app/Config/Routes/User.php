<?php

$route->resource("data", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("register", 'Api\User::register');

$route->group("alamat", function ($route) {
    $route->resource("/", ['controller' => 'Api\UserAlamat', 'only' => ['index', 'show', 'create', 'update']]);
    $route->put("/", 'Api\UserAlamat::update');
    $route->post("active/(:segment)", 'Api\UserAlamat::setActive/$1');
});

$route->post("top_up/top_up_saldo", 'Api\TopUp::topUpSaldo');

$route->group("keranjang", function ($route) {
    $route->get("/", 'Api\Keranjang::index');
    $route->post("/", 'Api\Keranjang::ubahKeranjang');
    $route->post("checkout", 'Api\Keranjang::checkout');
    $route->post("checked", 'Api\Keranjang::checkedKeranjang');
});

$route->group("checkout", function ($route) {
    $route->get("/", 'Api\Checkout::index');
    $route->post("/", 'Api\Checkout::checkout');
    $route->get("keranjang/(:segment)", 'Api\Checkout::detailKeranjang/$1');
});

$route->group("notifikasi", function ($route) {
    $route->get("/", 'Api\Notifikasi::index');
    $route->get("my_notif", 'Api\Notifikasi::getNotif');
});

$route->get("profile", 'Api\User::getMyProfile');

$route->get("saldo", 'Api\User::getMyProfile');
$route->get("saldo/riwayat", 'Api\UserSaldo::index');