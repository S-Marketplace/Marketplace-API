<?php

namespace App\Entities;

use App\Entities\MyEntity;

class AntrianSekarang extends MyEntity
{
    protected $casts = [
        'antrian' => 'json',
    ];

    protected $datamap = [
        'id' => 'ansId',
        'antrianId' => 'ansAntrianId',
        'createdAt' => 'antCreatedAt',
        'updatedAt' => 'antUpdatedAt',
        'deletedAt' => 'antDeletedAt',
    ];

    protected $show = [
        'id',
        'antrianId',
        'createdAt',
        'updatedAt',
        'deletedAt',

        'antrian',
    ];
}
