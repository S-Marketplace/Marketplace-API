<?php

namespace App\Models;

use App\Models\MyModel;

class JabatanModel extends MyModel
{
    protected $table              = 'silaki_r_jabatan';
    protected $primaryKey         = 'jbtnId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Jabatan';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['jbtnNama'];

    protected $useTimestamps      = true;
    protected $createdField       = 'jbtnCreatedAt';
    protected $updatedField       = 'jbtnUpdatedAt';
    protected $deletedField       = 'jbtnDeletedAt';

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
