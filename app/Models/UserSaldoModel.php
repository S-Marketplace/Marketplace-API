<?php namespace App\Models;

use App\Models\MyModel;

class UserSaldoModel extends MyModel
{
    protected $table = "t_user_saldo";
    protected $primaryKey = "usalId";
    protected $createdField = "";
    protected $updatedField = "";
    protected $returnType = "App\Entities\UserSaldo";
    protected $allowedFields = ["usalId", "usalPaymentType","usalStatus","usalTime","usalSignatureKey","usalOrderId","usalMerchantId","usalGrossAmount","usalCurrency","usalVaNumber","usalBank","usalBillerCode","usalBillKey","usalUserEmail"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}