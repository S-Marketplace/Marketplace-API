<?php

$route->resource("user", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("user/register", 'Api\User::register');
$route->put("user", 'Api\User::update');
