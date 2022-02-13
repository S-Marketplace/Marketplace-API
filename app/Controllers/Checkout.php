<?php namespace App\Controllers;

use App\Controllers\MyResourceController;
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
       'kurir' => ['label' => 'kurir', 'rules' => 'required'],
       'noResiKurir' => ['label' => 'noResiKurir', 'rules' => 'required'],
       'catatan' => ['label' => 'catatan', 'rules' => 'required'],
       'alamatId' => ['label' => 'alamatId', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'status' => ['label' => 'status', 'rules' => 'required'],
       'kurir' => ['label' => 'kurir', 'rules' => 'required'],
       'noResiKurir' => ['label' => 'noResiKurir', 'rules' => 'required'],
       'catatan' => ['label' => 'catatan', 'rules' => 'required'],
       'alamatId' => ['label' => 'alamatId', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
