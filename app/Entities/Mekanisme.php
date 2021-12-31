<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Mekanisme extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'mksId',
        'foto' => 'mksFoto',
        'kode' => 'mksKode',
        'nama' => 'mksNama',
        'createdAt' => 'mksCreatedAt',
        'updatedAt' => 'mksUpdatedAt',
        'deletedAt' => 'mksDeletedAt',
    ];

    protected $show = [
        'id',
        'kode',
        'foto',
        'nama',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
