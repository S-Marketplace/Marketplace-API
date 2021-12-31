<?php

namespace App\Models;

use App\Models\MyModel;

class PengunjungModel extends MyModel
{
    protected $table              = 'silaki_m_pengunjung';
    protected $primaryKey         = 'pjgNik';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Pengunjung';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['pjgNik', 'pjgNama', 'pjgNamaWbp', 'pjgNamaAyah'];

    protected $useTimestamps      = true;
    protected $createdField       = 'pjgCreatedAt';
    protected $updatedField       = 'pjgUpdatedAt';
    protected $deletedField       = 'pjgDeletedAt';

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
