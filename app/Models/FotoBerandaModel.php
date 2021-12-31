<?php

namespace App\Models;

use App\Models\MyModel;

class FotoBerandaModel extends MyModel
{
    protected $table              = 'silaki_m_foto_beranda';
    protected $primaryKey         = 'fberId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\FotoBeranda';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['fberFoto', 'fberIsActive'];

    protected $useTimestamps      = true;
    protected $createdField       = 'fberCreatedAt';
    protected $updatedField       = 'fberUpdatedAt';
    protected $deletedField       = 'fberDeletedAt';

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
