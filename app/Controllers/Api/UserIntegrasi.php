<?php

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Config\Config;
use App\Entities\User;
use App\Models\UserModel;
use App\Models\UserIntegrasiModel;
use App\Models\PengajuanIntegrasiModel;
use App\Models\RoleModel;
use App\Controllers\Api\Auth;
use App\Libraries\Notification;
use Dompdf\Dompdf;
use Dompdf\Options;

class UserIntegrasi extends BaseResourceController
{
    protected $modelName = 'App\Models\UserIntegrasiModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'nik' => [
            'label' => 'NIK', 'rules' => 'required|is_unique[silaki_m_user_integrasi.uinNik]|numeric|min_length[10]|max_length[20]',
            "errors" => [
                'is_unique' => 'NIK sudah terdaftar.',
            ],
        ],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'required'],
        'email' => 
            ['label' => 'Email', 'rules' => 'required|valid_email|is_unique[silaki_m_user_integrasi.uinEmail]', 
            "errors" => [
                'is_unique' => 'Email sudah digunakan.',
            ],
        ],
        'tempatLahir' => ['label' => 'Tempat Lahir', 'rules' => 'required'],
        'tanggalLahir' => ['label' => 'Tanggal Lahir', 'rules' => 'required'],
        'fotoKtp' => ['label' => 'Foto KTP', 'rules' => 'required|uploaded[fotoKtp]|max_size[fotoKtp,3084]'],
        'fotoSelfie' => ['label' => 'Foto Selfie', 'rules' => 'required|uploaded[fotoSelfie]|max_size[fotoSelfie,3084]'],
        'alamat' => ['label' => 'Alamat', 'rules' => 'required'],
        'pekerjaan' => ['label' => 'Pekerjaan', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'required'],
        'email' => 
            ['label' => 'Email', 'rules' => 'required|valid_email', 
            "errors" => [
                'is_unique' => 'Email sudah digunakan.',
            ],
        ],
        'tempatLahir' => ['label' => 'Tempat Lahir', 'rules' => 'required'],
        'tanggalLahir' => ['label' => 'Tanggal Lahir', 'rules' => 'required'],
        'fotoKtp' => ['label' => 'Foto KTP', 'rules' => 'permit_empty|uploaded[fotoKtp]|max_size[fotoKtp,3084]'],
        'fotoSelfie' => ['label' => 'Foto Selfie', 'rules' => 'permit_empty|uploaded[fotoSelfie]|max_size[fotoSelfie,3084]'],
        'alamat' => ['label' => 'Alamat', 'rules' => 'required'],
        'pekerjaan' => ['label' => 'Pekerjaan', 'rules' => 'required'],
    ];

    function __construct()
    {
        $this->pathPhoto = Config::get("App")->uploadPath . 'foto_user_integrasi';

        date_default_timezone_set('Asia/Kuala_Lumpur');
        helper('datetime');
    }

    public function penjaminIntegrasi(){
    
        $nik = $this->request->getGet("nik");
        $id = $this->request->getGet("id");
        $pengajuanIntegrasi = new PengajuanIntegrasiModel();
        $data = [
            'isPdf' => true,
            'data' => $pengajuanIntegrasi->getDataPrint($id, $nik),
            'pj' => $pengajuanIntegrasi->getDataPJ()
        ];

        $html = view('Template/penjamin_integrasi', $data);

        if (!$data['isPdf']) {
            return $html;
        } else {
            $options = new Options();
            $dompdf = new Dompdf($options);
            $options->set('isRemoteEnabled', TRUE);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $dompdf->render();

            $dompdf->stream('Penjamin Integrasi.pdf', array("Attachment"=>false));
            exit;
        }
    }

    public function suratPernyataanIntegrasi(){
        $nik = $this->request->getGet("nik");
        $id = $this->request->getGet("id");
        $pengajuanIntegrasi = new PengajuanIntegrasiModel();
        $data = [
            'isPdf' => true,
            'data' => $pengajuanIntegrasi->getDataPrint($id, $nik),
            'pj' => $pengajuanIntegrasi->getDataPJ()
        ];

        $html = view('Template/surat_pernyataan_integrasi', $data);

        if (!$data['isPdf']) {
            return $html;
        } else {
            $options = new Options();
            $dompdf = new Dompdf($options);
            $options->set('isRemoteEnabled', TRUE);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $dompdf->render();

            $dompdf->stream('Surat Pernyataan Integrasi.pdf', array("Attachment"=>false));
            exit;
        }
    }

    protected function afterValidation()
    {
        if ($file = $this->request->getFile("fotoKtp")) {
            $filename = $file->getRandomName();

            $path = $this->pathPhoto;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            // $file->move($path, $filename);
            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['fotoKtp'] = $filename;
            $this->request->setGlobal("request", $post);
        }

        if ($file = $this->request->getFile("fotoSelfie")) {
            $filename = $file->getRandomName();

            $path = $this->pathPhoto;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['fotoSelfie'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function resetPassword(){
        $post = $this->request->getPost();
        $email = $post['email'] ?? '';

        if (empty($email)) {
            return $this->response(null, 400, [
                'email' => 'Email Wajib di isi.'
            ]);
        }

        try {
            $userEntities = new User();
            $userModelIntegrasi = new UserIntegrasiModel();
            $data = $userModelIntegrasi->asArray()->where('uinEmail', $email)->find();
            $data = current($data);

            if (empty($data)) {
                return $this->response(null, 400, [
                    'email' => 'Email Tidak Ditemukan'
                ]);
            }else{
                helper('string');
                $id = $data['uinNik'];
                $password = generate_string();
                $message = 'Password Anda yang baru adalah : '.$password;

                $userModel = new UserModel();
                $userModel->set(['usrUsername' => $id, 'usrPassword' => $userEntities->hashPassword($password)])->update($id);
                Notification::sendEmail($email, 'Reset Password', $message, false);
                return $this->response(null, 200, $message);
            }
           
        } catch (\Throwable $th) {
            return $this->response(null, 500, $th->getMessage());
        }
    }

    /**
     * Menambahkan presensi ke dalam database
     *
     * @return void
     */
    public function create()
    {
        $post = $this->request->getPost();

        // Bypass form validator
        if ($this->request->getFile("fotoSelfie")) {
            $post['fotoSelfie'] = '-';
        }

        // Bypass form validator
        if ($this->request->getFile("fotoKtp")) {
            $post['fotoKtp'] = '-';
        }

        // Set data bypass post data
        $this->request->setGlobal("request", $post);

        if ($this->validate($this->rulesCreate)) {
            try {
                $this->afterValidation();

                $entityClass = $this->model->getReturnType();
                $entity = new $entityClass();
                $entity->fill($this->request->getVar());
                try {
                    $status = $this->model->insert($entity, false);
                    if ($this->model->getInsertID() > 0) {
                        $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                    }

                    $username = $post['nik'];
                    $password = $post['nik'];

                    $userEntities = new User();
                    $userModel = new UserModel();
                    $userModel->set(['usrUsername' => $username, 'usrPassword' => $userEntities->hashPassword($username), 'usrNama' => $post['nama']])->insert();

                    $roleModel = new RoleModel();
                    $roleModel->set(['rolUsername' => $username, 'rolAplikasi' => 'silaki_mobile', 'rolRole' => 'user_integrasi'])->insert();

                    $auth = new Auth();
                    $auth = $auth->auth($username, $password, config("App")->apiKeys);
                    return $this->response(array_merge($auth['data'], $post), $auth['code'], $auth['message']);

                } catch (DatabaseException $ex) {
                    return $this->response(null, 500, $ex->getMessage());
                } catch (\Exception $ex) {
                    return $this->response(null, 500, $ex->getMessage());
                }
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
