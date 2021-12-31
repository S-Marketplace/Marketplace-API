<?php

namespace App\Controllers;

use App\Models\MekanismeModel;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;

class Mekanisme extends BaseController
{
    protected $activeUrl = 'Mekanisme';
    protected $model = '';

    protected $rules = [
        'kode' => ['label' => 'Kode', 'rules' => 'required'],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'foto' => ['label' => 'Foto', 'rules' => 'required|uploaded[foto]|max_size[foto,5000]|ext_in[foto,jpg,jpeg,png]|mime_in[foto,image/jpeg,image/jpg,image/png]'],
    ];

    public function __construct()
    {
        $this->model = new MekanismeModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Mekanisme/index");
    }

    protected function uploadFile()
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "foto_mekanisme";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {
            $nama = $this->request->getVar('nama');

            $mask = 'mekanisme_' . $nama . '_*.*';
            array_map('unlink', glob($path . DIRECTORY_SEPARATOR . $mask));

            $filename = "mekanisme_" . $nama . "_" . date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['foto'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }


    public function simpan($primary = '')
    {
        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['foto'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->foto != '') {
                unset($this->rules['foto']);
            }
        }

        return parent::simpan($primary);
    }
}
