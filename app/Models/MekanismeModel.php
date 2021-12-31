<?php

namespace App\Models;

use App\Models\MyModel;

class MekanismeModel extends MyModel
{
    protected $table              = 'silaki_m_mekanisme';
    protected $primaryKey         = 'mksId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Mekanisme';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['mksKode', 'mksNama', 'mksFoto'];

    protected $useTimestamps      = true;
    protected $createdField       = 'mksCreatedAt';
    protected $updatedField       = 'mksUpdatedAt';
    protected $deletedField       = 'mksDeletedAt';

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
