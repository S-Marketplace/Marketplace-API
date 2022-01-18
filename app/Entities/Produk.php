<?php namespace App\Entities;
use App\Entities\MyEntitiy;

class Produk extends MyEntity
{
    protected $casts = [
        'kategori' => 'json',
    ];

    protected $datamap = [
        'id' => 'produkId',
        'nama' => 'produkNama',
        'deskripsi' => 'produkDeskripsi',
        'harga' => 'produkHarga',
        'stok' => 'produkStok',
        'hargaPer' => 'produkHargaPer',
        'berat' => 'produkBerat',
        'dilihat' => 'produkDilihat',
        'kategoriId' => 'produkKategoriId',
        'createdAt' => 'produkCreatedAt',
        'updatedAt' => 'produkUpdatedAt',
        'deletedAt' => 'produkDeletedAt',
    ];

    protected $show = [
		'id',
'nama',
'deskripsi',
'harga',
'stok',
'hargaPer',
'berat',
'dilihat',
'kategoriId',
'kategori',
'createdAt',
'updatedAt',
'deletedAt',

    ];
}