<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JumlahPenghuniModel;

class JumlahPenghuni extends BaseController
{
    protected $activeUrl = 'JumlahPenghuni';
    protected $model = '';

    protected $rules = [
        'tanggal' => ['label' => 'Periode', 'rules' => 'required'],
        'kapasitas' => ['label' => 'Kapasitas', 'rules' => 'required|numeric'],
        'napiDL' => ['label' => 'Napi DL', 'rules' => 'required|numeric'],
        'napiDP' => ['label' => 'Napi DP', 'rules' => 'required|numeric'],
        'napiTD' => ['label' => 'Napi TD', 'rules' => 'required|numeric'],
        'napiAL' => ['label' => 'Napi AL', 'rules' => 'required|numeric'],
        'napiAP' => ['label' => 'Napi AP', 'rules' => 'required|numeric'],
        'napiTA' => ['label' => 'Napi TA', 'rules' => 'required|numeric'],
        // 'napiTotal' => ['label' => 'Total Napi', 'rules' => 'required|numeric'],
        'tahananDL' => ['label' => 'Tahanan DL', 'rules' => 'required|numeric'],
        'tahananDP' => ['label' => 'Tahanan DP', 'rules' => 'required|numeric'],
        'tahananTD' => ['label' => 'Tahanan TD', 'rules' => 'required|numeric'],
        'tahananAL' => ['label' => 'Tahanan AL', 'rules' => 'required|numeric'],
        'tahananAP' => ['label' => 'Tahanan AP', 'rules' => 'required|numeric'],
        // 'tahananTA' => ['label' => 'Tahanan TA', 'rules' => 'required|numeric'],
        // 'tahananTotal' => ['label' => 'Total Tahanan', 'rules' => 'required|numeric'],
    ];

    public function __construct()
    {
        $this->model = new JumlahPenghuniModel();
    }

    public function index()
    {
        helper('form');
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("JumlahPenghuni/index");
    }
}
