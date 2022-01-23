<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Welcome extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';

    public function index()
    {   
        $kategoriModel = new KategoriModel();

        $data = [
            'kategori' => $kategoriModel->find(),
        ];

        return view('Welcome/index',$data);
    }

     /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori']);
        $this->model->withGambarProduk();

        return parent::grid();
    }

    public function coming_soon()
    {
        return view('Welcome/coming-soon');
    }
    
}
