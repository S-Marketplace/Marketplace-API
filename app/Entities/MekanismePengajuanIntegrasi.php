<?php

namespace App\Entities;

use App\Entities\MyEntity;

class MekanismePengajuanIntegrasi extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'mpiId',
        'mekanisme' => 'mpiMekanisme',
        'createdAt' => 'mpiCreatedAt',
        'updatedAt' => 'mpiUpdatedAt',
        'deletedAt' => 'mpiDeletedAt',
    ];

    protected $show = [
        'id',
        'mekanisme',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
