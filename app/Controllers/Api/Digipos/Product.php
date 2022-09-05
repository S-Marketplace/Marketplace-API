<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class Product extends MyResourceDigipos
{
    public function getProduct($mssidn, $paymentMethod)
    {
        $response = $this->digiposApi->getProduct($mssidn, $paymentMethod);

        return $this->response($response);
    }
}
