<?php

namespace App\Entities;

use App\Entities\MyEntity;

class UserIntegrasi extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'nik' => 'uinNik',
        'nama' => 'uinNama',
        'noHp' => 'uinNoHp',
        'email' => 'uinEmail',
        'tempatLahir' => 'uinTempatLahir',
        'tanggalLahir' => 'uinTanggalLahir',
        'fotoKtp' => 'uinFotoKtp',
        'fotoSelfie' => 'uinFotoSelfie',
        'alamat' => 'uinAlamat',
        'umur' => 'uinUmur',
        'pekerjaan' => 'uinPekerjaan',
        'createdAt' => 'uinCreatedAt',
        'updatedAt' => 'uinUpdatedAt',
        'deletedAt' => 'uinDeletedAt',
    ];

    protected $show = [
        'nik',
        'nama',
        'noHp',
        'email',
        'tempatLahir',
        'tanggalLahir',
        'fotoKtp',
        'fotoSelfie',
        'alamat',
        'umur',
        'pekerjaan',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
