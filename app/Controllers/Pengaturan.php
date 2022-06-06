<?php

namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class Pengaturan extends BaseController
{
    protected $modelName = 'App\Models\SettingModel';
    protected $format    = 'json';

    protected $rules = [
        'h2h_endpoint' => ['label' => 'End Point', 'rules' => 'required'],
        'h2h_id' => ['label' => 'ID', 'rules' => 'required'],
        'h2h_idtrx' => ['label' => 'ID Trx', 'rules' => 'required'],
        'h2h_counter' => ['label' => 'Counter', 'rules' => 'required'],
        'h2h_user' => ['label' => 'User', 'rules' => 'required'],
        'h2h_pass' => ['label' => 'Password', 'rules' => 'required'],
    ];

    public function index()
    {
        return $this->template->setActiveUrl('Pengaturan')
            ->view("Pengaturan/index", [
                'settings' => $this->model->getAllSettingKey(),
            ]);
    }

    public function simpan($id = null)
    {
        if ($this->validate($this->rules)) {
            try {
                $data = $this->request->getVar();
                $normalData = [];
                foreach ($data as $key => $value) {
                    $normalData[] = [
                        'setKey' => $key,
                        'setValue' => $value,
                    ];
                }

                // Replace data
                $this->model->updateBatch($normalData, 'setKey');

                $response =  $this->response(null, 200, 'Pengaturan berhasil disimpan');
                return $this->response->setJSON($response);
            } catch (DatabaseException $ex) {
                $response =  $this->response(null, 500, $ex->getMessage());
                return $this->response->setJSON($response);
            } catch (\mysqli_sql_exception $ex) {
                $response =  $this->response(null, 500, $ex->getMessage());
                return $this->response->setJSON($response);
            } catch (\Exception $ex) {
                $response =  $this->response(null, 500, $ex->getMessage());
                return $this->response->setJSON($response);
            }
        } else {
            $response =  $this->response(null, 400, $this->validator->getErrors());
            return $this->response->setJSON($response);
        }
    }
}
