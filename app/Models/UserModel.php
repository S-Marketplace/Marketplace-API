<?php namespace App\Models;

use App\Models\MyModel;

class UserModel extends MyModel
{
    protected $table = "m_user";
    protected $primaryKey = "usrEmail";
    protected $createdField = "usrCreatedAt";
    protected $updatedField = "usrUpdatedAt";
    protected $returnType = "App\Entities\User";
    protected $allowedFields = ["usrEmail","usrNama","usrPassword","usrSaldo","usrIsActive","usrDeletedAt","usrFirebaseToken","usrPin", "usrNoHp", "usrNoWa"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}