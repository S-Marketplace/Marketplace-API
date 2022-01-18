<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukGambar extends MyEntity
{
    protected $datamap = [
        'id' => 'prdgbrId',
        'produkId' => 'prdgbrProdukId',
        'file' => 'prdgbrFile',
        'createdAt' => 'prdgbrCreatedAt',
        'updatedAt' => 'prdgbrUpdatedAt',
        'deletedAt' => 'prdgbrDeletedAt',
    ];

    protected $show = [
		'id',
		'produkId',
		'file',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}