<?php namespace App\Entities;
use App\Entities\MyEntity;

class CheckoutKurir extends MyEntity
{
    protected $datamap = [
        'id' => 'ckurId',
        'checkoutId' => 'ckurCheckoutId',
        'kurir' => 'ckurKurir',
        'nama' => 'ckurNama',
        'service' => 'ckurService',
        'deskripsi' => 'ckurDeskripsi',
        'cost' => 'ckurCost',
        'noResi' => 'ckurNoResi',
        'tipePengiriman' => 'ckurTipePengiriman',
        'createdAt' => 'ckurCreatedAt',
        'updatedAt' => 'ckurUpdatedAt',
        'deletedAt' => 'ckurDeletedAt',
    ];

    protected $show = [
		'id',
		'checkoutId',
		'kurir',
		'nama',
		'service',
		'deskripsi',
		'cost',
		'noResi',
		'tipePengiriman',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}