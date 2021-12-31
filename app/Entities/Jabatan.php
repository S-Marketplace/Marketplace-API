<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Jabatan extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'jbtnId',
        'nama' => 'jbtnNama',
        'createdAt' => 'jbtnCreatedAt',
        'updatedAt' => 'jbtnUpdatedAt',
        'deletedAt' => 'jbtnDeletedAt',
    ];

    protected $show = [
        'id',
        'nama',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
