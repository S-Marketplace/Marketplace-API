<?php

namespace App\Controllers;

use App\Models\UserSaldoModel;
use App\Controllers\BaseController;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\PembayaranModel;
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
        $statusLog = $this->writeLog(WRITEPATH.'notification_mid_trans/payment.txt', json_encode($data));
       
        $signature_key = $data->signature_key ?? $data['signature_key'];
        $transaction_status = $data->transaction_status ?? $data['transaction_status'];
        $transaction_id = $data->transaction_id ?? $data['transaction_id'];
       
        // try {
            $this->_setIsiSaldo($signature_key, $transaction_status, $transaction_id);
            $this->_setPembayaranProduk($signature_key, $transaction_status, $transaction_id);
        // } catch (DatabaseException $ex) {
        //     $response =  $this->response(null, 500, $ex->getMessage());
        // } catch (\mysqli_sql_exception $ex) {
        //     $response =  $this->response(null, 500, $ex->getMessage());
        //     return $this->response->setJSON($response);
        // } catch (\Exception $ex) {
        //     $response =  $this->response(null, 500, $ex->getMessage());
        //     return $this->response->setJSON($response);
        // }

        return $this->response->setJSON([
            'code' => 200,
            'data' => $data,
            'message' => $statusLog ? 'Success Write Log': 'Failed Write',
        ]);
    }

    private function _setPembayaranProduk($signature_key, $transaction_status, $transaction_id){
        $pembayaranModel = new PembayaranModel();
        $find = $pembayaranModel->find($transaction_id);

        if(!empty($find)){
            $status = $pembayaranModel->update($transaction_id, [
                'pmbStatus' => $transaction_status,
                'pmbSignatureKey' => $signature_key,
            ]);
    
            if($status){
                if($transaction_status == 'settlement'){
                    $checkoutId = $pembayaranModel->find($transaction_id)->checkoutId;
                    $checkoutModel = new CheckoutModel();
                    $checkoutModel->update($checkoutId, [
                        'cktStatus' => 'dikemas'
                    ]);

                    $keranjangModel = new KeranjangModel();
                    $keranjangModel->updateProdukStok($checkoutId);
                }
            }
        }
    }

    private function _setIsiSaldo($signature_key, $transaction_status, $transaction_id){
        $userSaldoModel = new UserSaldoModel();
        $find = $userSaldoModel->find($transaction_id);
        
        if(!empty($find)){
            $status = $userSaldoModel->update($transaction_id, [
                'usalStatus' => $transaction_status,
                'usalSignatureKey' => $signature_key,
            ]);
    
            if($status){
                $data = $userSaldoModel->addSaldo($transaction_id);
            }
        }
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
