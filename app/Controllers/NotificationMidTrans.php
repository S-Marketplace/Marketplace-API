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
    private $ipWhitelist = [

    ];

    public function __construct()
    {
        helper('filesystem');
    }
   
    public function payment(){
        $data = $this->request->getVar();

        $statusLog = $this->writeLog(WRITEPATH.'notification_mid_trans/ip_log.txt', "IP:".$this->request->getIPAddress());
       
        $signature_key = $data->signature_key ?? $data['signature_key'];
        $transaction_status = $data->transaction_status ?? $data['transaction_status'];
        $transaction_id = $data->transaction_id ?? $data['transaction_id'];
       
        try {
            $userSaldoModel = new UserSaldoModel();
            $status = $userSaldoModel->update($transaction_id, [
                'usalStatus' => $transaction_status,
                'usalSignatureKey' => $signature_key,
            ]);

            if($status){
                $data = $userSaldoModel->addSaldo($transaction_id);
            }
        } catch (DatabaseException $ex) {
            $response =  $this->response(null, 500, $ex->getMessage());
        } catch (\mysqli_sql_exception $ex) {
            $response =  $this->response(null, 500, $ex->getMessage());
            return $this->response->setJSON($response);
        } catch (\Exception $ex) {
            $response =  $this->response(null, 500, $ex->getMessage());
            return $this->response->setJSON($response);
        }

        return $this->response->setJSON([
            'code' => 200,
            'data' => $data,
            'message' => $statusLog ? 'Success Write Log': 'Failed Write',
        ]);
    }

    public function recurring(){
        $data = json_encode($this->request->getVar());
        $statusLog = $this->writeLog(WRITEPATH.'notification_mid_trans/recurring.txt', $data);
    }

    public function pay_account(){
        $data = json_encode($this->request->getVar());
        $statusLog = $this->writeLog(WRITEPATH.'notification_mid_trans/pay_account.txt', $data);
    }

    private function writeLog($path, $data){
        if(file_exists($path))
            $statusLog = write_file($path, "[".date('Y-m-d H:i:s')."] => ".$data. "\r\n",  'a');
        else
            $statusLog = write_file($path, $data);

        return $statusLog;
    }
}
