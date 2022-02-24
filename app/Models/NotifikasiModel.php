<?php namespace App\Models;

use App\Models\MyModel;

class NotifikasiModel extends MyModel
{
    protected $table = "m_notifikasi";
    protected $primaryKey = "noifId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\Notifikasi";
    protected $allowedFields = ["notifJudul","notifPesan","notifTanggal"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}