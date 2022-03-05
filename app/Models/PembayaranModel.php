<?php namespace App\Models;

use App\Models\MyModel;

class PembayaranModel extends MyModel
{
    protected $table = "t_pembayaran";
    protected $primaryKey = "pmbId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\Pembayaran";
    protected $allowedFields = ["pmbId","pmbCheckoutId","pmbPaymentCode", "pmbPaymentType", "pmbStore", "pmbStatus","pmbTime","pmbSignatureKey","pmbOrderId","pmbMerchantId","pmbGrossAmount","pmbCurrency","pmbVaNumber","pmbBank","pmbBillerCode","pmbBillKey","pmbUserEmail","pmbExpiredDate"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}