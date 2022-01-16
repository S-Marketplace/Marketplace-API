<?php

namespace App\Controllers;

use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Login extends BaseController
{

    protected $rulesCreate    = [
        'username' => ['label' => 'Username', 'rules' => 'required'],
        'password' => ['label' => 'Password', 'rules' => 'required'],
        // 'nama' => ['label' => 'Nama', 'rules' => 'required'],
    ];

    const SECRET_KEY = '6LcsuMIaAAAAAJ0e2CrTQzpNJKgoG6H-QzI5Eneo';

    public function hash()
    {
        $model = new UserModel();
        $model->select('*');
        $model->with(["role"]);
        $user = $model->find('admin');

        echo "<pre>";
        print_r($user->hashPassword('admin'));
        echo "</pre>";
    }

    public function index()
    {
        if ($this->request->isAJAX()) {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $response = $this->_loginSession($username, $password);
            // $token_captcha = $this->request->getPost('token_captcha');
            // $server = $this->request->getServer(['SERVER_NAME']);
            // $ipAdress = $this->request->getIPAddress();

            // $recaptcha = new ReCaptcha(self::SECRET_KEY);
            // $resp = $recaptcha->setExpectedHostname($server['SERVER_NAME'])
            //     ->setExpectedAction('login')
            //     ->setScoreThreshold(0.9)
            //     ->verify($token_captcha, $ipAdress);
            // if ($resp->isSuccess()) {
            // } else {
            //     $response = $this->response(null, 400, 'Login gagal, harap refresh atau gunakan browser lain');
            // }

            return $this->response->setJSON($response);
        } else if ($this->session->has('role')) {
            return redirect()->to(base_url('Beranda'));
        } else {


            $img = base_url('assets/images/silaki/logo-lapas_ya.png');
            $imgData = base64_encode(file_get_contents($img));

            $data['logo'] = 'data:image/png;base64,' . $imgData;
            return view('Login/index', $data);
        }
    }

    public function indexTest()
    {
        if ($this->request->isAJAX()) {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $token_captcha = $this->request->getPost('token_captcha');

            $recaptcha = new ReCaptcha('6LcsuMIaAAAAAJ0e2CrTQzpNJKgoG6H-QzI5Eneo');
            $resp = $recaptcha->setExpectedHostname('http://localhost/Marketplace-API/public/')
                ->setExpectedAction('login')
                ->setScoreThreshold(0.9)
                ->verify($token_captcha);
            if ($resp->isSuccess()) {
                $response = $this->_loginSession($username, $password);
            } else {
                $response = $this->response(null, 400, 'Login gagal, harap refresh atau gunakan browser lain');
            }

            return $this->response->setJSON($response);
        } else if ($this->session->has('role')) {
            return redirect()->to(base_url('Beranda'));
        } else {

            $img = base_url('assets/images/silaki/logo-lapas_ya.png');
            $imgData = base64_encode(file_get_contents($img));

            $data['logo'] = 'data:image/png;base64,' . $imgData;
            return view('Login/index_test', $data);
        }
    }

    public function session()
    {
        echo "<pre>";
        print_r($this->session->get());
        echo "</pre>";
    }


    /**
     * Aksi untuk menambahkan session
     *
     * @param [type] $username
     * @param [type] $password
     *
     * @return void
     */
    private function _loginSession($username, $password)
    {
        $model = new UserModel();
        if ($this->validate($this->rulesCreate)) {
            try {
                $model->select('*');
                $model->with(["role"]);
                $user = $model->find($username);

                if (isset($user) && $user->verifyPassword($password)) {
                    $dataUser = [
                        'nama' => $user->nama,
                        'username' => $user->username,
                        'role' => $user->role->role,
                        'aplikasi' => $user->role->aplikasi,
                    ];

                    $this->session->set($dataUser);

                    $response['redirect'] = base_url('Beranda');
                    return $this->response($response, 200);
                } else {
                    return $this->response(null, 401, 'User tidak ditemukan');
                }
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, 'Username dan Password wajib diisi');
        }
    }

    /**
     * Logout aplikasi
     *
     * @return void
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}
