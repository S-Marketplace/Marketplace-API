<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\PengunjungModel;
use App\Models\JadwalUmumModel;
use App\Models\JadwalKhususModel;

class Antrian extends BaseResourceController
{
	protected $modelName = 'App\Models\AntrianOnlineModel';
    protected $format    = 'json';

    protected const MAX_ANTRIAN_DAY         = 100;
    protected const MAX_ANTRIAN_USER_DAY    = 3;

	protected $rulesCreate = [
        'nik' => ['label' => 'NIK', 'rules' => 'required'],
        'jenis' => ['label' => 'Jenis', 'rules' => 'required|in_list[Kunjungan,Penitipan]'],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'napiId' => ['label' => 'Napi Id', 'rules' => 'required'],
        'keterangan' => ['label' => 'Keterangan', 'rules' => 'permit_empty'],
        'deviceId' => ['label' => 'Device Id', 'rules' => 'required'],
    ];

    function __construct(){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        helper('datetime');
    }

    public function index()
    {
        $post = $this->request->getGet();
        $post['tanggal']['gte'] = date('Y-m-d');
        // unset($post['deviceId']);
        $this->request->setGlobal("get", $post);

        $this->applyQueryFilter();
        $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        if ($limit != "-1") {
            $this->model->limit($limit);
        }
        $this->model->offset($offset);
        try {
            $jadwalKhusus = new JadwalKhususModel();
            $jadwalUmum = new JadwalUmumModel();

            $date = date('Y-m-d');
            $now = date_convert($date);

            return $this->response([
                'rows' => array_map(function($e) use ($jadwalKhusus, $jadwalUmum, $now){

                    $jadwalKhususTanggal = $jadwalKhusus->where(['DATE(jdkTanggal)' => date('Y-m-d')])->get()->getRow();
                    if (!empty($jadwalKhususTanggal)) {
                        $e->createdAt = "{$jadwalKhususTanggal->jdkJamMulai} s.d {$jadwalKhususTanggal->jdkJamSelesai}";
                        return $e;
                    }
                    
                    $jadwalUmumTanggal = $jadwalUmum->where(['jduNamaHari' => $now->dayName])->get()->getRow();
                    if (!empty($jadwalUmumTanggal)){
                        $e->createdAt = "{$jadwalUmumTanggal->jduJamMulai} s.d {$jadwalUmumTanggal->jduJamSelesai}";
                        return $e;
                    }

                    $e->createdAt = "\"Jadwal Kunjunggan Tidak Tersedia\"";
                    return $e;
                    
                }, $this->model->find()),
                'limit' => $limit,
                'offset' => $offset,
            ]);
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }

    /**
     * @description Menambahkan data @dataDescription baru
     * @return array|mixed
     */
    public function create()
    {
        if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
            try {
                $dateNow = date('Y-m-d');
                $entityClass = $this->model->getReturnType();
                $entity = new $entityClass();
                $entity->fill($this->request->getPost());
                $entity->tanggal = date('Y-m-d H:i:s');
                $entity->no = 1;

                // GET LIMIT ANTRIAN TODAY
                $limitToday = $this->model->where(['antJenis' => $entity->jenis, 'DATE(antTanggal)' => $dateNow])->get()->getNumRows();
                if ($limitToday >= self::MAX_ANTRIAN_DAY) {
                    return $this->response(null, 500, "Antrian {$entity->jenis} hari ini sudah penuh, maksimal antrian per hari adalah ".self::MAX_ANTRIAN_DAY );
                }

                // GET LIMIT ANTRIAN TODAY PER USER
                $limitTodayUser = $this->model->where(['antJenis' => $entity->jenis, 'DATE(antTanggal)' => $dateNow, 'antDeviceId' => $entity->deviceId])->get()->getNumRows();
                if ($limitTodayUser >= self::MAX_ANTRIAN_USER_DAY) {
                    return $this->response(null, 500, "Antrian {$entity->jenis} anda pada hari ini sudah penuh, maksimal antrian anda per hari adalah ".self::MAX_ANTRIAN_USER_DAY );
                }

                $entity->no = intval($limitToday) + 1;

                // INSERT PENGUNJUNG
                $pengunjung = new PengunjungModel();
                $pengunjungEntityClass = $pengunjung->getReturnType();
                $pengunjungEntity = new $pengunjungEntityClass();
                $pengunjungEntity->fill($this->request->getPost());
               
                $this->model->transStart();
                    // Insert Antrian
                $this->model->insert($entity, false);
                if ($this->model->getInsertID() > 0) {
                    $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                }

                $pengungData = $pengunjung->find($entity->nik);
             
                if (!empty($pengungData)) {
                    $pengunjung->set([
                        'pjgNik' => $entity->nik,
                        'pjgNama' => $this->request->getPost('nama'),
                        'pjgNamaWbp' => $this->request->getPost('namaWbp'),
                        'pjgNamaAyah' => $this->request->getPost('namaAyah')
                    ])->update($entity->nik);
                }else{
                    // Insert Pengunjung
                    $pengunjung->insert($pengunjungEntity, false);
                    if ($pengunjung->getInsertID() > 0) {
                        $pengunjungEntity->{$pengunjung->getPrimaryKeyName()} = $pengunjung->getInsertID();
                    }
                }

                $this->model->transComplete();
                $status = $this->model->transStatus();

                if ($status) {
                    $entity->pengunjung = $pengunjungEntity->toArray();
                }
                return $this->response($this->request->getPost(), 200, 'Antrian Berhasil Dilakukan');
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
}
