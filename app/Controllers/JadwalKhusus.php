<?php

namespace App\Controllers;

use App\Models\JadwalKhususModel;
use App\Controllers\BaseController;

class JadwalKhusus extends BaseController
{
    protected $activeUrl = 'JadwalKhusus';
    protected $model = '';

    protected $rules = [
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new JadwalKhususModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("JadwalKhusus/index");
    }
}
