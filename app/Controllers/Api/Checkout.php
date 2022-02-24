<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Models\KeranjangModel;

/**
 * Class Checkout
 * @note Resource untuk mengelola data t_checkout
 * @dataDescription t_checkout
 * @package App\Controllers
 */
class Checkout extends MyResourceController
{
    protected $modelName = 'App\Models\CheckoutModel';
    protected $format    = 'json';

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

    public function detailKeranjang($id){
        try {
            $modelKeranjang = new KeranjangModel();
            return $this->response($modelKeranjang->getKeranjangDetail($id), 200);
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }
}
