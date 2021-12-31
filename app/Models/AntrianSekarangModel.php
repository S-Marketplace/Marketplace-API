<?php

namespace App\Models;

use App\Models\MyModel;

class AntrianSekarangModel extends MyModel
{
    protected $table              = 'silaki_t_antrian_sekarang';
    protected $primaryKey         = 'ansId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\AntrianSekarang';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['ansAntrianId'];

    protected $useTimestamps      = true;
    protected $createdField       = 'ansCreatedAt';
    protected $updatedField       = 'ansUpdatedAt';
    protected $deletedField       = 'ansDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'antrian' => ['table' => 'silaki_t_antrian', 'condition' => 'ansAntrianId = antId', 'entity' => 'App\Entities\AntrianOnline'],
        ];
    }

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }
}
