<?php

namespace App\Controllers;

use App\Models\JadwalUmumModel;
use App\Controllers\BaseController;

class JadwalUmum extends BaseController
{
    protected $activeUrl = 'JadwalUmum';
    protected $model = '';
    const HARI = [
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
        'Minggu' => 'Minggu',
    ];

    protected $rules = [
        'hari' => ['label' => 'Hari', 'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu]|cek_hari'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new JadwalUmumModel();
    }

    public function index()
    {
        $data = [
            'hari' => self::HARI,
        ];
        helper('form');
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("JadwalUmum/index", $data);
    }
}
