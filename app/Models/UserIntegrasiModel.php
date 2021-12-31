<?php

namespace App\Models;

use App\Models\MyModel;

class UserIntegrasiModel extends MyModel
{
    protected $table              = 'silaki_m_user_integrasi';
    protected $primaryKey         = 'uinNik';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\UserIntegrasi';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['uinNik', 'uinNama', 'uinNoHp', 'uinTempatLahir', 'uinTanggalLahir', 'uinEmail', 'uinFotoKtp', 'uinFotoSelfie', 'uinAlamat', 'uinUmur', 'uinPekerjaan'];

    protected $useTimestamps      = true;
    protected $createdField       = 'uinCreatedAt';
    protected $updatedField       = 'uinUpdatedAt';
    protected $deletedField       = 'uinDeletedAt';

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
