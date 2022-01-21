<?php namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Config\Config;
use App\Models\ProdukGambarModel;
use App\Controllers\BaseController;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

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
       'diskon' => ['label' => 'Diskon', 'rules' => 'required|numeric'],
    //    'hargaPer' => ['label' => 'hargaPer', 'rules' => 'required'],
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
        $produkGambar = new ProdukGambarModel();

        $data = [
           'kategori' => $this->getKategori(),
           'produk' => $this->model->asObject()->find($produkId),
           'produkGambar' => $produkGambar->where(['prdgbrProdukId' => $produkId])->asObject()->find(),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('Produk')
           ->view("Produk/tambah", $data);
    }

    public function hapusGambar($id, $produkId){
        try {
            $produkGambar = new ProdukGambarModel();
            $length = $produkGambar->where(['prdgbrProdukId' => $produkId])->asObject()->find();

            if(count($length) <= 1){
			    $response = $this->response(null, '500', 'Tidak bisa dihapus, setidaknya minimal ada 1 gambar');
    			return $this->response->setJSON($response);
            }

            $status = $produkGambar->delete($id);

			$response = $this->response(null, ($status ? 200 : 500));
			return $this->response->setJSON($response);
		} catch (DatabaseException $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		} catch (\mysqli_sql_exception $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		} catch (\Exception $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		}
    }

    protected function uploadFile($id)
    {
        $produkGambarModel = new ProdukGambarModel();
        foreach($this->request->getFileMultiple('gambar') as $file)
        {   
            if($file->getClientName() == ''){
                continue;
            }

            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/produk_gambar', $newName);

            $data = [
                'prdgbrProdukId' =>  $id,
                'prdgbrFile' =>  $newName,
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
        $this->model->withGambarProduk();

        return parent::grid();
    }

    public function simpan($primary = '')
    {
        $file = current($this->request->getFileMultiple("gambar"));
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['gambar[]'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
           
            if (!empty($checkData)) {
                unset($this->rules['gambar[]']);
            }
        }

        $this->isUploadWithId = true;
        return parent::simpan($primary);
    }
}
