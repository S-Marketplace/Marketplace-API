<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use App\Libraries\MidTransPayment;
use App\Libraries\MyIpaymu;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Test extends BaseController
{
   
    public function email(){
        Notification::sendEmail('ahmadjuhdi007@gmail.com', 'subject', 'TEST');
    }

    public function cekIpaymu(){
        $myIpaymu = new MyIpaymu();
        $data = [
            'balance' => $myIpaymu->checkBalance(),
            'transaction' => $myIpaymu->checkTransaction('52406'),
            'directPayment' => $myIpaymu->directPayment([
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

    public function cekMidTrans(){
        $midTrans = new MidTransPayment();
        $data = [
            'transactionStatus' => $midTrans->transactionStatus('order-101q-1643016504'),
            // 'chargeBankBNIVA' => $midTrans->chargeBankBNIVA(),
            'chargeGopay' => $midTrans->chargeGopay(),
          
        ];
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
