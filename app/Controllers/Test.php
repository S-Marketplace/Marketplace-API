<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use App\Libraries\MidTransPayment;
use App\Libraries\MyIpaymuPayment;
use App\Libraries\Notification;
use App\Libraries\RajaOngkirShipping;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Test extends BaseController
{
   
    public function email(){
        Notification::sendEmail('ahmadjuhdi007@gmail.com', 'subject', 'TEST');
    }

    public function cekIpaymu(){
        $myIpaymuPayment = new MyIpaymuPayment();
        $data = [
            'balance' => $myIpaymuPayment->checkBalance(),
            'transaction' => $myIpaymuPayment->checkTransaction('52406'),
            'directPayment' => $myIpaymuPayment->directPayment([
                "name"=>"Buyer",
                "phone"=>"081999501092",
                "email"=>"buyer@mail.com",
                "amount"=>"10000",
                "notifyUrl"=>"https://mywebsite.com",
                "expired"=>"24",
                "expiredType"=>"hours",
                "comments"=>"Catatan",
                "referenceId"=>"1",
                "paymentMethod"=>"va",
                "paymentChannel"=>"bca",
                "product"=>["produk 1"],
                "qty"=>["1"],
                "price"=>["10000"],
                "weight"=>["1"],
                "width"=>["1"],
                "height"=>["1"],
                "length"=>["1"],
                "deliveryArea"=>"76111",
                "deliveryAddress"=>"Denpasar"
            ]),
        ];
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function testNotifFirebase(){
        $res = Notification::sendNotif();

		return $this->response->setJSON($res);
    }

    public function cekMidTrans(){
        $midTrans = new MidTransPayment();
        $data = [
            'transactionStatus' => $midTrans->transactionStatus('order-101q-1643016504'),
            // 'chargeBankBNIVA' => $midTrans->chargeBankBNIVA(),
            // 'chargeGopay' => $midTrans->chargeGopay(),
          
        ];
		return $this->response->setJSON($data);
    }

    public function cekRajaOngkir(){
        $rajaOngkir = new RajaOngkirShipping();
        $data = [
            'province' => $rajaOngkir->province(),
            'city' => $rajaOngkir->city(),
            'cost' => $rajaOngkir->cost(1,1,1,'jne'),
            'subdistrict' => $rajaOngkir->subdistrict(1),
            'currency' => $rajaOngkir->currency(),
            'waybill' => $rajaOngkir->waybill('002837509520', 'sicepat'),
          
        ];

		return $this->response->setJSON($data);
    }
}
