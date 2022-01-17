<?php namespace App\Models;

use App\Models\MyModel;

class ProdukModel extends MyModel
{
    protected $table = "m_produk";
    protected $primaryKey = "produkId";
    protected $createdField = "produkCreatedAt";
    protected $updatedField = "produkUpdatedAt";
    protected $returnType = "App\Entities\Produk";
    protected $allowedFields = ["produkNama","produkDeskripsi","produkHarga","produkStok","produkHargaPer","produkBerat","produkDilihat","produkKategoriId","produkDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}