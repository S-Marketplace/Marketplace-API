<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
use App\Models\SettingModel;

/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class LokasiCod extends BaseController
{
    protected $modelName = 'App\Models\LokasiCodModel';
    protected $format    = 'json';

    protected $rules = [
       'nama' => ['label' => 'Nama', 'rules' => 'required'],
       'latitude' => ['label' => 'Latitude', 'rules' => 'required'],
       'longitude' => ['label' => 'Longitude', 'rules' => 'required'],
   ];

   public function index()
   {
       $pengaturanModel = new SettingModel();
       $radius = $pengaturanModel->getValue(SettingModel::RADIUS_KEY);

       return $this->template->setActiveUrl('LokasiCod')
           ->view("LokasiCod/index", [
               'radius' => $radius
           ]);
   }

   public function saveRadius(){
       if($this->request->isAJAX()){
            $pengaturanModel = new SettingModel();
            $pengaturanModel->saveKeyValue(SettingModel::RADIUS_KEY, $this->request->getPost('radius'));

            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Berhasil menyimpan radius'
            ]);
       }
   }

}
