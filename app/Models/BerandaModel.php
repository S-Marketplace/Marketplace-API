<?php

namespace App\Models;

use App\Models\MyModel;

class BerandaModel extends MyModel
{
    protected $table              = 'silaki_t_antrian';
    protected $primaryKey         = 'antId';

    protected $returnType         = 'App\Entities\AntrianOnline';

    public function jumlahAntrian($filter, $dari, $sampai)
    {
        $this->select("SUM(IF(antJenis = 'Kunjungan',1,0)) kunjungan,
            SUM(IF(antJenis = 'Penitipan',1,0)) penitipan,
            MONTH(antTanggal) bulan,
            YEAR(antTanggal) tahun,
            DATE(antTanggal) tanggal");

        if ($filter == 'hari') {
            $group = 'DATE(antTanggal)';
        } else if ($filter == 'bulan') {
            $group = 'MONTH(antTanggal)';
        } else {
            $group = 'YEAR(antTanggal)';
        }

        $this->groupStart();
        $this->where('antTanggal >=', $dari);
        $this->where('antTanggal <=', $sampai);
        $this->groupEnd();

        $this->groupBy($group);
        $this->orderBy('MONTH(antTanggal) ASC, YEAR(antTanggal) ASC');

        return $this;
    }

    public function antrianHariIni()
    {
        $this->select("SUM(IF(antJenis = 'Kunjungan',1,0)) kunjungan,
            SUM(IF(antJenis = 'Penitipan',1,0)) penitipan");

        $this->where('DATE(antTanggal)', date('Y-m-d'));

        return $this;
    }

    public function jumlahNapi()
    {
        $db = \Config\Database::connect();

        $builder = $db->table("silaki_m_napi n");

        $builder->select("COUNT(n.napiId) jumlah");

        return $builder;
    }
}
