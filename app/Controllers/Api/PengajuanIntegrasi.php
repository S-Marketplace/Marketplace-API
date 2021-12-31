<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\PengajuanIntegrasiModel;

class PengajuanIntegrasi extends BaseResourceController
{
	protected $modelName = 'App\Models\PengajuanIntegrasiModel';
    protected $format    = 'json';

	protected $rulesCreate = [
        'nik' => ['label' => 'NIK', 'rules' => 'required'],
        'napiId' => ['label' => 'Narapidana', 'rules' => 'required'],
        'hubungan' => ['label' => 'Hubungan dengan Narapidana', 'rules' => 'required'],
    ];

    function __construct(){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        helper('datetime');
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
                $pengajuanIntegrasi = new PengajuanIntegrasiModel();

                if (count($pengajuanIntegrasi->isBisaMengajukan($this->request->getPost('nik'))) > 0) {
                    return $this->response(null, 500, 'Terdapat Pengajuan yang belum selesai diproses');
                }
               
                $entityClass = $this->model->getReturnType();
                $entity = new $entityClass();
                $entity->fill($this->request->getPost());
                $entity->tanggal = date('Y-m-d H:i:s');
                $entity->status = 1;

                $status = $this->model->insert($entity, false);
                if ($this->model->getInsertID() > 0) {
                    $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                }

                return $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
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
