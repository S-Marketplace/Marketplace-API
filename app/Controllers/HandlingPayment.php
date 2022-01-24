<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MidTransPayment;
use App\Libraries\MyIpaymu;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;

class HandlingPayment extends BaseController
{
   
    public function post(){
        helper('filesystem');

        $data = json_encode($this->request->getVar());

        if ( ! write_file(WRITEPATH.'payment_log/log.txt', $data)) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
    }
}
