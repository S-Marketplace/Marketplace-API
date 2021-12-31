<?php

namespace App\Entities;

use App\Entities\MyEntity;

class JadwalKhusus extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'jdkId',
        'tanggal' => 'jdkTanggal',
        'jamMulai' => 'jdkJamMulai',
        'jamSelesai' => 'jdkJamSelesai',
        'keterangan' => 'jdkKeterangan',
        'createdAt' => 'jdkCreatedAt',
        'updatedAt' => 'jdkUpdatedAt',
        'deletedAt' => 'jdkDeletedAt',
    ];

    protected $show = [
        'id',
        'tanggal',
        'jamMulai',
        'keterangan',
        'jamSelesai',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
