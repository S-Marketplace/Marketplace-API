<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class UserAlamat
 * @note Resource untuk mengelola data m_user_alamat
 * @dataDescription m_user_alamat
 * @package App\Controllers
 */
class UserAlamat extends MyResourceController
{
    protected $modelName = 'App\Models\UserAlamatModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'usrEmail' => ['label' => 'usrEmail', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'latitude' => ['label' => 'latitude', 'rules' => 'required'],
       'longitude' => ['label' => 'longitude', 'rules' => 'required'],
       'kotaId' => ['label' => 'kotaId', 'rules' => 'required'],
       'kotaNama' => ['label' => 'kotaNama', 'rules' => 'required'],
       'provinsiId' => ['label' => 'provinsiId', 'rules' => 'required'],
       'provinsiNama' => ['label' => 'provinsiNama', 'rules' => 'required'],
       'kabupatenId' => ['label' => 'kabupatenId', 'rules' => 'required'],
       'kabupatenNama' => ['label' => 'kabupatenNama', 'rules' => 'required'],
       'kecamatanId' => ['label' => 'kecamatanId', 'rules' => 'required'],
       'kecamatanNama' => ['label' => 'kecamatanNama', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'usrEmail' => ['label' => 'usrEmail', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'latitude' => ['label' => 'latitude', 'rules' => 'required'],
       'longitude' => ['label' => 'longitude', 'rules' => 'required'],
       'kotaId' => ['label' => 'kotaId', 'rules' => 'required'],
       'kotaNama' => ['label' => 'kotaNama', 'rules' => 'required'],
       'provinsiId' => ['label' => 'provinsiId', 'rules' => 'required'],
       'provinsiNama' => ['label' => 'provinsiNama', 'rules' => 'required'],
       'kabupatenId' => ['label' => 'kabupatenId', 'rules' => 'required'],
       'kabupatenNama' => ['label' => 'kabupatenNama', 'rules' => 'required'],
       'kecamatanId' => ['label' => 'kecamatanId', 'rules' => 'required'],
       'kecamatanNama' => ['label' => 'kecamatanNama', 'rules' => 'required'],
   ];

   public function index(){

        $this->model->where('usralUsrEmail', $this->user['email']);
        return parent::index();
   }
}
