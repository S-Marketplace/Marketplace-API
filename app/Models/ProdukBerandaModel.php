<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\ProdukGambar;
use App\Entities\ProdukBerandaTrans;

class ProdukBerandaModel extends MyModel
{
    protected $table = "m_produk_beranda";
    protected $primaryKey = "pbId";
    protected $createdField = "pbCreatedAt";
    protected $updatedField = "pbUpdatedAt";
    protected $returnType = "App\Entities\ProdukBeranda";
    protected $allowedFields = ["pbBanner","pbJudul","pbDeskripsi","pbDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function withProduk(){
        return $this->hasMany("(SELECT * FROM `t_produk_beranda` tpb JOIN `m_produk` p ON  tpb.`tpbProdukId` = p.`produkId`) as produk","tpbPbId = pbId",Produk::class,"products",'-');
    }


    public function getDetailProdukBeranda($idProdukBeranda = null){
        $this->select('*');
        $this->with(['anjay']);
        $this->withProduk();
        $data = $this->find($idProdukBeranda);
        
        if(is_array($data)){
            $data = array_map(function($e){
                $e = $e;
                $e->products = array_map(function($produk){
                    $produkGambarModel = new ProdukGambarModel();
                    $produk->gambar = $produkGambarModel->where(['prdgbrProdukId' => $produk->id])->find();
                    return $produk;
                }, $e->products);
                return $e;
            }, $data);
        }else if(!empty($data)){
            $data->products = array_map(function($produk){
                $produkGambarModel = new ProdukGambarModel();
                $produk->gambar = $produkGambarModel->where(['prdgbrProdukId' => $produk->id])->find();
                return $produk;
            }, $data->products);
            return $data;
        }

        return $data;
    }
}