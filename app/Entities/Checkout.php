<?php namespace App\Entities;
use App\Entities\MyEntity;

class Checkout extends MyEntity
{
  protected $casts = [
    'pembayaran' => 'json',
    'kurir' => 'json',
    'detail' => 'json',
    'alamat' => 'json',
];

    protected $datamap = [
        'id' => 'cktId',
        'status' => 'cktStatus',
        'catatan' => 'cktCatatan',
        'alamatId' => 'cktAlamatId',
        'createdAt' => 'cktCreatedAt',
        'updatedAt' => 'cktUpdatedAt',
        'deletedAt' => 'cktDeletedAt',
    ];

    protected $show = [
		'id',
		'status',
		'catatan',
		'alamatId',
		'createdAt',
		'updatedAt',
		'deletedAt',
    'pembayaran',
    'kurir',
    'detail',
    'alamat',
    ];
}