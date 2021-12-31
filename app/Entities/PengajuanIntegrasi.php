<?php

namespace App\Entities;

use App\Entities\MyEntity;

class PengajuanIntegrasi extends MyEntity
{
    protected $casts = [
        'napi' => 'json',
        'agama' => 'json',
        'user' => 'json',
        'statusPengajuan' => 'json',
    ];

    protected $datamap = [
        'id' => 'pintId',
        'nik' => 'pintUinNik',
        'napiId' => 'pintNapiId',
        'status' => 'pintStatus',
        'hubungan' => 'pintHubunganNapi',
        'tanggal' => 'pintTanggal',
        'createdAt' => 'pintCreatedAt',
        'updatedAt' => 'pintUpdatedAt',
        'deletedAt' => 'pintDeletedAt',
    ];

    protected $show = [
        'id',
        'nik',
        'napiId',
        'status',
        'hubungan',
        'tanggal',
        'createdAt',
        'updatedAt',
        'deletedAt',
        'napi',
        'agama',
        'user',
        'statusPengajuan',
    ];
}
