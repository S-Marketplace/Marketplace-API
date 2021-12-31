<?php

namespace App\Models;

use App\Models\MyModel;

class AgamaModel extends MyModel
{
    protected $table              = 'silaki_r_agama';
    protected $primaryKey         = 'agmrId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Agama';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['agmrNama'];

    protected $useTimestamps      = true;
    protected $createdField       = 'agmrCreatedAt';
    protected $updatedField       = 'agmrUpdatedAt';
    protected $deletedField       = 'agmrDeletedAt';

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
