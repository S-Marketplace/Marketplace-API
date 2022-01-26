<?php namespace App\Controllers\Api;

use App\Models\KategoriModel;
use App\Models\ProdukGambarModel;
use App\Controllers\MyResourceController;
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

   public function index()
    {
        $this->model->select('*');
        $this->model->where(['krjUserEmail' => $this->user['email']]);
        $this->model->with(['products']);
        
        $this->applyQueryFilter();
        $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        if ($limit != "-1") {
            $this->model->limit($limit);
        }
        $this->model->offset($offset);
        
        $data = $this->model->find();

        $data = array_map(function($e){
            $e = $e;
            $produkGambarModel = new ProdukGambarModel();
            $kategoriModel = new KategoriModel();
            $combine['kategori'] = $kategoriModel->find($e->products->kategoriId);
            $combine['gambar'] = $produkGambarModel->where(['prdgbrProdukId' =>$e->products->id])->find();
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
