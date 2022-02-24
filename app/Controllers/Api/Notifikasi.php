<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class Notifikasi
 * @note Resource untuk mengelola data m_notifikasi
 * @dataDescription m_notifikasi
 * @package App\Controllers
 */
class Notifikasi extends MyResourceController
{
    protected $modelName = 'App\Models\NotifikasiModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'judul' => ['label' => 'judul', 'rules' => 'required'],
       'pesan' => ['label' => 'pesan', 'rules' => 'required'],
       'tanggal' => ['label' => 'tanggal', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'judul' => ['label' => 'judul', 'rules' => 'required'],
       'pesan' => ['label' => 'pesan', 'rules' => 'required'],
       'tanggal' => ['label' => 'tanggal', 'rules' => 'required'],
   ];

    public function getNotif()
    {
        $userEmail = $this->user['email'];

        $data = $this->model->query("SELECT * FROM `m_notifikasi` ntf
        LEFT JOIN `t_notifikasi_to` ntft ON (ntf.`noifId` = ntft.`tnotifNotifId`)
        WHERE ntft.`tnotifEmail` = ''
        
        UNION 
        
        SELECT * FROM `m_notifikasi` ntf
        LEFT JOIN `t_notifikasi_to` ntft ON (ntf.`noifId` = ntft.`tnotifNotifId`) WHERE ntft.`tnotifEmail` = ".$this->model->escape($userEmail))->getResult();

        return $this->response($data, 200);
    }
}
