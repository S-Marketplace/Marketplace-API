<?php

$route->resource("user_integrasi", ['controller' => 'Api\UserIntegrasi', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("user_integrasi/reset_password", 'Api\UserIntegrasi::resetPassword');
$route->put("user_integrasi", 'Api\UserIntegrasi::update');

$route->resource("antrian", ['controller' => 'Api\Antrian', 'only' => ['index', 'show', 'create']]);
$route->put("antrian", 'Api\Antrian::update');

$route->resource("pengajuan_integrasi", ['controller' => 'Api\PengajuanIntegrasi', 'only' => ['index', 'show', 'create']]);
$route->resource("mekanisme_pengajuan_integrasi", ['controller' => 'Api\MekanismePengajuanIntegrasi', 'only' => ['index', 'show']]);

$route->resource("jumlah_penghuni", ['controller' => 'Api\JumlahPenghuni', 'only' => ['index', 'show']]);
$route->resource("jadwal_umum", ['controller' => 'Api\JadwalUmum', 'only' => ['index', 'show']]);
$route->resource("jadwal_khusus", ['controller' => 'Api\JadwalKhusus', 'only' => ['index', 'show']]);
$route->resource("layanan_pengaduan", ['controller' => 'Api\LayananPengaduan', 'only' => ['index', 'show']]);
$route->resource("berita", ['controller' => 'Api\Berita', 'only' => ['index', 'show']]);
$route->resource("pegawai", ['controller' => 'Api\Pegawai', 'only' => ['index', 'show']]);
$route->resource("napi", ['controller' => 'Api\Napi', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Setting', 'only' => ['index', 'show']]);
$route->resource("mekanisme", ['controller' => 'Api\Mekanisme', 'only' => ['index', 'show']]);
$route->resource("foto_beranda", ['controller' => 'Api\FotoBeranda', 'only' => ['index', 'show']]);
$route->resource("sosmed", ['controller' => 'Api\Sosmed', 'only' => ['index', 'show']]);
$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("produk",['controller'=>'Api\Produk','only'=>['index','show','create','update','delete']]);
$route->put("produk",'Api\Produk::update');
$route->delete("produk",'Api\Produk::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');

$route->resource("kategori",['controller'=>'Api\Kategori','only'=>['index','show','create','update','delete']]);
$route->put("kategori",'Api\Kategori::update');
$route->delete("kategori",'Api\Kategori::delete');
