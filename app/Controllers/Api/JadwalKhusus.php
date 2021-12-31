<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class JadwalKhusus extends BaseResourceController
{
	protected $modelName = 'App\Models\JadwalKhususModel';
    protected $format    = 'json';

	protected $rulesCreate = [
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
    ];
}
