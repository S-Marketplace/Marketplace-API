<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Berita extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'brtId',
        'judul' => 'brtJudul',
        'tanggal' => 'brtTanggal',
        'konten' => 'brtKonten',
        'gambar' => 'brtGambar',
        'createdAt' => 'brtCreatedAt',
        'updatedAt' => 'brtUpdatedAt',
        'deletedAt' => 'brtDeletedAt',
    ];

    protected $show = [
        'id',
        'judul',
        'tanggal',
        'konten',
        'gambar',
        'createdAt',
        'updatedAt',
    ];
}
