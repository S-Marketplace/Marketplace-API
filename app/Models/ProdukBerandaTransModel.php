<?php namespace App\Models;

use App\Models\MyModel;

class ProdukBerandaTransModel extends MyModel
{
    protected $table = "t_produk_beranda";
    protected $primaryKey = "tpbId";
    protected $createdField = "tpbCreatedAt";
    protected $updatedField = "tpbUpdatedAt";
    protected $returnType = "App\Entities\ProdukBerandaTrans";
    protected $allowedFields = ["tpbProdukId","tpbPbId","tpbDeletedAt"];

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
            'produk' => ['table' => 'm_produk', 'condition' => 'tpbProdukId = produkId', 'entity' => 'App\Entities\Produk'],
        ];
    }
}