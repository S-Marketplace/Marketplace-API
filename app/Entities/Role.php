<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Role extends MyEntity
{
    protected $casts = [];

    protected $datamap = [
        'username' => 'rolUsername',
        'aplikasi' => 'rolAplikasi',
        'role' => 'rolRole',
        'createdAt' => 'rolCreatedAt',
        'updatedAt' => 'rolUpdatedAt',
        'deletedAt' => 'rolDeletedAt',
    ];

    protected $show = [
        'username',
        'aplikasi',
        'role',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];
}
