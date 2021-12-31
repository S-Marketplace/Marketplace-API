<?php

namespace App\Models;

use App\Models\MyModel;

class StatusPengajuanModel extends MyModel
{
    protected $table              = 'silaki_r_status_pengajuan';
    protected $primaryKey         = 'stpeId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\StatusPengajuan';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['stpeId', 'stpeStatus'];

    protected $useTimestamps      = true;
    protected $createdField       = 'stpeCreatedAt';
    protected $updatedField       = 'stpeUpdatedAt';
    protected $deletedField       = 'stpeDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function checkValue($key)
    {
        $data = $this->find($key);
        if ($data->value != '') {
            return true;
        }
        return false;
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
