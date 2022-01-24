<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class Produk extends MyResourceController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $format    = 'json';

    public function index()
    {
        $this->model->select('*');
        $this->model->withGambarProduk();

        return parent::index();
    }
}
