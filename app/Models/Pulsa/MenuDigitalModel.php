<?php namespace App\Models\Pulsa;

use App\Entities\ProdukPulsa;
use App\Models\MyModel;

class MenuDigitalModel extends MyModel
{
    protected $table = "m_menu_digital";
    protected $primaryKey = "mdId";
    protected $createdField = "mdCreatedAt";
    protected $updatedField = "mdUpdatedAt";
    protected $returnType = "App\Entities\MenuDigital";
    protected $allowedFields = ["mdKelompok","mdNama","mdIcon","mdUrutan","mdJenisMenu","mdShowHome","mdEnabled","mdKodeProdukPPOB","mdDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships(){
        // return [
        //     'produk' => $this->hasMany('m_produk_pulsa', ProdukPulsa::class, 'ppKpId = kpId', 'produk', 'ppKpId'),
        // ];
    }

    public function selectMenu(){
        $this->select("mdId, mdNama");
        $this->where("mdDeletedAt", null);
        $this->orderBy("mdNama", "ASC");
        $data = $this->findAll();

        $select= [];
        foreach ($data as $key => $value) {
            $select[$value->mdId] = $value->mdNama;
        }

        return $select;
    }

    public function selectJenisMenu(){
       
        $select= [];
        foreach (['Kategori', 'Kategori Filter Nomor', 'PPOB Single Produk'] as $key => $value) {
            $select[$value] = $value;
        }

        return $select;
    }
}