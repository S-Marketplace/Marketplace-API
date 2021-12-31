<?php

namespace App\Entities;

use App\Entities\MyEntity;

class User extends MyEntity
{
    protected $casts = [
        'role' => 'json'
    ];

    protected $datamap = [
        'username' => 'usrUsername',
        'password' => 'usrPassword',
        'nama' => 'usrNama',
        'createdAt' => 'usrCreatedAt',
        'updatedAt' => 'usrUpdatedAt',
        'deletedAt' => 'usrDeletedAt',
    ];

    protected $show = [
        'username',
        'password',
        'nama',
        'createdAt',
        'updatedAt',
        'deletedAt',

        'role',
    ];

    public function hashPassword($password)
    {
        $key = '219404f55e15877401282a82cb16d6b7';
        return md5(md5($password) . $key);
    }

    public function verifyPassword($password)
    {
        return $this->password === $this->hashPassword($password);
    }
}
