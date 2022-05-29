<?php namespace App\Controllers;

use CodeIgniter\Config\Config;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class ProdukPulsa extends BaseController
{
    protected $modelName = 'App\Models\Pulsa\ProdukPulsaModel';
    protected $format    = 'json';

    protected $rules = [
        'kode' => ['label' => 'kode', 'rules' => 'required'],
        'kategoriId' => ['label' => 'kategoriId', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
        // 'urutan' => ['label' => 'urutan', 'rules' => 'required'],
        'kodeSuplier' => ['label' => 'kodeSuplier', 'rules' => 'required'],
        'jenis' => ['label' => 'jenis', 'rules' => 'required'],
        'poin' => ['label' => 'poin', 'rules' => 'required'],
        'jamOperasional' => ['label' => 'jamOperasional', 'rules' => 'required'],
        'harga' => ['label' => 'harga', 'rules' => 'required'],
    ];
 
   public function index()
   {
       return $this->template->setActiveUrl('ProdukPulsa')
           ->view("ProdukPulsa/index");
   }
}
