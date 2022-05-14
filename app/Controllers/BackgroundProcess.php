<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Libraries\Notification;
use App\Models\PembayaranModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BackgroundProcess extends BaseController
{
    public function __construct()
    {
        helper('filesystem');
    }

    /**
     * Mengupdate pembayaran yang sudah expired
     * 
     * Cron JOB : php public/index.php background pembayaran_to_expired
     * @return void
     */
    public function pembayaranToExpired()
    {
        $modelPembayaran = new PembayaranModel();
        $modelPembayaran->whereIn('pmbPaymentType', ['cod', 'manual_transfer']);
        $modelPembayaran->where('pmbStatus', 'pending');
        $modelPembayaran->where('pmbExpiredDate <', date('Y-m-d H:i:s'));
        $data = $modelPembayaran->find();

        foreach ($data as $value) {
            Notification::sendNotif($value->userEmail, 'Pembayaran Produk', "Status pembayaran anda expired, dengan ID {$value->orderId}");

            $modelPembayaran->update($value->id, ['pmbStatus' => 'expire']);
        }

        return $this->response->setJSON($data);
    }
}
