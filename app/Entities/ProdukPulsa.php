<?php namespace App\Entities;
use App\Entities\MyEntity;

class ProdukPulsa extends MyEntity
{
    protected $casts = [
      'kategori'=>'json',
    ];

    protected $datamap = [
        'id' => 'ppId',
        'kategoriId' => 'ppKpId',
        'kode' => 'ppKode',
        'nama' => 'ppNama',
        'deskripsi' => 'ppDeskripsi',
        'urutan' => 'ppUrutan',
        'kodeSuplier' => 'ppKodeSuplier',
        'jenis' => 'ppJenis',
        'poin' => 'ppPoin',
        'jamOperasional' => 'ppJamOperasional',
        'harga' => 'ppHarga',
        'createdAt' => 'ppCreatedAt',
        'updatedAt' => 'ppUpdatedAt',
        'deletedAt' => 'ppDeletedAt',
    ];

    protected $show = [
		'id',
		'kategoriId',
		'kode',
		'nama',
		'deskripsi',
		'urutan',
		'kodeSuplier',
		'jenis',
		'poin',
		'jamOperasional',
		'harga',
		'kategori',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}