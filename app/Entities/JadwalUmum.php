<?php

namespace App\Entities;

use App\Entities\MyEntity;

class JadwalUmum extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'jduId',
        'hari' => 'jduNamaHari',
        'jamMulai' => 'jduJamMulai',
        'jamSelesai' => 'jduJamSelesai',
        'createdAt' => 'jduCreatedAt',
        'updatedAt' => 'jduUpdatedAt',
        'deletedAt' => 'jduDeletedAt',
    ];

    protected $show = [
        'id',
        'hari',
        'jamMulai',
        'jamSelesai',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
