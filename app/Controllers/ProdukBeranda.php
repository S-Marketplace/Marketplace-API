<?php namespace App\Controllers;

use App\Models\ProdukBerandaModel;
use CodeIgniter\Config\Config;
use App\Models\ProdukBerandaTransModel;
use App\Models\ProdukGambarModel;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class ProdukBeranda extends BaseController
{
    protected $modelName = 'App\Models\ProdukBerandaModel';
    protected $format    = 'json';

    protected $rules = [
       'banner' => ['label' => 'banner', 'rules' => 'required'],
       'judul' => ['label' => 'judul', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
   ];


   public function index()
    {
        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/index");
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->withProduk();

        return parent::grid();
    }

    public function test(){
        $data = $this->model->getDetailProdukBeranda(1);
        return $this->response->setJSON($data);
    }

    public function tambah()
    {
        $data = [
       ];
      
        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/tambah", $data);
    }

    public function ubah($produkId)
    {
        $data = [
           'data' => $this->model->getDetailProdukBeranda($produkId),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/tambah", $data);
    }

    public function tambahProduk($produkId)
    {
        $produk = new ProdukBerandaTransModel();
        $produk->with(['produk']);
        echo '<pre>';
        print_r($produk->where(['tpbPbId' => $produkId])->find());
        echo '</pre>';exit;
        $data = [
           'produk' => $this->model->asObject()->find($produkId),
           'produkList' => $produk->where(['tpbPbId' => $produkId])->asObject()->find(),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/tambah", $data);
    }

    protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "banner_gambar";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("banner");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['banner'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("banner");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['banner'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->banner != '') {
                unset($this->rules['banner']);
            }
        }
        
        return parent::simpan($primary);
    }
}
