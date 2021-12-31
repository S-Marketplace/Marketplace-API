<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Pegawai extends MyEntity
{
    protected $casts = [
        'jabatan' => 'json'
    ];

    protected $datamap = [
        'nip' => 'pgwNip',
        'nik' => 'pgwNik',
        'nama' => 'pgwNama',
        'status' => 'pgwStatus',
        'jk' => 'pgwJk',
        'foto' => 'pgwFoto',
        'createdAt' => 'pgwCreatedAt',
        'updatedAt' => 'pgwUpdatedAt',
        'deletedAt' => 'pgwDeletedAt',
    ];

    protected $show = [
        'nip',
        'nik',
        'nama',
        'status',
        'jk',
        'foto',
        'createdAt',
        'updatedAt',
        'deletedAt',

        'jabatan',
    ];
}
