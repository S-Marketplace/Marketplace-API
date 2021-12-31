<?php

namespace App\Controllers;

use App\Models\SettingModel;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Setting extends BaseController
{
    protected $activeUrl = 'Setting';
    protected $model = '';

    protected $rules = [
        'key' => ['label' => 'Key', 'rules' => 'required'],
        'value' => ['label' => 'Value', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new SettingModel();
    }

    public function index()
    {
        $data = $this->model->find();

        $dataSetting = [];
        foreach ($data as $value) {
            $dataSetting[] = $value->toArray();
        }

        // $filterBy = 'antrian_kunjungan';
        // $antrian_kunjungan = current(array_filter($dataSetting, function ($var) use ($filterBy) {
        //     return ($var['key'] == $filterBy);
        // }));

        // $filterBy = 'antrian_penitipan';
        // $antrian_penitipan = current(array_filter($dataSetting, function ($var) use ($filterBy) {
        //     return ($var['key'] == $filterBy);
        // }));

        $antrian_kunjungan = [];
        $antrian_kunjungan = [];
        $foto_background = [];
        $foto_header = [];
        foreach ($dataSetting as $value) {
            $filter = $value['key'];
            ${$filter} = current(array_filter($dataSetting, function ($var) use ($filter) {
                return ($var['key'] == $filter);
            }));
        }

        $data = [
            'antrian_kunjungan' => $antrian_kunjungan['value'],
            'antrian_penitipan' => $antrian_penitipan['value'],
            'foto_background' => $foto_background['value'],
            'foto_header' => $foto_header['value'],
        ];

        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Setting/index", $data);
    }

    protected function uploadFile()
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "setting";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("foto_background");
        if ($file && $file->getError() == 0) {
            array_map('unlink', glob($path . DIRECTORY_SEPARATOR . "foto_background.*"));

            $filename = "foto_background." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['foto_background'] = $filename;
            $this->request->setGlobal("request", $post);
        }

        $file = $this->request->getFile("foto_header");
        if ($file && $file->getError() == 0) {
            array_map('unlink', glob($path . DIRECTORY_SEPARATOR . "foto_header.*"));

            $filename = "foto_header." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();

            $post['foto_header'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {

        helper('form');

        $rules = [
            'antrian_kunjungan' => ['label' => 'Image Background', 'rules' => 'required|in_list[0,1]'],
            'antrian_penitipan' => ['label' => 'Image Background', 'rules' => 'required|in_list[0,1]'],
            'foto_background' => ['label' => 'Image Background', 'rules' => 'required|uploaded[foto_background]|max_size[foto_background,5000]|ext_in[foto_background,jpg,jpeg,png]|mime_in[foto_background,image/jpeg,image/jpg,image/png]'],
            'foto_header' => ['label' => 'Image Header', 'rules' => 'required|uploaded[foto_header]|max_size[foto_header,5000]|ext_in[foto_header,jpg,jpeg,png]|mime_in[foto_header,image/jpeg,image/jpg,image/png]'],
        ];

        $cekValue = $this->model->checkValue('foto_background');
        if ($cekValue) {
            unset($rules['foto_background']);
        }

        $cekValue = $this->model->checkValue('foto_header');
        if ($cekValue) {
            unset($rules['foto_header']);
        }

        if ($this->validate($rules)) {
            try {
                $this->uploadFile();
            } catch (\Exception $ex) {
                $response =  $this->response(null, 500, $ex->getMessage());
                return $this->response->setJSON($response);
            }
            try {
                $post = $this->request->getvar();

                $this->model->transStart();
                foreach ($post as $key => $value) {
                    $this->model->set([
                        'setValue' => $value
                    ])->update($key);
                }
                $this->model->transComplete();
                $status = $this->model->transStatus();

                $response = $this->response(($status ? $post : null), ($status ? 200 : 500));
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
