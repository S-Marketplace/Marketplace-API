<?php namespace App\Models\Pulsa;

use App\Entities\ProdukPulsa;
use App\Models\MyModel;

class KategoriPulsaModel extends MyModel
{
    protected $table = "m_kategori_pulsa";
    protected $primaryKey = "kpId";
    protected $createdField = "kpCreatedAt";
    protected $updatedField = "kpUpdatedAt";
    protected $returnType = "App\Entities\KategoriPulsa";
    protected $allowedFields = ["kpId","kpKelompok","kpNama","kpIcon","kpUrutan","kpDeletedAt"];

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
        ];
    }
}