<?php

namespace App\Models;

use App\Models\MyModel;

class JadwalUmumModel extends MyModel
{
    protected $table              = 'silaki_m_jadwal_umum';
    protected $primaryKey         = 'jduId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\JadwalUmum';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['jduNamaHari', 'jduJamMulai', 'jduJamSelesai'];

    protected $useTimestamps      = true;
    protected $createdField       = 'jduCreatedAt';
    protected $updatedField       = 'jduUpdatedAt';
    protected $deletedField       = 'jduDeletedAt';

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
