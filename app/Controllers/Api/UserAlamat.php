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
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota / Kabupaten', 'rules' => 'required'],
        'kotaTipe' => ['label' => 'Tipe Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
        'keterangan' => ['label' => 'Catatan ke kurir', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
        'usrEmail' => ['label' => 'usrEmail', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota / Kabupaten', 'rules' => 'required'],
        'kotaTipe' => ['label' => 'Tipe Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
        'keterangan' => ['label' => 'Catatan ke kurir', 'rules' => 'required'],
    ];

    public function index()
    {
        $this->model->where('usralUsrEmail', $this->user['email']);
        return parent::index();
    }

    public function update($id = null)
    {
        $post = $this->request->getVar();
        $post['usrEmail'] = $this->user['email'];
        $this->request->setGlobal("request", $post);

        return parent::update($id);
    }

    public function create()
    {
        $post = $this->request->getVar();
        $post['usrEmail'] = $this->user['email'];
        $this->request->setGlobal("request", $post);

        return parent::create();
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
