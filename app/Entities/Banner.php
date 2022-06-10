<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Banner extends MyEntity
{
  protected $datamap = [
    'id' => 'bnrId',
    'deskripsi' => 'bnrDeskripsi',
    'gambar' => 'bnrGambar',
    'url' => 'bnrUrl',
    'jenis' => 'bnrJenis',
    'kategoriId' => 'bnrKategoriId',
    'produkId' => 'bnrProdukId',
    'type' => 'bnrType',
    'createdAt' => 'bnrCreatedAt',
    'updatedAt' => 'bnrUpdatedAt',
    'deletedAt' => 'bnrDeletedAt',
  ];

  protected $show = [
    'id',
    'deskripsi',
    'gambar',
    'url',
    'jenis',
    'type',
    'kategoriId',
    'produkId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
