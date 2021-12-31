<?php

namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Models\FotoBerandaModel;
use App\Controllers\BaseController;

class FotoBeranda extends BaseController
{
    protected $activeUrl = 'FotoBeranda';
    protected $model = '';

    protected $rules = [
        'isActive' => ['label' => 'Status', 'rules' => 'required|in_list[0,1]'],
        'foto' => ['label' => 'Foto', 'rules' => 'required|uploaded[foto]|max_size[foto,5000]|ext_in[foto,jpg,jpeg,png]|mime_in[foto,image/jpeg,image/jpg,image/png]'],
    ];

    public function __construct()
    {
        $this->model = new FotoBerandaModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("FotoBeranda/index");
    }

    protected function uploadFile()
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "foto_beranda";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

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
