<?php

namespace App\Models;

use App\Models\MyModel;

class BeritaModel extends MyModel
{
    protected $table              = 'silaki_m_berita';
    protected $primaryKey         = 'brtId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Berita';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['brtJudul', 'brtTanggal', 'brtKonten', 'brtGambar'];

    protected $useTimestamps      = true;
    protected $createdField       = 'brtCreatedAt';
    protected $updatedField       = 'brtUpdatedAt';
    protected $deletedField       = 'brtDeletedAt';

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
