<?php

namespace App\Models;

use App\Models\MyModel;

class JadwalKhususModel extends MyModel
{
    protected $table              = 'silaki_m_jadwal_khusus';
    protected $primaryKey         = 'jdkId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\JadwalKhusus';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['jdkTanggal', 'jdkJamMulai', 'jdkJamSelesai', 'jdkKeterangan'];

    protected $useTimestamps      = true;
    protected $createdField       = 'jdkCreatedAt';
    protected $updatedField       = 'jdkUpdatedAt';
    protected $deletedField       = 'jdkDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }
}
