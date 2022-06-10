<?php namespace App\Models;

use App\Models\MyModel;

class BannerModel extends MyModel
{
    protected $table = "m_banner";
    protected $primaryKey = "bnrId";
    protected $createdField = "bnrCreatedAt";
    protected $updatedField = "bnrUpdatedAt";
    protected $returnType = "App\Entities\Banner";
    protected $allowedFields = ["bnrDeskripsi","bnrGambar","bnrUrl", "bnrJenis", "bnrKategoriId", "bnrProdukId", "bnrType", "bnrDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function selectJenis(){
        $select= [];
        foreach (['Kategori', 'Produk', 'Artikel'] as $key => $value) {
            $select[$value] = $value;
        }

        return $select;
    }

    public function selectTipe(){
        $select= [];
        foreach (['Vertical', 'Horizontal'] as $key => $value) {
            $select[$value] = $value;
        }

        return $select;
    }
}