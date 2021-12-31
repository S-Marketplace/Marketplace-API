<?php

namespace App\Controllers;

use App\Models\PengunjungModel;
use CodeIgniter\Config\Services;
use App\Models\AntrianOnlineModel;
use App\Controllers\BaseController;
use App\Models\AntrianSekarangModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AntrianPenitipan extends BaseController
{
    protected $activeUrl = 'AntrianPenitipan';
    protected $model = '';

    protected $rules = [
        'nik' => ['label' => 'NIK', 'rules' => 'required'],
        'jenis' => ['label' => 'Jenis', 'rules' => 'required|in_list[Kunjungan,Penitipan]'],
        'napiId' => ['label' => 'Napi Id', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'permit_empty'],
        'deviceId' => ['label' => 'Device Id', 'rules' => 'required'],
    ];

    // protected $rulesCreate = [
    //     'no' => ['label' => 'No', 'rules' => 'required'],
    //     'nik' => ['label' => 'NIK', 'rules' => 'required|min_length[16]|numeric'],
    //     'tanggal' => ['label' => 'Tanggal', 'rules' => 'required'],
    //     'jenis' => ['label' => 'Jenis', 'rules' => 'required|in_list[Kunjungan,Penitipan]'],
    // ];

    // protected $rulesCreatePengunjung = [
    //     'nik' => ['label' => 'NIK', 'rules' => 'required|min_length[16]|numeric'],
    //     'nama' => ['label' => 'nama', 'rules' => 'required'],
    // ];

    // protected $rulesUpdate = [
    //     'no' => ['label' => 'No', 'rules' => 'required'],
    //     'nik' => ['label' => 'NIK', 'rules' => 'required|min_length[16]|numeric'],
    //     'tanggal' => ['label' => 'Tanggal', 'rules' => 'required'],
    //     'jenis' => ['label' => 'Jenis', 'rules' => 'required|in_list[Kunjungan,Penitipan]'],
    // ];

    // protected $rulesUpdatePengunjung = [
    //     'nik' => ['label' => 'NIK', 'rules' => 'required|min_length[16]|numeric'],
    //     'nama' => ['label' => 'nama', 'rules' => 'required'],
    // ];

    public function __construct()
    {
        $this->model = new AntrianOnlineModel();
    }

    public function index()
    {
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("AntrianPenitipan/index");
    }

    /**
     * grid
     * 
     * Menampilkan data di Datatable
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['pengunjung', 'napi']);
        $this->model->where('antJenis', 'Penitipan');
        $this->model->where('antTanggal', date('Y-m-d'));

        return parent::grid();
    }

    public function simpan($primary = '')
    {

        try {
            $antrianSekarang = new AntrianSekarangModel();
            $entityAsClass = $antrianSekarang->getReturnType();
            $entityAs = new $entityAsClass();
            $entityAs->antrianId = $this->request->getVar('id');

            $status = $antrianSekarang->set($entityAs->toRawArray())
                ->update(1);

            if ($status) {
                return parent::simpan($primary);
            }
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
    }
}
