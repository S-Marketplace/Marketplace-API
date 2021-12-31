<?php

namespace App\Entities;

use App\Entities\MyEntity;

class StatusPengajuan extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'stpeId',
        'status' => 'stpeStatus',
        'createdAt' => 'stpeCreatedAt',
        'updatedAt' => 'stpeUpdatedAt',
        'deletedAt' => 'stpeDeletedAt',
    ];

    protected $show = [
        'id',
        'status',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
