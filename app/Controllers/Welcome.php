<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\Eloquent\Users;
use App\Models\Eloquent\ProdukM;
use App\Controllers\BaseController;
use App\Models\Eloquent\ProdukBerandaM;
use App\Models\Eloquent\UserM;

class Welcome extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';

    public function index()
    {   
        $kategoriModel = new KategoriModel();

        $data = [
            'kategori' => $kategoriModel->find(),
        ];

        return view('Welcome/index',$data);
    }

    public function test(){
        $Users = UserM::with(['alamat'])->first();

        return $this->response->setJSON($Users);
    }

    public function testProduk(){
        $produk = ProdukBerandaM::with(['produk'])->first();
        // $produk = ProdukM::with(['gambar'])->first();

        return $this->response->setJSON($produk);
    }

    public function test1(){
        
        $Users = UserM::join('m_user_alamat', function ($join) {
            $join->on('usrEmail', '=', 'usralUsrEmail');
        })
        ->get();

        return $this->response->setJSON($Users);
    }

     /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori']);
        $this->model->withGambarProduk();

        return parent::grid();
    }

    public function coming_soon()
    {
        return view('Welcome/coming-soon');
    }
    
}
