<?php

namespace App\Models;

use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\ProdukGambar;
use App\Entities\ProdukVariant;

class KeranjangModel extends MyModel
{
    protected $table = "t_keranjang";
    protected $primaryKey = "krjId";
    protected $createdField = "krjCreatedAt";
    protected $updatedField = "krjUpdatedAt";
    protected $returnType = "App\Entities\Keranjang";
    protected $allowedFields = ["krjProdukId", "krjQuantity", "krjPesan", "krjCheckoutId", "krjDeletedAt", "krjUserEmail", "krjIsChecked"];

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
            JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukGambar::class) . ")) AS gambars
            FROM `t_produk_gambar` 
            GROUP BY prdgbrProdukId";

        $kategoriQuery = "SELECT *,
            (JSON_OBJECT(" . $this->entityToMysqlObject(Kategori::class) . ")) AS kategori
            FROM `m_kategori` 
            GROUP BY ktgId";

        $productsQuery = "SELECT *,
            (JSON_OBJECT(" . $this->entityToMysqlObject(Produk::class) . ", 
            'gambar', JSON_EXTRACT(gambar.gambars,'$'), 
            'kategori', JSON_EXTRACT(kategori.kategori,'$'),
            'variant', JSON_EXTRACT(variant.variant,'$')
            )) AS products
            FROM `m_produk` 
            LEFT JOIN (" . $gambarQuery . ") gambar ON gambar.prdgbrProdukId = produkId 
            LEFT JOIN (" . $kategoriQuery . ") kategori ON kategori.ktgId = produkKategoriId 
            LEFT JOIN (" . $variantQuery . ") variant ON variant.pvarProdukId = produkId 
            GROUP BY produkId";

        return [
            'products' => ['table' => "({$productsQuery})", 'condition' => 'krjProdukId = produkId', 'field_json' => 'products', 'type' => 'left'],
        ];
    }

    /**
     * Undocumented function
     *
     * @return double
     */
    public function getBeratKeranjangCheck($email)
    {
        $data = $this->query("SELECT SUM(prd.`produkBerat`) berat FROM `t_keranjang` krj
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        WHERE 
        krj.`krjCheckoutId` IS NULL AND 
        krj.`krjIsChecked` = '1' AND
        krj.`krjUserEmail` = " . $this->db->escape($email))->getRow();

        return $data->berat ?? 0;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getProdukKeranjang($email)
    {
        $data = $this->query("SELECT SUM(produkHarga - (produkHarga*produkDiskon/100)) * krjQuantity AS harga, COUNT(krjId) as jlhProdukCheckout FROM `t_keranjang` krj
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        WHERE 
        krj.`krjCheckoutId` IS NULL AND 
        krj.`krjIsChecked` = '1' AND
        krj.`krjUserEmail` = " . $this->db->escape($email))->getRow();

        return [
            'harga' => intval($data->harga) ?? 0,
            'jumlah' => intval($data->jlhProdukCheckout) ?? 0,
        ];
    }

    public function updateKeranjangToCheckout($checkoutId, $email)
    {
        $this->where('krjIsChecked', 1);
        $this->where('krjCheckoutId', null);
        $this->where('krjUserEmail', $email);

        $this->update(null, [
            'krjCheckoutId' => $checkoutId,
        ]);
    }

    public function updateProdukStok($checkoutId)
    {
        $data = $this->where('krjCheckoutId', $checkoutId)->find();

        $produkModel = new ProdukModel();
        foreach ($data as $keranjang) {
            $find = $produkModel->find($keranjang->produkId);
            $produkModel->update($keranjang->produkId, [
                'produkStok' => intval($find->stok) - intval($keranjang->quantity),
            ]);
        }
    }

    public function getKeranjangDetail($checkoutId = null, $userEmail = null)
    {
        $this->select('*');
        if (!empty($checkoutId)) {
            $this->where(['krjCheckoutId' => $checkoutId]);
        }
        if (!empty($userEmail)) {
            $this->where(['krjUserEmail' => $userEmail]);
        }
        $this->with(['products', 'checkout', 'alamat']);

        $data = $this->find();

        $data = array_map(function ($e) {
            $e = $e;
            $produkGambarModel = new ProdukGambarModel();
            $kategoriModel = new KategoriModel();
            $combine['kategori'] = $kategoriModel->find($e->products->kategoriId);
            $combine['gambar'] = $produkGambarModel->where(['prdgbrProdukId' => $e->products->id])->find();
            $e->products = array_merge((array)$e->products, $combine);
            return $e;
        }, $data);

        return $data;
    }
}
