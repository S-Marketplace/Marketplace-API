<?php namespace App\Entities;
use App\Entities\MyEntity;

class User extends MyEntity
{
    protected $casts = [
        'alamat'=>'json',
    ];

    protected $datamap = [
        'email' => 'usrEmail',
        'nama' => 'usrNama',
        'password' => 'usrPassword',
        'saldo' => 'usrSaldo',
        'isActive' => 'usrIsActive',
        'createdAt' => 'usrCreatedAt',
        'updatedAt' => 'usrUpdatedAt',
        'deletedAt' => 'usrDeletedAt',
        'firebaseToken' => 'usrFirebaseToken',
        'pin' => 'usrPin',
        'noHp' => 'usrNoHp',
        'noWa' => 'usrNoWa',
        'activeCode' => 'usrActiveCode',
        'otpCode' => 'usrOtpCode',
        'latitude' => 'usrLatitude',
        'longitude' => 'usrLongitude',
    ];

    protected $show = [
		'email',
		'nama',
		// 'password',
		'saldo',
		'isActive',
		'createdAt',
		'updatedAt',
		'deletedAt',
		'firebaseToken',
		'pin',
        'noHp',
        'noWa',
        'activeCode',
        'otpCode',
        'latitude',
        'longitude',
        'alamat',
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