<?php namespace App\Models;

use App\Models\MyModel;

class UserAlamatModel extends MyModel
{
    protected $table = "m_user_alamat";
    protected $primaryKey = "usralId";
    protected $createdField = "usralCreatedAt";
    protected $updatedField = "usralUpdatedAt";
    protected $returnType = "App\Entities\UserAlamat";
    protected $allowedFields = ["usralUsrEmail","usralNama","usralDeletedAt","usralLatitude","usralLongitude","usralKotaId","usralKotaNama","usralProvinsiId","usralProvinsiNama","usralKabupatenId","usralKabupatenNama","usralKecamatanId","usralKecamatanNama","usralIsActive","usralIsFirst"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}