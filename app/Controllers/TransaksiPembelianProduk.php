<?php namespace App\Controllers;

use App\Controllers\Api\Keranjang;
use App\Models\CheckoutKurirModel;
use App\Models\KeranjangModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class TransaksiPembelianProduk extends BaseController
{
    protected $modelName = 'App\Models\CheckoutModel';
    protected $format    = 'json';

    protected $rules = [
        'noResi' => ['label' => 'Nomor Resi', 'rules' => 'required'],
    ];

    public function index()
    {
        return $this->template->setActiveUrl('TransaksiPembelianProduk')
            ->view("Transaksi/PembelianProduk/index");
    }

     /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->withDetail();
        $this->model->with(['kategori', 'pembayaran', 'kurir']);

        return parent::grid();
    }

    public function keranjangDetail($idCheckout){
        $keranjangModel = new KeranjangModel();
        
        $response =  $this->response($keranjangModel->getKeranjangDetail($idCheckout), 200);
        return $this->response->setJSON($response);
    }

    public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
				try {
					$primaryId = $this->request->getVar($primary);
					$noResi = $this->request->getVar('noResi');

					$checkoutKurirModel = new CheckoutKurirModel();
                    $checkoutKurirModel->where('ckurCheckoutId', $primaryId);
                    $checkoutKurirModel->update(null, [
                        'ckurNoResi' => $noResi,
                    ]);

                    $this->model->update($primaryId, [
                        'cktStatus' => 'dikirim',
                    ]);

					$response = $this->response(null, 200, 'No Resi berhasil diperbaharui');
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

}
