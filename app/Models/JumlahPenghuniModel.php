<?php

namespace App\Models;

use App\Models\MyModel;

class JumlahPenghuniModel extends MyModel
{
    protected $table              = 'silaki_m_jumlah_penghuni';
    protected $primaryKey         = 'pghId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\JumlahPenghuni';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = [
        'pghTanggal',
        'pghKapasitas',
        'pghNapiDL',
        'pghNapiDP',
        'pghNapiTD',
        'pghNapiAL',
        'pghNapiAP',
        'pghNapiTA',
        'pghNapiTotal',
        'pghTahananDL',
        'pghTahananDP',
        'pghTahananTD',
        'pghTahananAL',
        'pghTahananAP',
        'pghTahananTA',
        'pghTahananTotal',
    ];

    protected $useTimestamps      = true;
    protected $createdField       = 'pghCreatedAt';
    protected $updatedField       = 'pghUpdatedAt';
    protected $deletedField       = 'pghDeletedAt';

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
