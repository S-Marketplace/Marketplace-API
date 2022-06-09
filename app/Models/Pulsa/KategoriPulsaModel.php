<?php namespace App\Models\Pulsa;

use App\Entities\MenuDigital;
use App\Entities\ProdukPulsa;
use App\Models\MyModel;

class KategoriPulsaModel extends MyModel
{
    protected $table = "m_kategori_pulsa";
    protected $primaryKey = "kpId";
    protected $createdField = "kpCreatedAt";
    protected $updatedField = "kpUpdatedAt";
    protected $returnType = "App\Entities\KategoriPulsa";
    protected $allowedFields = ["kpId","kpPrefix","kpNama","kpIcon","kpUrutan","kpMenuId","kpDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships(){
        return [
            'produk' => $this->hasMany('m_produk_pulsa', ProdukPulsa::class, 'ppKpId = kpId', 'produk', 'ppKpId'),
            'menu' => $this->belongsTo('m_menu_digital', MenuDigital::class, 'mdId = kpMenuId', 'menu', 'mdId'),
        ];
    }

    public function selectKategori(){
        $this->select("kpId, kpNama");
        $this->where("kpDeletedAt", null);
        $this->orderBy("kpNama", "ASC");
        $data = $this->findAll();

        $select= [];
        foreach ($data as $key => $value) {
            $select[$value->kpId] = $value->kpNama;
        }

        return $select;
    }
}