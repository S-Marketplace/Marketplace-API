<?php namespace App\Entities;
use App\Entities\MyEntity;

class Keranjang extends MyEntity
{
  protected $casts = [
    'products'=>'json',
    'checkout'=>'json',
    'alamat'=>'json',
  ];

    protected $datamap = [
        'id' => 'krjId',
        'produkId' => 'krjProdukId',
        'variantId' => 'krjVariantId',
        'quantity' => 'krjQuantity',
        'pesan' => 'krjPesan',
        'checkoutId' => 'krjCheckoutId',
        'createdAt' => 'krjCreatedAt',
        'updatedAt' => 'krjUpdatedAt',
        'deletedAt' => 'krjDeletedAt',
        'userEmail' => 'krjUserEmail',
        'isChecked' => 'krjIsChecked',
    ];

    protected $show = [
		'id',
		'produkId',
		'variantId',
		'quantity',
		'pesan',
    'products',
    'checkout',
    'alamat',
		'checkoutId',
		'createdAt',
		'updatedAt',
		'deletedAt',
		'userEmail',
    'isChecked',
    ];
}