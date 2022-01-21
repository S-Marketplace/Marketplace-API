<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukBeranda extends MyEntity
{
    protected $casts = [
        'products'=>'json',
        'anjay'=>'json',
    ];

    protected $datamap = [
        'id' => 'pbId',
        'banner' => 'pbBanner',
        'judul' => 'pbJudul',
        'deskripsi' => 'pbDeskripsi',
        'updatedAt' => 'pbUpdatedAt',
        'deletedAt' => 'pbDeletedAt',
        'createdAt' => 'pbCreatedAt',
    ];

    protected $show = [
		'id',
		'banner',
		'judul',
		'products',
		'anjay',
		'deskripsi',
		'updatedAt',
		'deletedAt',
		'createdAt',
    ];
}