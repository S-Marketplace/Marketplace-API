<?php

namespace App\Models;

use App\Models\MyModel;

class SosmedModel extends MyModel
{
    protected $table              = 'silaki_m_sosmed';
    protected $primaryKey         = 'sosId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Sosmed';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = [];

    protected $useTimestamps      = true;
    protected $createdField       = 'sosCreatedAt';
    protected $updatedField       = 'sosUpdatedAt';
    protected $deletedField       = 'sosDeletedAt';

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
