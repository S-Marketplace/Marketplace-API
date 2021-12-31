<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Agama extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'agmrId',
        'nama' => 'agmrNama',
        'createdAt' => 'agmrCreatedAt',
        'updatedAt' => 'agmrUpdatedAt',
        'deletedAt' => 'agmrDeletedAt',
    ];

    protected $show = [
        'id',
        'nama',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
