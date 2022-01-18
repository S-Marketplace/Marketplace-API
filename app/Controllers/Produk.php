<?php namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use App\Controllers\MyResourceController;
use App\Models\ProdukGambarModel;

/**
 * Class Produk
 * @note Resource untuk mengelola data m_produk
 * @dataDescription m_produk
 * @package App\Controllers
 */
class Produk extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $format    = 'json';

    protected $rules = [
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'harga' => ['label' => 'harga', 'rules' => 'required|numeric'],
       'stok' => ['label' => 'stok', 'rules' => 'required|numeric'],
       'hargaPer' => ['label' => 'hargaPer', 'rules' => 'required'],
       'berat' => ['label' => 'berat', 'rules' => 'required|numeric'],
       'kategoriId' => ['label' => 'Kategori', 'rules' => 'required'],
       'gambar[]' => ['label' => 'Gambar', 'rules' => 'required'],
   ];

    public function index()
    {
        return $this->template->setActiveUrl('Produk')
           ->view("Produk/index");
    }

    private function getKategori()
    {
        $kategoriModel = new KategoriModel();

        $kategoriData = $kategoriModel->asObject()->find();

        $res = [];
        foreach ($kategoriData as $key => $value) {
            $res[$value->ktgId] = $value->ktgNama;
        }
        return $res;
    }

    public function tambah()
    {
        $data = [
           'kategori' => $this->getKategori(),
       ];
      
        return $this->template->setActiveUrl('Produk')
           ->view("Produk/tambah", $data);
    }

    public function ubah($produkId)
    {
        $data = [
           'kategori' => $this->getKategori(),
           'produk' => $this->model->asObject()->find($produkId),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('Produk')
           ->view("Produk/tambah", $data);
    }

    protected function uploadFile($id)
    {
        $produkGambarModel = new ProdukGambarModel();
        foreach($this->request->getFileMultiple('gambar') as $file)
        {   
            $file->move(WRITEPATH . 'uploads/produk_gambar');

            $data = [
                'prdgbrProdukId' =>  $id,
                'prdgbrFile' =>  $file->getClientName(),
            ];

            $save = $produkGambarModel->insert($data);

            $post = $this->request->getVar();
            $post['gambar[]'] = 'filename';
            $this->request->setGlobal("request", $post);
        }
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori']);

        return parent::grid();
    }

    public function simpan($primary = '')
    {
        // $id = $this->request->getVar('id');
        // if ($id != '') {
        //     $checkData = $this->checkData($id);
        //     if (!empty($checkData) && $checkData->icon != '') {
        //     }
        // }
        unset($this->rules['gambar[]']);

        $this->isUploadWithId = true;
        return parent::simpan($primary);
    }
}
