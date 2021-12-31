<?php

namespace App\Controllers;

use Config\Services;
use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Validation\Exceptions\ValidationException;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $rules = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session = \Config\Services::session();
		$this->validator = Services::validation();
		$this->template = Services::template([], true);

		date_default_timezone_set('Asia/Kuala_Lumpur');
	}

	/**
	 * @description Membentuk response dengan format ['data'=>[],'code'=>200,'message'=>'string text'] untuk Web API
	 * @requiredHeader X-ApiKey,X-Token
	 * @param null $data
	 * @param int $code
	 * @param null $message
	 * @return mixed
	 */
	protected function response($data = null, int $code = 200, $message = null)
	{
		return [
			'code' => $code,
			'message' => $message,
			'data' => $data
		];
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
		$request = $this->request->getGet();

		$this->_applyFillter($request);

		$response = $this->model->dataTableHandler($this->request->getGet());
		return $this->response->setJSON($response);
	}

	protected function uploadFile()
	{
	}

	public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
				try {
					$this->uploadFile();
				} catch (\Exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				}

				try {
					$entityClass = $this->model->getReturnType();
					$entity = new $entityClass();
					$entity->fill($this->request->getVar());

					$this->model->transStart();
					if ($this->request->getVar($primary) == '') {
						$this->model->insert($entity, false);
						if ($this->model->getInsertID() > 0) {
							$entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
						}
					} else {
						$this->model->set($entity->toRawArray())
							->update($this->request->getVar($primary));
					}

					$this->model->transComplete();
					$status = $this->model->transStatus();

					$response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
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

	public function hapus($id)
	{
		try {
			$this->model->transStart();
			$cek = $this->model->find($id);
			if ($cek) {
				$status = $this->model->delete($id);
			}

			$this->model->transComplete();
			$status = $this->model->transStatus();

			$response = $this->response(null, ($status ? 200 : 500));
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
	}

	/**
	 * Apply datatable filter lanjutan
	 *
	 * @param [type] $request
	 *
	 * @return void
	 */
	private function _applyFillter(&$request)
	{
		parse_str($this->request->getGet("filter"), $filter);
		unset($request['filter']);
		foreach ($filter as $field => $row) {
			if ($row['keyword'] != "") {
				$request[$field . "[" . $row['operator'] . "]"] = $row['keyword'];
			}
		}
	}

	public function checkData($id)
	{
		$data = $this->model->find($id);
		return $data;
	}
}
