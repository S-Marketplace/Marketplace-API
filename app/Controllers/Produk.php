<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Controllers\BaseController;

class Produk extends BaseController
{
    protected $activeUrl = 'Produk';
    protected $model = '';

    protected $rules = [
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new ProdukModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Produk/index");
    }
}
