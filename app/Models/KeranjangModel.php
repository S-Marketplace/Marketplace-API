<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;

class KeranjangModel extends MyModel
{
    protected $table = "t_keranjang";
    protected $primaryKey = "krjId";
    protected $createdField = "krjCreatedAt";
    protected $updatedField = "krjUpdatedAt";
    protected $returnType = "App\Entities\Keranjang";
    protected $allowedFields = ["krjProdukId","krjQuantity","krjPesan","krjCheckoutId","krjDeletedAt","krjUserEmail"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function withProduk(){
        return $this->hasMany("m_produk","krjProdukId = produkId",Produk::class,"products",'-');
    }
}