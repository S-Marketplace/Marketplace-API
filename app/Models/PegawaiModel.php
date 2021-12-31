<?php

namespace App\Models;

use App\Models\MyModel;

class PegawaiModel extends MyModel
{
    protected $table              = 'silaki_m_pegawai';
    protected $primaryKey         = 'pgwNip';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Pegawai';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['pgwNip', 'pgwNik', 'pgwNama', 'pgwStatus', 'pgwJk', 'pgwFoto', 'pgwJabatanId'];

    protected $useTimestamps      = true;
    protected $createdField       = 'pgwCreatedAt';
    protected $updatedField       = 'pgwUpdatedAt';
    protected $deletedField       = 'pgwDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'jabatan' => ['table' => 'silaki_r_jabatan', 'condition' => 'pgwJabatanId = jbtnId', 'entity' => 'App\Entities\Jabatan'],
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
