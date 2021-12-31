<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntrianSekarangModel;

class Antrian extends BaseController
{

    public function __construct()
    {
        $this->model = new AntrianSekarangModel();
    }

    public function index()
    {
        $img = base_url('assets/images/silaki/logo-lapas_ya.png');
        $imgData = base64_encode(file_get_contents($img));

        $data['logo'] = 'data:image/png;base64,' . $imgData;
        return view("Layouts/antrian", $data);
    }

    /**
     * getData
     *
     * mengambil data antrian sekarang
     *
     * @return void
     */
    public function getData()
    {
        $this->model->select('*');
        $this->model->with(['antrian']);
        $data = $this->model->find(1);

        return $this->response->setJSON($data);
    }
}
