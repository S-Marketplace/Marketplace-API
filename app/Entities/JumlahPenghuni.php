<?php

namespace App\Entities;

use App\Entities\MyEntity;

class JumlahPenghuni extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'id' => 'pghId',
        'tanggal' => 'pghTanggal',
        'kapasitas' => 'pghKapasitas',
        'napiDL' => 'pghNapiDL',
        'napiDP' => 'pghNapiDP',
        'napiTD' => 'pghNapiTD',
        'napiAL' => 'pghNapiAL',
        'napiAP' => 'pghNapiAP',
        'napiTA' => 'pghNapiTA',
        'napiTotal' => 'pghNapiTotal',
        'tahananDL' => 'pghTahananDL',
        'tahananDP' => 'pghTahananDP',
        'tahananTD' => 'pghTahananTD',
        'tahananAL' => 'pghTahananAL',
        'tahananAP' => 'pghTahananAP',
        'tahananTA' => 'pghTahananTA',
        'tahananTotal' => 'pghTahananTotal',
        'createdAt' => 'pghCreatedAt',
        'updatedAt' => 'pghUpdatedAt',
        'deletedAt' => 'pghDeletedAt',
    ];

    protected $show = [
        'id',
        'tanggal',
        'kapasitas',
        'napiDL',
        'napiDP',
        'napiTD',
        'napiAL',
        'napiAP',
        'napiTA',
        'napiTotal',
        'tahananDL',
        'tahananDP',
        'tahananTD',
        'tahananAL',
        'tahananAP',
        'tahananTA',
        'tahananTotal',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
