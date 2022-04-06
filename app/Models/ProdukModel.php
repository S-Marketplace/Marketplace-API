<?php

namespace App\Models;

use App\Entities\ProdukVariant;
use App\Entities\ProdukGambar;
use App\Models\MyModel;

class ProdukModel extends MyModel
{
    protected $table = "m_produk";
    protected $primaryKey = "produkId";
    protected $createdField = "produkCreatedAt";
    protected $updatedField = "produkUpdatedAt";
    protected $returnType = "App\Entities\Produk";
    protected $allowedFields = ["produkId", "produkNama", "produkDeskripsi", "produkHarga", "produkStok", "produkHargaPer", "produkBerat", "produkDilihat", "produkKategoriId", "produkDiskon", "produkDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    protected function relationships()
    {
        $variantQuery = "SELECT *,
                JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukVariant::class) . ")) AS variant
                FROM `t_produk_variant` 
                GROUP BY pvarProdukId";

        $gambarQuery = "SELECT *,
                JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukGambar::class) . ")) AS gambar
                FROM `t_produk_gambar` 
                GROUP BY prdgbrProdukId";

        return [
            'kategori' => ['table' => 'm_kategori', 'condition' => 'produkKategoriId = ktgId', 'entity' => 'App\Entities\Kategori'],
            'variant' => ['table' => "({$variantQuery})", 'condition' => 'pvarProdukId = produkId', 'field_json' => 'variant', 'type' => 'left'],
            'gambar' => ['table' => "({$gambarQuery})", 'condition' => 'prdgbrProdukId = produkId', 'field_json' => 'gambar', 'type' => 'left'],
        ];
    }

    // public function withGambarProduk()
    // {
    //     // return $this->hasMany("t_produk_gambar", "produkId = prdgbrProdukId", ProdukGambar::class, "gambar", 'prdgbrId');
    // }

    // public function withVariantProduk()
    // {
    //     // return $this->hasMany("t_produk_variant", "produkId = pvarProdukId", ProdukVariant::class, "variant", 'pvarId');
    // }
}
