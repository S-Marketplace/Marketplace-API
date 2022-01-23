<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Welcome extends BaseController
{


    public function index()
    {   
        $kategoriModel = new KategoriModel();

        $data = [
            'kategori' => $kategoriModel->find(),
        ];

        return view('Welcome/index',$data);
    }

    public function coming_soon()
    {
        return view('Welcome/coming-soon');
    }

    
}
