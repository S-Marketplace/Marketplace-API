<?php namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Models\PembayaranModel;
use App\Models\UserAlamatModel;
use App\Libraries\MidTransPayment;
use App\Models\CheckoutKurirModel;
use App\Models\CheckoutDetailModel;
use App\Models\MetodePembayaranModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Checkout
 * @note Resource untuk mengelola data t_checkout
 * @dataDescription t_checkout
 * @package App\Controllers
 */
class Checkout extends MyResourceController
{
    const SALDO_PAYMENT_ID = '1';

    protected $modelName = 'App\Models\CheckoutModel';
    protected $format    = 'json';

    protected $checkout = [
        'kurirId' => ['label' => 'kurirId', 'rules' => 'required|in_list[jne,jnt]'],
        'kurirNama' => ['label' => 'Kurir Nama', 'rules' => 'required'],
        'kurirService' => ['label' => 'Kurir Service', 'rules' => 'required'],
        'kurirDeskripsi' => ['label' => 'Kurir Deskripsi', 'rules' => 'required'],
        'kurirCost' => ['label' => 'Kurir Cost', 'rules' => 'required|numeric'],
        'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    protected $rulesCreate = [
       'status' => ['label' => 'status', 'rules' => 'required'],
       'catatan' => ['label' => 'catatan', 'rules' => 'required'],
       'alamatId' => ['label' => 'alamatId', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'status' => ['label' => 'status', 'rules' => 'required'],
       'catatan' => ['label' => 'catatan', 'rules' => 'required'],
       'alamatId' => ['label' => 'alamatId', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    public function index()
    {
        $post = $this->request->getGet();
        $post['pembayaran_userEmail']['eq'] = $this->user['email'];
        $this->request->setGlobal("get", $post);

        $this->model->select('*');
        $this->model->withDetail();
        return parent::index();
    }

    /**
     * Detail Keranjang
     *
     * @param [type] $id
     * @return void
     */
    public function detailKeranjang($id){
        try {
            $modelKeranjang = new KeranjangModel();
            return $this->response($modelKeranjang->getKeranjangDetail($id), 200);
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }

    public function terimaPaket($id){
        try {
            $checkoutModel = new CheckoutModel();
            $checkoutModel->update($id, ['cktStatus' => 'selesai']);

            return $this->response(null, 200, 'Paket berhasil diteima');
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }

    /**
     * Checkout Produk
     *
     * @return void
     */
    public function checkout()
    {
        $post = $this->request->getVar();
        if(isset($post['kurirId'])){
            switch ($post['kurirId']) {
                case 'J&T':
                    $post['kurirId'] = 'jnt';
                    break;
            }
        }
        $this->request->setGlobal("request", $post);

        if ($this->validate($this->checkout, $this->validationMessage)) {
            try {
                $post = $this->request->getPost();
                $keranjangModel = new KeranjangModel();

                $dataKeranjang = $keranjangModel->getProdukKeranjang($this->user['email']);

                if ($dataKeranjang['jumlah'] == 0) {
                    return $this->response(null, 403, 'Keranjang anda kosong');
                }
                
                // Ambil alamat yang aktif
                $userAlamat = new UserAlamatModel();
                $userAlamat = $userAlamat->where(['usralUsrEmail' => $this->user['email'], 'usralIsActive' => 1])->find();
                $userAlamat = current($userAlamat);
                $userAlamatId = $userAlamat->id;

                // Tambahkan data checkout
                $checkoutModel = new CheckoutModel();
                $checkoutModel->transStart();
                $checkoutId = $checkoutModel->insert([
                    'cktStatus' => 'belum_bayar',
                    'cktCatatan' => $post['catatan'] ?? '',
                    'cktAlamatId' => $userAlamatId,
                ]);
                $checkoutModelStatus = $checkoutModel->transStatus();

                $checkoutKurirModel = new CheckoutKurirModel();
                $checkoutKurirModel->transStart();
                
                // if(!empty($post['kurirId'])){
                    // Menambahkan Detail Kurir
                    $checkoutKurirModel->insert([
                        'ckurCheckoutId' => $checkoutId,
                        'ckurKurir' => $post['kurirId'],
                        'ckurNama' => $post['kurirNama'],
                        'ckurService' => $post['kurirService'],
                        'ckurDeskripsi' => $post['kurirDeskripsi'],
                        'ckurCost' => $post['kurirCost'],
                    ]);
                // }

                if ($checkoutModelStatus) {

                    // Tambahkan checkout detail
                    $checkoutDetail = new CheckoutDetailModel();
                    $checkoutDetail->transStart();
                    
                    $checkoutDetailStatus = $checkoutDetail->transStatus();

                    $rincianPembayaran = [
                        [
                            'cktdtCheckoutId' => $checkoutId,
                            'cktdtKeterangan' => 'Subtotal produk',
                            'cktdtBiaya' => $dataKeranjang['harga'],
                        ],
                        [
                            'cktdtCheckoutId' => $checkoutId,
                            'cktdtKeterangan' => 'Ongkos Kirim',
                            'cktdtBiaya' => $post['kurirCost'],
                        ]
                    ];

                    $checkoutDetail->insertBatch($rincianPembayaran);

                    if ($checkoutDetailStatus) {
                        // Pembayaran
                        $price = array_sum(array_column($rincianPembayaran, 'cktdtBiaya'));

                        if ($post['id_metode_pembayaran'] == self::SALDO_PAYMENT_ID) {
                            // SALDO
                            $modelUser = new UserModel();
                            $dataUser = $modelUser->find($this->user['email']);

                            // Jika saldo memenuhi
                            if ($dataUser->saldo >= $price) {
                                $modelUser->update($this->user['email'], [
                                    'usrSaldo' => $dataUser->saldo - $price,
                                ]);
                            } else {
                                return $this->response(null, 403, 'Saldo anda tidak memenuhi, topup untuk emnambahkan saldo anda');
                            }

                            // Tambah Riwayat saldo
                            $userSaldoModel = new UserSaldoModel();
                            $userSaldoModel->insert([
                                'usalId' => Uuid::uuid4(),
                                'usalPaymentType' => 'saldo',
                                'usalStatus' => 'settlement',
                                'usalTime' => date('Y-m-d H:i:s'),
                                'usalUserEmail' => $this->user['email'],
                                'usalStatusSaldo' => 'top_down',
                                'usalGrossAmount' => -$price,
                            ]);

                            // Tambah Riwayat pembayaran
                            $pembayaranModel = new PembayaranModel();
                            $uuid = Uuid::uuid4();
                            $pembayaranModel->insert([
                                'pmbCheckoutId' => $checkoutId,
                                'pmbId' => $uuid,
                                'pmbPaymentType' => 'saldo',
                                'pmbStatus' => 'settlement',
                                'pmbTime' => date('Y-m-d H:i:s'),
                                'pmbSignatureKey' => '',
                                'pmbOrderId' => 'ORDER-'.strtotime("now"),
                                'pmbGrossAmount' => $price,
                                'pmbUserEmail' => $this->user['email'],
                                'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " +1 days")),
                            ]);

                            // Update Checkout
                            $checkoutModel = new CheckoutModel();
                            $checkoutModel->update($checkoutId, [
                                'cktStatus' => 'dikemas'
                            ]);

                            $checkoutModel->transComplete();
                            $checkoutDetail->transComplete();
                            $checkoutKurirModel->transComplete();

                            $keranjangModel->updateKeranjangToCheckout($checkoutId, $this->user['email']);
                            $keranjangModel->updateProdukStok($checkoutId);

                            $response = current($pembayaranModel->where('pmbId', $uuid)->find());
                            return $this->response($response, 200, $uuid);
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
                                    'pmbCheckoutId' => $checkoutId,
                                    'pmbId' => $data['transaction_id'],
                                    'pmbPaymentType' => $data['payment_type'],
                                    'pmbStatus' => $data['transaction_status'],
                                    'pmbTime' => $data['transaction_time'],
                                    'pmbSignatureKey' => '',
                                    'pmbOrderId' => $data['order_id'],
                                    'pmbMerchantId' => $data['merchant_id'],
                                    'pmbGrossAmount' => $data['gross_amount'],
                                    'pmbCurrency' => $data['currency'],
                                    'pmbVaNumber' => $data['va_numbers'][0]['va_number'] ?? '',
                                    'pmbBank' => $data['va_numbers'][0]['bank'] ?? '',
                                    'pmbBillerCode' => $data['biller_code'] ?? '',
                                    'pmbBillKey' => $data['bill_key'] ?? '',
                                    'pmbUserEmail' => $this->user['email'],
                                    'pmbPaymentCode' => $data['payment_code'] ?? '',
                                    'pmbExpiredDate' => date('Y-m-d H:i:s', strtotime($data['transaction_time'] . " +1 days")),
                                ]);
    
                                $checkoutModel->transComplete();
                                $checkoutDetail->transComplete();
                                $checkoutKurirModel->transComplete();

                                $keranjangModel->updateKeranjangToCheckout($checkoutId, $this->user['email']);
    
                                return $this->response($pembayaranModel->find($data['transaction_id']), 200);
                            }
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
