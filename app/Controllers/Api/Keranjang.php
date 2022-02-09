<?php

namespace App\Controllers\Api;

use App\Models\KategoriModel;
use App\Models\ProdukGambarModel;
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

    protected $rulesCreate = [
        'produkId' => ['label' => 'produkId', 'rules' => 'required'],
        'quantity' => ['label' => 'quantity', 'rules' => 'required'],
        'pesan' => ['label' => 'pesan', 'rules' => 'required'],
        'checkoutId' => ['label' => 'checkoutId', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
        'userEmail' => ['label' => 'userEmail', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'produkId' => ['label' => 'produkId', 'rules' => 'required'],
        'quantity' => ['label' => 'quantity', 'rules' => 'required'],
        'pesan' => ['label' => 'pesan', 'rules' => 'required'],
        'checkoutId' => ['label' => 'checkoutId', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
        'userEmail' => ['label' => 'userEmail', 'rules' => 'required'],
    ];

    protected $ubahKeranjang = [
        'produkId' => ['label' => 'produkId', 'rules' => 'required|in_table[m_produk,produkId]'],
        'quantity' => ['label' => 'quantity', 'rules' => 'required'],
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

            $where = ['krjUserEmail' => $userEmail, 'krjProdukId' => $data['produkId']];

            $sudahPesanSebelumnya = $this->model->where($where)->countAllResults();

            try {

                if ($data['quantity'] <= 0) {
                    $this->model->where($where)
                        ->delete();
                } else if ($sudahPesanSebelumnya) {
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
