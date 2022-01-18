<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Controllers\BaseController;

class Produk extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $activeUrl = 'Produk';

    protected $rules = [
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
        'jamMulai' => ['label' => 'Jam Mulai', 'rules' => 'required'],
        'jamSelesai' => ['label' => 'Jam Selesai', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
    ];

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Produk/index");
    }
}
