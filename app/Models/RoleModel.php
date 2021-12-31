<?php

namespace App\Models;

use App\Models\MyModel;

class RoleModel extends MyModel
{
    protected $table              = 'silaki_m_role';
    protected $primaryKey         = 'rolUsername';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Role';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['rolUsername', 'rolAplikasi', 'rolRole'];

    protected $useTimestamps      = true;
    protected $createdField       = 'rolCreatedAt';
    protected $updatedField       = 'rolUpdatedAt';
    protected $deletedField       = 'rolDeletedAt';

    protected $validationRules    = [
        'rolUsername' => 'required',
        'rolAplikasi' => 'required',
        'rolRole' => 'required',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'role' => ['table' => 'silaki_m_role', 'condition' => 'usrUsername = rolUsername', 'entity' => 'App\Entities\Role'],
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
