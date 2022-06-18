<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Notifikasi extends MyEntity
{
  protected $casts = [
    'produk' => 'json',
    'penerima' => 'json',
  ];

  protected $datamap = [
    'id' => 'notifId',
    'judul' => 'notifJudul',
    'pesan' => 'notifPesan',
    'gambar' => 'notifGambar',
    'type' => 'notifType',
  ];

  protected $show = [
    'id',
    'judul',
    'pesan',
    'gambar',
    'type',
    'produk',
    'penerima',
  ];
}
