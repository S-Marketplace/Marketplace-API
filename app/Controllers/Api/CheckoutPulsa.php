<?php

namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Models\PembayaranModel;
use App\Models\UserAlamatModel;
use App\Libraries\MidTransPayment;
use App\Models\CheckoutPulsaModel;
use App\Models\CheckoutDetailModel;
use App\Models\MetodePembayaranModel;
use App\Models\Pulsa\ProdukPulsaModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class CheckoutPulsa
 * @note Resource untuk mengelola data t_checkout_pulsa
 * @dataDescription t_checkout_pulsa
 * @package App\Controllers
 */
class CheckoutPulsa extends MyResourceController
{
    const SALDO_PAYMENT_ID = 1;
    const COD_PAYMENT_ID = 99;
    const MANUAL_TRANSFER_IDS = [2, 3, 4, 5];

    /**
     * Limit day payment
     */
    const LIMIT_DAY_MANUAL_TRANSFER = 1;
    const LIMIT_DAY_COD = 1;
    const LIMIT_DAY_MIDTRANS = 1;

    protected $modelName = 'App\Models\CheckoutPulsaModel';
    protected $format    = 'json';

    protected $checkout = [
        'idProduk' => [
            'label' => 'idProduk', 'rules' => 'required|in_table[m_produk_pulsa,ppId]',
            'errors' => ['in_table' => '{field} wajib diisi.']
        ],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required|numeric'],
        'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    protected $rulesCreate = [
        'email' => ['label' => 'email', 'rules' => 'required'],
        'pmbId' => ['label' => 'pmbId', 'rules' => 'required'],
        'idProduk' => ['label' => 'idProduk', 'rules' => 'required'],
        'status' => ['label' => 'status', 'rules' => 'required'],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'email' => ['label' => 'email', 'rules' => 'required'],
        'pmbId' => ['label' => 'pmbId', 'rules' => 'required'],
        'idProduk' => ['label' => 'idProduk', 'rules' => 'required'],
        'status' => ['label' => 'status', 'rules' => 'required'],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    public function index()
    {
        $post = $this->request->getGet();
        $post['pembayaran_userEmail']['eq'] = $this->user['email'];
        $this->request->setGlobal("get", $post);
        return parent::index();
    }

    /**
     * Checkout Produk
     *
     * @return void
     */
    public function checkout()
    {
        $post = $this->request->getVar();

        if ($this->validate($this->checkout, $this->validationMessage)) {
            try {

                // Tambahkan data checkout
                $checkoutModel = new CheckoutPulsaModel();
                $checkoutModel->transStart();
                $checkoutId = $checkoutModel->insert([
                    'cktpTujuan' => $post['tujuan'],
                    'cktpIdProduk' => $post['idProduk'],
                    'cktpEmail' => $this->user['email'],
                ]);
                $checkoutModelStatus = $checkoutModel->transStatus();

                if ($checkoutModelStatus) {
                    $produkPulsaModel = new ProdukPulsaModel();
                    $produkPulsa = $produkPulsaModel->find($post['idProduk']);
                    $price = $produkPulsa->ppHarga;

                    // COD PAYMENT
                    if ($post['id_metode_pembayaran'] == self::COD_PAYMENT_ID) {
                        $metodePembayaranModel = new MetodePembayaranModel();
                        $metodePembayaranData = $metodePembayaranModel->find($post['id_metode_pembayaran']);

                        $dateTime = date('Y-m-d H:i:s');
                        $uuid = Uuid::uuid4() . '-cod';
                        $orderId = 'ORDER-' . strtotime("now");;

                        $bank = $metodePembayaranData->bank;

                        $pembayaranModel = new PembayaranModel();
                        $pembayaranModel->insert([
                            // 'pmbCheckoutId' => $checkoutId,
                            'pmbId' => $uuid,
                            'pmbPaymentType' => 'cod',
                            'pmbStatus' => 'pending',
                            'pmbTime' => $dateTime,
                            'pmbOrderId' => $orderId,
                            'pmbGrossAmount' => $price,
                            'pmbCurrency' => 'IDR',
                            'pmbUserEmail' => $this->user['email'],
                            'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime($dateTime . " +" . self::LIMIT_DAY_COD . " days")),
                        ]);

                        // Update ID Pembayaran Checkout
                        $checkoutModel->update($checkoutId, [
                            'cktpPmbId' => $uuid,
                        ]);

                        $checkoutModel->transComplete();

                        $pembayaranModel = new PembayaranModel();
                        return $this->response($pembayaranModel->find($uuid), 200);
                    }
                    // Pembayaran Menggunakan Saldo
                    else if ($post['id_metode_pembayaran'] == self::SALDO_PAYMENT_ID) {
                        // SALDO
                        $modelUser = new UserModel();
                        $dataUser = $modelUser->find($this->user['email']);

                        // Jika saldo memenuhi
                        if ($dataUser->saldo >= $price) {
                            $modelUser->update($this->user['email'], [
                                'usrSaldo' => $dataUser->saldo - $price,
                            ]);
                        } else {
                            return $this->response(null, 403, 'Saldo anda tidak memenuhi, topup untuk menambahkan saldo anda');
                        }

                        $orderId = 'ORDER-' . strtotime("now");
                        // Tambah Riwayat saldo
                        $userSaldoModel = new UserSaldoModel();
                        $userSaldoModel->insert([
                            'usalId' => Uuid::uuid4(),
                            'usalPaymentType' => 'saldo',
                            'usalStatus' => 'settlement',
                            'usalTime' => date('Y-m-d H:i:s'),
                            'usalOrderId' => $orderId,
                            'usalUserEmail' => $this->user['email'],
                            'usalStatusSaldo' => 'top_down',
                            'usalGrossAmount' => -$price,
                        ]);

                        // Tambah Riwayat pembayaran
                        $pembayaranModel = new PembayaranModel();
                        $uuid = Uuid::uuid4();
                        $pembayaranModel->insert([
                            // 'pmbCheckoutId' => $checkoutId,
                            'pmbId' => $uuid,
                            'pmbPaymentType' => 'saldo',
                            'pmbStatus' => 'settlement',
                            'pmbTime' => date('Y-m-d H:i:s'),
                            'pmbSignatureKey' => '',
                            'pmbOrderId' => $orderId,
                            'pmbGrossAmount' => $price,
                            'pmbUserEmail' => $this->user['email'],
                            'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +1 days")),
                        ]);

                        // Update Checkout
                        $checkoutModel = new CheckoutModel();
                        $checkoutModel->update($checkoutId, [
                            'cktStatus' => 'dikemas',
                            'cktpPmbId' => $uuid,
                        ]);

                        $checkoutModel->transComplete();

                        $response = current($pembayaranModel->where('pmbId', $uuid)->find());
                        return $this->response($response, 200, $uuid);

                        // Topup menggunakan pembayaran manual ke rekening
                    } else if (in_array($post['id_metode_pembayaran'], self::MANUAL_TRANSFER_IDS)) {
                        // Manual Transfer
                        $metodePembayaranModel = new MetodePembayaranModel();
                        $metodePembayaranData = $metodePembayaranModel->find($post['id_metode_pembayaran']);

                        $dateTime = date('Y-m-d H:i:s');
                        $uuid = Uuid::uuid4() . '-manual';
                        $orderId = 'ORDER-' . strtotime("now");;

                        $bank = $metodePembayaranData->bank;

                        $pembayaranModel = new PembayaranModel();
                        $pembayaranModel->insert([
                            // 'pmbCheckoutId' => $checkoutId,
                            'pmbId' => $uuid,
                            'pmbPaymentType' => 'manual_transfer',
                            'pmbStatus' => 'pending',
                            'pmbTime' => $dateTime,
                            'pmbOrderId' => $orderId,
                            'pmbGrossAmount' => $price,
                            'pmbCurrency' => 'IDR',
                            'pmbRekNumber' => $metodePembayaranData->rekNumber,
                            'pmbBank' => $bank,
                            'pmbUserEmail' => $this->user['email'],
                            'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime($dateTime . " +" . self::LIMIT_DAY_MANUAL_TRANSFER . " days")),
                        ]);

                        // Update ID Pembayaran Checkout
                        $checkoutModel->update($checkoutId, [
                            'cktpPmbId' => $uuid,
                        ]);

                        $checkoutModel->transComplete();

                        $pembayaranModel = new PembayaranModel();
                        return $this->response($pembayaranModel->find($uuid), 200);

                        // Pembayaran Menggunakan Mid Trans
                    } else {
                        // MID TRANS
                        $metodePembayaranModel = new MetodePembayaranModel();
                        $metodePembayaranData = $metodePembayaranModel->find($post['id_metode_pembayaran']);

                        $bank = $metodePembayaranData->bank;

                        $midTransPayment = new MidTransPayment();
                        $data  = $midTransPayment->charge($metodePembayaranData, array(
                            'email' => $this->user['email'],
                            'first_name' => $this->user['nama'],
                            'last_name' => '',
                            'phone' => $this->user['noHp'],
                        ), array(
                            0 => array(
                                'id' => 'Order',
                                'price' => $price,
                                'quantity' => 1,
                                'name' => 'Order Produk Menyambang',
                            )
                        ), $bank, $price, 'ORDER');

                        if ($data['status_code'] == 201) {
                            $pembayaranModel = new PembayaranModel();
                            $pembayaranModel->insert([
                                // 'pmbCheckoutId' => $checkoutId,
                                'pmbId' => $data['transaction_id'],
                                'pmbPaymentType' => $data['payment_type'],
                                'pmbStatus' => $data['transaction_status'],
                                'pmbTime' => $data['transaction_time'],
                                'pmbSignatureKey' => '',
                                'pmbOrderId' => $data['order_id'],
                                'pmbMerchantId' => $data['merchant_id'],
                                'pmbGrossAmount' => $data['gross_amount'],
                                'pmbCurrency' => $data['currency'],
                                'pmbVaNumber' => $data['permata_va_number'] ?? $data['va_numbers'][0]['va_number'] ?? '',
                                'pmbBank' => isset($data['permata_va_number']) ? 'permata' : $data['va_numbers'][0]['bank'] ?? 'mandiri',
                                'pmbBillerCode' => $data['biller_code'] ?? '',
                                'pmbBillKey' => $data['bill_key'] ?? '',
                                'pmbUserEmail' => $this->user['email'],
                                'pmbPaymentCode' => $data['payment_code'] ?? '',
                                'pmbStore' => $data['store'] ?? '',
                                'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime($data['transaction_time'] . " +" . self::LIMIT_DAY_MIDTRANS . " days")),
                            ]);

                            // Update ID Pembayaran Checkout
                            $checkoutModel->update($checkoutId, [
                                'cktpPmbId' => $data['transaction_id'],
                            ]);

                            $checkoutModel->transComplete();

                            return $this->response($pembayaranModel->find($data['transaction_id']), 200);
                        }
                    }
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
