<?php namespace App\Models\Pulsa;

use App\Entities\KategoriPulsa;
use App\Models\MyModel;

class ProdukPulsaModel extends MyModel
{
    protected $table = "m_produk_pulsa";
    protected $primaryKey = "ppId";
    protected $createdField = "ppCreatedAt";
    protected $updatedField = "ppUpdatedAt";
    protected $returnType = "App\Entities\ProdukPulsa";
    protected $allowedFields = ["ppId", "ppKpId", "ppKode","ppNama","ppDeskripsi","ppUrutan","ppKodeSuplier","ppJenis","ppPoin","ppJamOperasional","ppHarga","ppDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships(){
        return [
            'kategori' => $this->belongsTo('m_kategori_pulsa', KategoriPulsa::class, 'kpId = ppKpId', 'kategori', 'kpId'),
        ];
    }
}