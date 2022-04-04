<?php namespace App\Models;

use App\Models\MyModel;

class LokasiCodModel extends MyModel
{
    protected $table = "m_lokasi_cod";
    protected $primaryKey = "lcdId";
    protected $createdField = "lcdCreatedAt";
    protected $updatedField = "lcdUpdatedAt";
    protected $returnType = "App\Entities\LokasiCod";
    protected $allowedFields = ["lcdNama","lcdLatitude","lcdLongitude","lcdDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}