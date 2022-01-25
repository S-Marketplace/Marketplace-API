<?php

namespace App\Controllers;

use App\Libraries\MyIpaymu;
use App\Models\UserSaldoModel;
use App\Libraries\Notification;
use App\Libraries\MidTransPayment;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationMidTrans extends BaseController
{

    public function __construct()
    {
        helper('filesystem');
    }
   
    public function payment(){
        $data = $this->request->getVar();

        $signature_key = $data->signature_key;
        $transaction_status = $data->transaction_status;
        $transaction_id = $data->transaction_id;
       
        try {
            $userSaldoModel = new UserSaldoModel();
            $userSaldoModel->update($transaction_id, [
                'usalStatus' => $transaction_status,
                'usalSignatureKey' => $signature_key,
            ]);
        } catch (\Throwable $th) {

        }

        return $this->response->setJSON([
            'code' => 200,
            'data' => $data,
            'message' => 'Sukses',
        ]);
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
