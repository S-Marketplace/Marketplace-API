<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Test extends BaseController
{
   
    public function email(){
        Notification::sendEmail('ahmadjuhdi007@gmail.com', 'subject', 'TEST');
    }
}
