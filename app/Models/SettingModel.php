<?php namespace App\Models;

use App\Models\MyModel;

class SettingModel extends MyModel
{
    protected $table = "m_setting";
    protected $primaryKey = "setKey";
    protected $createdField = "setCreatedAt";
    protected $updatedField = "setUpdatedAt";
    protected $returnType = "App\Entities\Setting";
    protected $allowedFields = ["setKey","setValue","setDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}