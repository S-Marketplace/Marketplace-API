<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Libraries\Notification;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\Uuid;

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
        'email' => ['label' => 'email', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'password' => ['label' => 'password', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'email' => ['label' => 'email', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'password' => ['label' => 'password', 'rules' => 'required'],
        'saldo' => ['label' => 'saldo', 'rules' => 'required'],
        'isActive' => ['label' => 'isActive', 'rules' => 'required'],
    ];

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

                // Notification::sendEmail($entity->email, 'Verifikasi', view('Template/verifikasi', [
                //     'nama' => $entity->nama,
                //     'key' => Uuid::uuid4(),
                // ]));
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

    public function verifikasi()
    {
        $key = $this->request->getGet('key');

        echo '<pre>';
        print_r($key);
        echo '</pre>';
       
    }
}
