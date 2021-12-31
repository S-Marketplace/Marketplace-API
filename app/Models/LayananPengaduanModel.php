<?php

namespace App\Models;

use App\Models\MyModel;

class LayananPengaduanModel extends MyModel
{
    protected $table              = 'silaki_m_layanan_pengaduan';
    protected $primaryKey         = 'pgdId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\LayananPengaduan';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['pgdNama', 'pgdLink', 'pgdIcon', 'pdgColor'];

    protected $useTimestamps      = true;
    protected $createdField       = 'pgdCreatedAt';
    protected $updatedField       = 'pgdUpdatedAt';
    protected $deletedField       = 'pgdDeletedAt';

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
