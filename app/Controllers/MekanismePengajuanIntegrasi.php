<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MekanismePengajuanIntegrasiModel;

class MekanismePengajuanIntegrasi extends BaseController
{
    protected $activeUrl = 'MekanismePengajuanIntegrasi';
    protected $model = '';

    protected $rules = [
        'mekanisme' => ['label' => 'Mekanisme', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new MekanismePengajuanIntegrasiModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("MekanismePengajuanIntegrasi/index");
    }

    public function simpan($primary = '')
    {
        $mekanisme = $this->request->getVar('mekanisme');
        if ($mekanisme == 'undefined' || $mekanisme == '<p><br></p>') {
            $post['mekanisme'] = '';
            $this->request->setGlobal("request", $post);
        }

        return parent::simpan($primary);
    }
}
