<?php

namespace App\Models;

use App\Models\MyModel;

class MekanismePengajuanIntegrasiModel extends MyModel
{
    protected $table              = 'silaki_m_mekanisme_pengajuan_integrasi';
    protected $primaryKey         = 'mpiId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\MekanismePengajuanIntegrasi';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['mpiMekanisme'];

    protected $useTimestamps      = true;
    protected $createdField       = 'mpiCreatedAt';
    protected $updatedField       = 'mpiUpdatedAt';
    protected $deletedField       = 'mpiDeletedAt';

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
