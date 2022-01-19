<?php namespace App\Entities;
use App\Entities\MyEntity;

class Banner extends MyEntity
{
    protected $datamap = [
        'id' => 'bnrId',
        'deskripsi' => 'bnrDeskripsi',
        'gambar' => 'bnrGambar',
        'url' => 'bnrUrl',
        'createdAt' => 'bnrCreatedAt',
        'updatedAt' => 'bnrUpdatedAt',
        'deletedAt' => 'bnrDeletedAt',
    ];

    protected $show = [
		'id',
		'deskripsi',
		'gambar',
		'url',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}