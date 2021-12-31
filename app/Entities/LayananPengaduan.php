<?php

namespace App\Entities;

use App\Entities\MyEntity;

class LayananPengaduan extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'pgdId',
        'nama' => 'pgdNama',
        'link' => 'pgdLink',
        'icon' => 'pgdIcon',
        'color' => 'pdgColor',
        'createdAt' => 'pgdCreatedAt',
        'updatedAt' => 'pgdUpdatedAt',
        'deletedAt' => 'pgdDeletedAt',
    ];

    protected $show = [
        'id',
        'nama',
        'link',
        'icon',
        'color',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
