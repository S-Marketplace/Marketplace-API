<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MidTransPayment;
use App\Libraries\MyIpaymu;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationMidTrans extends BaseController
{

    public function __construct()
    {
        helper('filesystem');
    }
   
    public function payment(){
        $data = json_encode($this->request->getVar());

        if ( ! write_file(WRITEPATH.'notification_mid_trans/payment.txt', $data)) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
    }

    public function recurring(){
        $data = json_encode($this->request->getVar());

        if ( ! write_file(WRITEPATH.'notification_mid_trans/recurring.txt', $data)) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
    }

    public function pay_account(){
        $data = json_encode($this->request->getVar());

        if ( ! write_file(WRITEPATH.'notification_mid_trans/pay_account.txt', $data)) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
    }
}
