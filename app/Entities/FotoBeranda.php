<?php

namespace App\Entities;

use App\Entities\MyEntity;

class FotoBeranda extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'fberId',
        'foto' => 'fberFoto',
        'isActive' => 'fberIsActive',
        'createdAt' => 'fberCreatedAt',
        'updatedAt' => 'fberUpdatedAt',
        'deletedAt' => 'fberDeletedAt',
    ];

    protected $show = [
        'id',
        'foto',
        'isActive',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
