<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

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

    public function index()
    {
        $this->model->where('usralUsrEmail', $this->user['email']);
        return parent::index();
    }

    public function setActive($alamatId)
    {
        $this->model->where('usralUsrEmail', $this->user['email']);
        $find = $this->model->find($alamatId);

        if (!empty($find)) {
            $this->model->where('usralUsrEmail', $this->user['email']);
            $this->model->update(null, ['usralIsActive' => 0]);
   
            $this->model->where('usralUsrEmail', $this->user['email']);
            $this->model->update($alamatId, ['usralIsActive' => 1]);
            return $this->response(null, 200, 'Berhasil mengubah jadi aktif');
        } else {
            return $this->response(null, 500, 'Alamat id tidak ditemukan');
        }
    }
}
