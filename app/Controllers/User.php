<?php namespace App\Controllers;

use App\Models\KeranjangModel;
use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
use App\Entities\UserWeb as EntitiesUserWeb;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class User extends BaseController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';


    public function index()
    {
        return $this->template->setActiveUrl('User')
            ->view("User/index");
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->where('usralIsFirst', 1)->with(['alamat']);

        return parent::grid();
    }

    public function keranjangDetail($email){
        $keranjangModel = new KeranjangModel();
        
        $response =  $this->response($keranjangModel->getKeranjangDetail(null, $email), 200);
        return $this->response->setJSON($response);
    }
}
