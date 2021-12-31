<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class JadwalUmum extends BaseResourceController
{
	protected $modelName = 'App\Models\JadwalUmumModel';
    protected $format    = 'json';

	protected $rulesCreate = [
        'hari' => ['label' => 'Hari', 'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu]|cek_hari'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
    ];

    public function index()
    {
        $this->model->orderBy("FIELD(jduNamaHari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')");
        return parent::index();
    }
}
