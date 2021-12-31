<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Sosmed extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'sosId',
        'nama' => 'sosNama',
        'link' => 'sosLink',
        'icon' => 'sosIcon',
        'keterangan' => 'sosKeterangan',
        'warna' => 'sosWarna',
        'createdAt' => 'sosCreatedAt',
        'updatedAt' => 'sosUpdatedAt',
        'deletedAt' => 'sosDeletedAt',
    ];

    protected $show = [
        'id',
        'nama',
        'link',
        'icon',
        'keterangan',
        'warna',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
