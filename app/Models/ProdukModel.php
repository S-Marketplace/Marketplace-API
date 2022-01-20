<?php namespace App\Models;

use App\Entities\ProdukGambar;
use App\Models\MyModel;

class ProdukModel extends MyModel
{
    protected $table = "m_produk";
    protected $primaryKey = "produkId";
    protected $createdField = "produkCreatedAt";
    protected $updatedField = "produkUpdatedAt";
    protected $returnType = "App\Entities\Produk";
    protected $allowedFields = ["produkNama","produkDeskripsi","produkHarga","produkStok","produkHargaPer","produkBerat","produkDilihat","produkKategoriId","produkDiskon", "produkDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'kategori' => ['table' => 'm_kategori', 'condition' => 'produkKategoriId = ktgId', 'entity' => 'App\Entities\Kategori'],
        ];
    }

    public function withGambarProduk(){
        return $this->hasMany("t_produk_gambar","produkId = prdgbrProdukId",ProdukGambar::class,"gambar",'prdgbrId');
    }
}