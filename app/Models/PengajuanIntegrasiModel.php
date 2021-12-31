<?php

namespace App\Models;

use App\Models\MyModel;

class PengajuanIntegrasiModel extends MyModel
{
    protected $table              = 'silaki_t_pengajuan_integrasi';
    protected $primaryKey         = 'pintId';

    protected $useAutoIncrement   = true;

    protected $returnType         = 'App\Entities\PengajuanIntegrasi';
    protected $useSoftDeletes     = true;

    protected $allowedFields      = ['pintId', 'pintUinNik', 'pintNapiId', 'pintStatus', 'pintHubunganNapi', 'pintTanggal'];

    protected $useTimestamps      = true;
    protected $createdField       = 'pintCreatedAt';
    protected $updatedField       = 'pintUpdatedAt';
    protected $deletedField       = 'pintDeletedAt';

    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function relationships()
    {
        return [
            'napi' => ['table' => 'silaki_m_napi', 'condition' => 'pintNapiId = napiId', 'entity' => 'App\Entities\Napi'],
            'agama' => ['table' => 'silaki_r_agama', 'condition' => 'napiAgama = agmrId', 'entity' => 'App\Entities\Agama'],
            'user' => ['table' => 'silaki_m_user_integrasi', 'condition' => 'uinNik = pintUinNik', 'entity' => 'App\Entities\UserIntegrasi'],
            'statusPengajuan' => ['table' => 'silaki_r_status_pengajuan', 'condition' => 'stpeId = pintStatus', 'entity' => 'App\Entities\StatusPengajuan'],
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

    public function getDataPrint($id, $nik)
    {
        $pengajuanIntegrasi = new PengajuanIntegrasiModel();
        return $pengajuanIntegrasi
            ->join('silaki_m_user_integrasi', 'uinNik = pintUinNik')
            ->join('silaki_m_napi', 'napiId = pintNapiId')
            ->join('silaki_r_agama', 'agmrId = napiAgama')
            ->where('pintUinNik', $nik)
            ->asArray()->find($id);
    }

    public function getDataPJ()
    {
        $pegawai = new PegawaiModel();
        return current($pegawai
            ->join('silaki_r_jabatan', 'jbtnId = pgwJabatanId')
            ->where('jbtnId', 1)
            ->asArray()->find());
    }

    public function isBisaMengajukan($nik)
    {
        $pengajuanIntegrasi = new PengajuanIntegrasiModel();
        return $pengajuanIntegrasi
            ->where('pintUinNik', $nik)
            ->where('pintStatus !=', 6)
            ->asArray()->find();
    }
}
