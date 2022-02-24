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
    protected $modelName = 'App\Models\KeranjangModel';
    protected $format    = 'json';

    protected $ubahKeranjang = [
        'produkId' => ['label' => 'produkId', 'rules' => 'required|in_table[m_produk,produkId]'],
        'quantity' => ['label' => 'quantity', 'rules' => 'required'],
    ];

    protected $checkedKeranjang = [
        'checked' => ['label' => 'checked', 'rules' => 'in_list[0,1]'],
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

    public function index()
    {
        $keranjangModel = new KeranjangModel();

        $keranjangModel->select('*');
        $keranjangModel->where(['krjUserEmail' => $this->user['email']]);
        $keranjangModel->where(['krjCheckoutId' => null]);
        $keranjangModel->with(['products']);

        $this->applyQueryFilter();
        $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        if ($limit != "-1") {
            $keranjangModel->limit($limit);
        }
        $keranjangModel->offset($offset);

        $data = $keranjangModel->find();

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

    public function keranjangCheckoutDetail($id){
        try {
            return $this->response(null, 500, $this->model->getKeranjangDetail($id));
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }
}
