<?php namespace App\Models;

use App\Models\MyModel;

class CheckoutPulsaModel extends MyModel
{
    protected $table = "t_checkout_pulsa";
    protected $primaryKey = "cktpId";
    protected $createdField = "cktpCreatedAt";
    protected $updatedField = "cktpUpdatedAt";
    protected $returnType = "App\Entities\CheckoutPulsa";
    protected $allowedFields = ["cktpEmail","cktpPmbId","cktpIdProduk","cktpStatus","cktpTujuan"];

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
            'pembayaran' => ['table' => 't_pembayaran', 'condition' => 'cktpPmbId = pmbId', 'entity' => 'App\Entities\Pembayaran'],
        ];
    }
}