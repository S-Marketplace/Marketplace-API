<?php namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Libraries\Notification;
use App\Controllers\MyResourceController;
use App\Models\UserAlamatModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class User
 * @note Resource untuk mengelola data m_user
 * @dataDescription m_user
 * @package App\Controllers
 */
class User extends MyResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    protected $rulesCreate = [
        'email' => ['label' => 'email', 'rules' => 'required|cek_email_terdaftar'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'password' => ['label' => 'password', 'rules' => 'required'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'required|numeric'],
        'noWa' => ['label' => 'No Whatsapp', 'rules' => 'required|numeric'],
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kabupatenId' => ['label' => 'Id Kabupaten', 'rules' => 'required'],
        'kabupatenNama' => ['label' => 'Kabupaten', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
    ];

    public function getMyProfile()
    {
        $modelUser = new UserModel();

        $data = $modelUser->find($this->user['email']);
        return $this->response($data, 200, '');
    }

    public function register()
    {
        if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
            $entityClass = $this->model->getReturnType();
            $entity = new $entityClass();
            $entity->fill($this->request->getVar());

            try {
                $status = $this->model->insert($entity, false);

                $insertId = $this->model->getInsertID();
                if ($insertId > 0) {
                    $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                }

                if($status){
                    $modelUserAlamat = new UserAlamatModel();
                    $modelUserAlamat->insert([
                        'usralUsrEmail' => $entity->email,
                        'usralNama' => 'Rumah',
                        'usralLatitude' => $this->request->getVar('latitude'),
                        'usralLongitude' => $this->request->getVar('longitude'),
                        'usralKotaId' => $this->request->getVar('kotaId'),
                        'usralKotaNama' => $this->request->getVar('kotaNama'),
                        'usralProvinsiId' => $this->request->getVar('provinsiId'),
                        'usralProvinsiNama' => $this->request->getVar('provinsiNama'),
                        'usralKabupatenId' => $this->request->getVar('kabupatenId'),
                        'usralKabupatenNama' => $this->request->getVar('kabupatenNama'),
                        'usralKecamatanId' => $this->request->getVar('kecamatanId'),
                        'usralKecamatanNama' => $this->request->getVar('kecamatanNama'),
                        'usralIsActive' => 1,
                        'usralIsFirst' => 1,
                    ]);
                }

                // Notification::sendEmail($entity->email, 'Verifikasi', view('Template/verifikasi', [
                //     'nama' => $entity->nama,
                //     'key' => Uuid::uuid4(),
                // ]));
                return $this->response(($status ? 'Akun berhasil didaftarkan, silahkan cek email anda untuk mengaktivasi akun anda' : null), ($status ? 200 : 500));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function verifikasi()
    {
        $key = $this->request->getGet('key');

        echo '<pre>';
        print_r($key);
        echo '</pre>';
       
    }
}
