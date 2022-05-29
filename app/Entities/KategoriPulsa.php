<?php namespace App\Entities;
use App\Entities\MyEntity;

class KategoriPulsa extends MyEntity
{
  protected $casts = [
    'produk'=>'json',
  ];

    protected $datamap = [
        'id' => 'kpId',
        'kelompok' => 'kpKelompok',
        'nama' => 'kpNama',
        'icon' => 'kpIcon',
        'urutan' => 'kpUrutan',
        'createdAt' => 'kpCreatedAt',
        'updatedAt' => 'kpUpdatedAt',
        'deletedAt' => 'kpDeletedAt',
    ];

    protected $show = [
		'id',
		'kelompok',
		'nama',
		'icon',
		'urutan',
		'produk',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}