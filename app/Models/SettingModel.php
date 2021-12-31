<?php

namespace App\Models;

use App\Models\MyModel;

class SettingModel extends MyModel
{
    protected $table              = 'silaki_m_setting';
    protected $primaryKey         = 'setKey';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Setting';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['setValue'];

    protected $useTimestamps      = true;
    protected $createdField       = 'setCreatedAt';
    protected $updatedField       = 'setUpdatedAt';
    protected $deletedField       = 'setDeletedAt';

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
