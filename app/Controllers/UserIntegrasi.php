<?php

namespace App\Controllers;

use App\Models\UserIntegrasiModel;
use App\Controllers\BaseController;

class UserIntegrasi extends BaseController
{
    protected $activeUrl = 'UserIntegrasi';
    protected $model = '';

    protected $rules = [
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new UserIntegrasiModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("UserIntegrasi/index");
    }
}
