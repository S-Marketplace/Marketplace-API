<?php namespace App\Controllers\Api;

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
        return parent::index();
    }
}
