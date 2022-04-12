<?php namespace App\Models;

use App\Entities\CheckoutDetail;
use App\Models\MyModel;

class CheckoutModel extends MyModel
{
    protected $table = "t_checkout";
    protected $primaryKey = "cktId";
    protected $createdField = "cktCreatedAt";
    protected $updatedField = "cktUpdatedAt";
    protected $returnType = "App\Entities\Checkout";
    protected $allowedFields = ["cktStatus","cktKurir","cktNoResiKurir","cktCatatan","cktAlamatId", "ckurTipePengiriman", "cktDeletedAt"];

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
            'pembayaran' => ['table' => 't_pembayaran', 'condition' => 'cktId = pmbCheckoutId', 'entity' => 'App\Entities\Pembayaran'],
            'kurir' => ['table' => 't_checkout_kurir', 'condition' => 'cktId = ckurCheckoutId', 'entity' => 'App\Entities\CheckoutKurir'],
            'alamat' => ['table' => 'm_user_alamat', 'condition' => 'cktAlamatId = usralId', 'entity' => 'App\Entities\UserAlamat'],
            'detail' => $this->hasMany('t_checkout_detail', CheckoutDetail::class, 'cktId = cktdtCheckoutId', 'detail', 'cktdtCheckoutId','LEFT'),
        ];
    }
}