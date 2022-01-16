<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Welcome extends BaseController
{


    public function index()
    {
     
        return view('Welcome/index');
    }

    
}
