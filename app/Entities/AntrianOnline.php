<?php

namespace App\Entities;

use App\Entities\MyEntity;

class AntrianOnline extends MyEntity
{
    protected $casts = [
        'pengunjung' => 'json',
        'napi' => 'json',
    ];

    protected $datamap = [
        'id' => 'antId',
        'no' => 'antNo',
        'nik' => 'antNik',
        'tanggal' => 'antTanggal',
        'jenis' => 'antJenis',
        'deviceId' => 'antDeviceId',
        'napiId' => 'antNapiId',
        'isCall' => 'antIsCall',
        'keterangan' => 'antKeterangan',
        'createdAt' => 'antCreatedAt',
        'updatedAt' => 'antUpdatedAt',
        'deletedAt' => 'antDeletedAt',
    ];

    protected $show = [
        'id',
        'no',
        'nik',
        'tanggal',
        'jenis',
        'napiId',
        'isCall',
        'deviceId',
        'keterangan',
        'createdAt',
        'updatedAt',
        'deletedAt',
        'pengunjung',
        'napi',
    ];
}
