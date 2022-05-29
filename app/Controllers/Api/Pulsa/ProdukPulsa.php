<?php namespace App\Controllers\Api\Pulsa;

use App\Controllers\MyResourceController;
/**
 * Class ProdukPulsa
 * @note Resource untuk mengelola data m_produk_pulsa
 * @dataDescription m_produk_pulsa
 * @package App\Controllers
 */
class ProdukPulsa extends MyResourceController
{
    protected $modelName = 'App\Models\Pulsa\ProdukPulsaModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'kode' => ['label' => 'kode', 'rules' => 'required'],
       'kategoriId' => ['label' => 'kategoriId', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'kodeSuplier' => ['label' => 'kodeSuplier', 'rules' => 'required'],
       'jenis' => ['label' => 'jenis', 'rules' => 'required'],
       'poin' => ['label' => 'poin', 'rules' => 'required'],
       'jamOperasional' => ['label' => 'jamOperasional', 'rules' => 'required'],
       'harga' => ['label' => 'harga', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'kode' => ['label' => 'kode', 'rules' => 'required'],
       'kategoriId' => ['label' => 'kategoriId', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'kodeSuplier' => ['label' => 'kodeSuplier', 'rules' => 'required'],
       'jenis' => ['label' => 'jenis', 'rules' => 'required'],
       'poin' => ['label' => 'poin', 'rules' => 'required'],
       'jamOperasional' => ['label' => 'jamOperasional', 'rules' => 'required'],
       'harga' => ['label' => 'harga', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
