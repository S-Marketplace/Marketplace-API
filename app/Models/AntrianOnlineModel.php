<?php

namespace App\Models;

use App\Models\MyModel;

class AntrianOnlineModel extends MyModel
{
    protected $table              = 'silaki_t_antrian';
    protected $primaryKey         = 'antId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\AntrianOnline';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['antNo', 'antNik', 'antTanggal', 'antJenis', 'antDeviceId', 'antNapiId', 'antKeterangan', 'antIsCall'];

    protected $useTimestamps      = true;
    protected $createdField       = 'antCreatedAt';
    protected $updatedField       = 'antUpdatedAt';
    protected $deletedField       = 'antDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'pengunjung' => ['table' => 'silaki_m_pengunjung', 'condition' => 'antNik = pjgNik', 'entity' => 'App\Entities\Pengunjung'],
            'napi' => ['table' => 'silaki_m_napi', 'condition' => 'antNapiId = napiId', 'entity' => 'App\Entities\Napi'],
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
