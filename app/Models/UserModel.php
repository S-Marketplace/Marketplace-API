<?php

namespace App\Models;

use App\Models\MyModel;

class UserModel extends MyModel
{
    protected $table              = 'silaki_m_user';
    protected $primaryKey         = 'usrUsername';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\User';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['usrUsername', 'usrPassword', 'usrNama'];

    protected $useTimestamps      = true;
    protected $createdField       = 'usrCreatedAt';
    protected $updatedField       = 'usrUpdatedAt';
    protected $deletedField       = 'usrDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = true;

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
