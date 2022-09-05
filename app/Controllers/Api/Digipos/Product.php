<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class Product extends MyResourceDigipos
{
    public function getProduct($mssidn, $paymentMethod)
    {
        $response = $this->digiposApi->getProduct($mssidn, $paymentMethod);

        return $this->convertResponse($response);
    }

    public function getPaketData($mssidn, $paymentMethod)
    {
        $response = $this->digiposApi->getPaketData($mssidn, $paymentMethod);

        return $this->convertResponse($response);
    }

    public function recharge()
    {
        if ($this->validate([
            'denomRecharge' => 'required',
            'msisdn' => 'required',
            'outletId' => 'required',
            'paymentMethod' => 'required',
            'price' => 'required',
            'rechargeType' => 'required',
            'rsNumber' => 'required',
            'userId' => 'required',
        ], $this->validationMessage)) {

            $response = $this->digiposApi->recharge([
                'denomRecharge' => $this->request->getPost('denomRecharge'),
                'msisdn' => $this->request->getPost('msisdn'),
                'outletId' => $this->request->getPost('outletId'),
                'paymentMethod' => $this->request->getPost('paymentMethod'),
                'price' => $this->request->getPost('price'),
                'rechargeType' => $this->request->getPost('rechargeType'),
                'rsNumber' => $this->request->getPost('rsNumber'),
                'userId' => $this->request->getPost('userId'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function confirm()
    {
        if ($this->validate([
            'pin' => 'required',
            'token' => 'required',
        ], $this->validationMessage)) {

            $response = $this->digiposApi->confirm([
                'pin' => $this->request->getPost('pin'),
                'token' => $this->request->getPost('token'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function rechargePaketData()
    {
        if ($this->validate([
            'msisdn' => 'required',
            'originTrxType' => 'required',
            'outletId' => 'required',
            'packageId' => 'required',
            'paymentMethod' => 'required',
            'price' => 'required',
            'rsNumber' => 'required',
            'trxType' => 'required',
            'userId' => 'required',
        ], $this->validationMessage)) {
            
            $response = $this->digiposApi->rechargePaketData([
                'msisdn' => $this->request->getPost('msisdn'),
                'originTrxType' => $this->request->getPost('originTrxType'),
                'outletId' => $this->request->getPost('outletId'),
                'packageId' => $this->request->getPost('packageId'),
                'paymentMethod' => $this->request->getPost('paymentMethod'),
                'price' => $this->request->getPost('price'),
                'rsNumber' => $this->request->getPost('rsNumber'),
                'trxType' => $this->request->getPost('trxType'),
                'userId' => $this->request->getPost('userId'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function confirmPaketData()
    {
        if ($this->validate([
            'pin' => 'required',
            'token' => 'required',
        ], $this->validationMessage)) {

            $response = $this->digiposApi->confirmPaketData([
                'pin' => $this->request->getPost('pin'),
                'token' => $this->request->getPost('token'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
