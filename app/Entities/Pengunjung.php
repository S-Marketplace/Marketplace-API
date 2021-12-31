<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Pengunjung extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'nik' => 'pjgNik',
        'nama' => 'pjgNama',
        'namaWbp' => 'pjgNamaWbp',
        'namaAyah' => 'pjgNamaAyah',
        'createdAt' => 'pjgCreatedAt',
        'updatedAt' => 'pjgUpdatedAt',
        'deletedAt' => 'pjgDeletedAt',
    ];

    protected $show = [
        'nik',
        'nama',
        'namaWbp',
        'namaAyah',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
