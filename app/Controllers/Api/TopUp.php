<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Libraries\MidTransPayment;
use App\Models\UserModel;
use App\Models\UserSaldoModel;
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
        'metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_list[echannel,bank_transfer]'],
        'bank' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_list[bni,bca,permata]'],
    ];

    public function topUpSaldo()
    {
        if ($this->validate($this->rules, $this->validationMessage)) {
         
            $data = $this->request->getVar();
            try {
                $price = $data['nominal'];
                $metodePembayaran = $data['metode_pembayaran'];
                $bank = $data['bank'];

                $midTransPayment = new MidTransPayment();
                $data  = $midTransPayment->charge($metodePembayaran,array(
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
                    ]);
                }

                return $this->response($data, 200);
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
