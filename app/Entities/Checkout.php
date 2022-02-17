<?php namespace App\Entities;
use App\Entities\MyEntity;

class Checkout extends MyEntity
{
  protected $casts = [
    'pembayaran' => 'json',
];

    protected $datamap = [
        'id' => 'cktId',
        'status' => 'cktStatus',
        'kurir' => 'cktKurir',
        'noResiKurir' => 'cktNoResiKurir',
        'catatan' => 'cktCatatan',
        'alamatId' => 'cktAlamatId',
        'createdAt' => 'cktCreatedAt',
        'updatedAt' => 'cktUpdatedAt',
        'deletedAt' => 'cktDeletedAt',
    ];

    protected $show = [
		'id',
		'status',
		'kurir',
		'noResiKurir',
		'catatan',
		'alamatId',
		'createdAt',
		'updatedAt',
		'deletedAt',
    'pembayaran',
    ];
}