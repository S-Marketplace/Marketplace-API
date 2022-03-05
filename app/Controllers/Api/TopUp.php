<?php namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\UserSaldoModel;
use App\Libraries\MidTransPayment;
use App\Models\MetodePembayaranModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class User
 * @note Resource untuk mengelola data m_user
 * @dataDescription m_user
 * @package App\Controllers
 */
class TopUp extends MyResourceController
{
    protected $modelName = 'App\Models\UserSaldoModel';
    protected $format = 'json';

    protected $rules = [
        'nominal' => ['label' => 'Nominal', 'rules' => 'required|numeric'],
        'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    public function topUpSaldo()
    {
        if ($this->validate($this->rules, $this->validationMessage)) {
         
            $data = $this->request->getVar();
            try {
                $metodePembayaranModel = new MetodePembayaranModel();
                $metodePembayaranData = $metodePembayaranModel->find($data['id_metode_pembayaran']);
           
                $price = $data['nominal'];
                $bank = $metodePembayaranData->bank;

                $midTransPayment = new MidTransPayment();
                $data  = $midTransPayment->charge($metodePembayaranData,array(
                    'email' => $this->user['email'],
                    'first_name' => $this->user['nama'],
                    'last_name' => '',
                    'phone' => $this->user['noHp'],
                ),array(
                    0 => array(
                        'id' => 'TopUp',
                        'price' => $price,
                        'quantity' => 1,
                        'name' => 'TopUp Saldo Menyambang',
                    )
                ), $bank, $price);

                if($data['status_code'] == 201){
                    $userSaldoModel = new UserSaldoModel();
                    $userSaldoModel->insert([
                        'usalId' => $data['transaction_id'],
                        'usalPaymentType' => $data['payment_type'],
                        'usalStatus' => $data['transaction_status'],
                        'usalTime' => $data['transaction_time'],
                        'usalSignatureKey' => '',
                        'usalOrderId' => $data['order_id'],
                        'usalMerchantId' => $data['merchant_id'],
                        'usalGrossAmount' => $data['gross_amount'],
                        'usalCurrency' => $data['currency'],
                        'usalVaNumber' => $data['va_numbers'][0]['va_number'] ?? '',
                        'usalBank' => $data['va_numbers'][0]['bank'] ?? '',
                        'usalBillerCode' => $data['biller_code'] ?? '',
                        'usalBillKey' => $data['bill_key'] ?? '',
                        'usalUserEmail' => $this->user['email'],
                        'usalPaymentCode' => $data['payment_code'] ?? '',
                        'usalStore' => $data['store'] ?? '',
                        'usalStatusSaldo' => 'top_up',
                        'usalExpiredDate' => date('Y-m-d H:i:s', strtotime($data['transaction_time']." +1 days")),
                    ]);

                    return $this->response($userSaldoModel->find($data['transaction_id']), 200);
                }

                return $this->response(null, 400, 'Gagal Melakukan Pembayaran');
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

}
