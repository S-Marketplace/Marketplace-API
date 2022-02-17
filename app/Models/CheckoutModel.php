<?php namespace App\Models;

use App\Models\MyModel;

class CheckoutModel extends MyModel
{
    protected $table = "t_checkout";
    protected $primaryKey = "cktId";
    protected $createdField = "cktCreatedAt";
    protected $updatedField = "cktUpdatedAt";
    protected $returnType = "App\Entities\Checkout";
    protected $allowedFields = ["cktStatus","cktKurir","cktNoResiKurir","cktCatatan","cktAlamatId","cktDeletedAt"];

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
        ];
    }
}