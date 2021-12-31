<?php

namespace App\Models;

use App\Models\MyModel;

class NapiModel extends MyModel
{
    protected $table              = 'silaki_m_napi';
    protected $primaryKey         = 'napiId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\Napi';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = [
        "napiNoReg",
        "napiNama",
        "napiBlokKamar",
        "napiUu",
        "napiLamaPidanaHari",
        "napiLamaPidanaBulan",
        "napiLamaPidanaTahun",
        "napiJnsKejahatan",
        "napiTanggalEkspirasi",
        "napiUptAsal",
        "napiPasalUtama",
        "napiAgama",
        "napiUmur",
        "napiJenisKelamin",
        "napiKewarganegaraan",
        "napiTanggalLahir",
        "napiJenisKejahatanNarkotika",
        "napiStatusKerjaWali",
        "napiPasFoto",
    ];

    protected $useTimestamps      = true;
    protected $createdField       = 'napiCreatedAt';
    protected $updatedField       = 'napiUpdatedAt';
    protected $deletedField       = 'napiDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'agamaRef' => ['table' => 'silaki_r_agama', 'condition' => 'napiAgama = agmrId', 'entity' => 'App\Entities\Agama'],
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
