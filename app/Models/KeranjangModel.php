<?php namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;

class KeranjangModel extends MyModel
{
    protected $table = "t_keranjang";
    protected $primaryKey = "krjId";
    protected $createdField = "krjCreatedAt";
    protected $updatedField = "krjUpdatedAt";
    protected $returnType = "App\Entities\Keranjang";
    protected $allowedFields = ["krjProdukId","krjQuantity","krjPesan","krjCheckoutId","krjDeletedAt","krjUserEmail", "krjIsChecked"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    protected function relationships()
    {
        return [
            'products' => ['table' => 'm_produk', 'condition' => 'krjProdukId = produkId', 'entity' => 'App\Entities\Produk'],
        ];
    }

    /**
     * Undocumented function
     *
     * @return double
     */
    public function getBeratKeranjangCheck($email){
        $data = $this->query("SELECT SUM(prd.`produkBerat`) berat FROM `t_keranjang` krj
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        WHERE 
        krj.`krjCheckoutId` IS NULL AND 
        krj.`krjIsChecked` = '1' AND
        krj.`krjUserEmail` = ".$this->db->escape($email))->getRow();

        return $data->berat ?? 0;
    }

    /**
     * Undocumented function
     *
     * @return double
     */
    public function getHargaProdukKeranjang($email){
        $data = $this->query("SELECT SUM(produkHarga - (produkHarga*produkDiskon/100)) * krjQuantity AS harga FROM `t_keranjang` krj
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        WHERE 
        krj.`krjCheckoutId` IS NULL AND 
        krj.`krjIsChecked` = '1' AND
        krj.`krjUserEmail` = ".$this->db->escape($email))->getRow();

        return intval($data->harga) ?? 0;
    }
}