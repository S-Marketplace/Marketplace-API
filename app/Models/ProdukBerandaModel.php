<?php namespace App\Models;

use App\Entities\Produk;
use App\Entities\ProdukBerandaTrans;
use App\Models\MyModel;

class ProdukBerandaModel extends MyModel
{
    protected $table = "m_produk_beranda";
    protected $primaryKey = "pbId";
    protected $createdField = "pbCreatedAt";
    protected $updatedField = "pbUpdatedAt";
    protected $returnType = "App\Entities\ProdukBeranda";
    protected $allowedFields = ["pbBanner","pbJudul","pbDeskripsi","pbDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function withProduk(){
        return $this->hasMany("(SELECT * FROM `t_produk_beranda` tpb JOIN `m_produk` p ON  tpb.`tpbProdukId` = p.`produkId`) as produk","tpbPbId = pbId",Produk::class,"products",'-');
    }
}