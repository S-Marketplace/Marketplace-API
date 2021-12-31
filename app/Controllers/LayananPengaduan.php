<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LayananPengaduanModel;

class LayananPengaduan extends BaseController
{
    protected $activeUrl = 'LayananPengaduan';
    protected $model = '';

    protected $rules = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'link' => ['label' => 'Link', 'rules' => 'required'],
        'icon' => ['label' => 'Icon', 'rules' => 'required'],
        'color' => ['label' => 'Color', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new LayananPengaduanModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("LayananPengaduan/index");
    }
}
