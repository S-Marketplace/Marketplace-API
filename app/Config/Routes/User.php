<?php

$route->resource("data", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("register", 'Api\User::register');

$route->post("top_up/top_up_saldo", 'Api\TopUp::topUpSaldo');
$route->get("keranjang", 'Api\Keranjang::index');
$route->get("profile", 'Api\User::getMyProfile');

$route->get("saldo", 'Api\User::getMyProfile');
$route->get("saldo/riwayat", 'Api\UserSaldo::index');