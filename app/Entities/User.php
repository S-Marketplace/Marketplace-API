<?php namespace App\Entities;
use App\Entities\MyEntity;

class User extends MyEntity
{
    protected $datamap = [
        'email' => 'usrEmail',
        'nama' => 'usrNama',
        'password' => 'usrPassword',
        'saldo' => 'usrSaldo',
        'isActive' => 'usrIsActive',
        'createdAt' => 'usrCreatedAt',
        'updatedAt' => 'usrUpdatedAt',
        'deletedAt' => 'usrDeletedAt',
    ];

    protected $show = [
		'email',
		'nama',
		'password',
		'saldo',
		'isActive',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}