<?php namespace App\Models;

use App\Models\MyModel;

class BannerModel extends MyModel
{
    protected $table = "m_banner";
    protected $primaryKey = "bnrId";
    protected $createdField = "bnrCreatedAt";
    protected $updatedField = "bnrUpdatedAt";
    protected $returnType = "App\Entities\Banner";
    protected $allowedFields = ["bnrDeskripsi","bnrGambar","bnrUrl","bnrDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}