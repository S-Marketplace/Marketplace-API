<?php

namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\CheckoutModel;
use App\Models\KategoriModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Models\PembayaranModel;
use App\Models\UserAlamatModel;
use App\Models\ProdukGambarModel;
use App\Libraries\MidTransPayment;
use App\Models\CheckoutKurirModel;
use App\Models\CheckoutDetailModel;
use App\Models\MetodePembayaranModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Keranjang
 * @note Resource untuk mengelola data t_keranjang
 * @dataDescription t_keranjang
 * @package App\Controllers
 */
class Keranjang extends MyResourceController
{
    const SALDO_PAYMENT_ID = '1';

    protected $modelName = 'App\Models\KeranjangModel';
    protected $format    = 'json';

    protected $ubahKeranjang = [
        'produkId' => ['label' => 'produkId', 'rules' => 'required|in_table[m_produk,produkId]'],
        'quantity' => ['label' => 'quantity', 'rules' => 'required'],
    ];

    protected $checkedKeranjang = [
        'checked' => ['label' => 'checked', 'rules' => 'in_list[0,1]'],
    ];

    protected $checkout = [
        'kurirId' => ['label' => 'kurirId', 'rules' => 'required|in_list[jne,jnt]'],
        'kurirNama' => ['label' => 'Kurir Nama', 'rules' => 'required'],
        'kurirService' => ['label' => 'Kurir Service', 'rules' => 'required'],
        'kurirDeskripsi' => ['label' => 'Kurir Deskripsi', 'rules' => 'required'],
        'kurirCost' => ['label' => 'Kurir Cost', 'rules' => 'required|numeric'],
        'ongkir' => ['label' => 'ongkir', 'rules' => 'required|numeric'],
        'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    public function ubahKeranjang()
    {
        $userEmail = $this->user['email'];

        if ($this->validate($this->ubahKeranjang, $this->validationMessage)) {
            $entityClass = $this->model->getReturnType();
            $entity = new $entityClass();

            $data = $this->request->getVar();
            $data['userEmail'] = $userEmail;
            $entity->fill($data);

            $where = ['krjUserEmail' => $userEmail, 'krjProdukId' => $data['produkId'], 'krjCheckoutId' => null];

            $sudahPesanSebelumnya = $this->model->where($where)->countAllResults();

            try {
                if ($data['quantity'] <= 0) {
                    $this->model->where($where)
                        ->delete();
                } elseif ($sudahPesanSebelumnya) {
                    $this->model->where($where)
                        ->update(null, [
                            'krjQuantity' => $data['quantity'],
                        ]);
                } else {
                    $this->model
                        ->insert([
                            'krjQuantity' => $data['quantity'],
                            'krjProdukId' => $data['produkId'],
                            'krjUserEmail' => $userEmail,
                        ]);
                }

                return $this->response(null, 200, 'Berhasil menambahkan ke keranjang');
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

    public function checkedKeranjang()
    {
        $userEmail = $this->user['email'];

        if ($this->validate($this->checkedKeranjang, $this->validationMessage)) {
            $data = $this->request->getVar();
            $data['userEmail'] = $userEmail;

            try {
                if (isset($data['produkId']) && !empty($data['produkId'])) {
                    $where = ['krjUserEmail' => $userEmail, 'krjProdukId' => $data['produkId'], 'krjCheckoutId' => null];
    
                    $this->model->where($where)
                        ->update(null, [
                            'krjIsChecked' => $data['checked'],
                        ]);
                  
                    return $this->response(null, 200, 'Berhasil mengubah checked');
                }else{
                    $where = ['krjUserEmail' => $userEmail, 'krjCheckoutId' => null];
    
                    $this->model->where($where)
                        ->update(null, [
                            'krjIsChecked' => $data['checked'],
                        ]);
                  
                    return $this->response(null, 200, 'Berhasil mengubah checked');
                }
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

    public function checkout()
    {
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
                    'cktCatatan' => $post['catatan'],
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
                            'cktdtBiaya' => $post['ongkir'],
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
                                'usalGrossAmount' => $price,
                            ]);

                            // Tambah Riwayat pembayaran
                            $pembayaranModel = new PembayaranModel();
                            $pembayaranModel->insert([
                                'pmbCheckoutId' => $checkoutId,
                                'pmbId' => Uuid::uuid4(),
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
                            return $this->response(null, 200, 'Pembayaran Sukses');
                        } else {
                            // MID TRANS
                            $metodePembayaranModel = new MetodePembayaranModel();
                            $metodePembayaranData = $metodePembayaranModel->find($post['id_metode_pembayaran']);
    
                            $metodePembayaran = $metodePembayaranData->tipe;
                            $bank = $metodePembayaranData->bank;
    
                            $midTransPayment = new MidTransPayment();
                            $data  = $midTransPayment->charge($metodePembayaran, array(
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

    public function index()
    {
        $this->model->select('*');
        $this->model->where(['krjUserEmail' => $this->user['email']]);
        $this->model->where(['krjCheckoutId' => null]);
        $this->model->with(['products']);

        $this->applyQueryFilter();
        $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        if ($limit != "-1") {
            $this->model->limit($limit);
        }
        $this->model->offset($offset);

        $data = $this->model->find();

        $data = array_map(function ($e) {
            $e = $e;
            $produkGambarModel = new ProdukGambarModel();
            $kategoriModel = new KategoriModel();
            $combine['kategori'] = $kategoriModel->find($e->products->kategoriId);
            $combine['gambar'] = $produkGambarModel->where(['prdgbrProdukId' => $e->products->id])->find();
            $e->products = array_merge((array)$e->products, $combine);
            return $e;
        }, $data);

        try {
            return $this->response([
                'rows' => $data,
                'limit' => $limit,
                'offset' => $offset,
            ]);
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }
}
