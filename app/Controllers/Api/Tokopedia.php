<?php namespace App\Controllers\Api;

use App\Libraries\TokopediaApi;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class Tokopedia extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';
    protected $tokopediaApi;
    protected $validationMessage = [];

    public function __construct()
    {
        $this->tokpedApi = new TokopediaApi();
    }

    public function sendOTP()
    {
        $response = $this->tokpedApi->sendOTP();

        return $this->response($response);
    }

    public function auth()
    {
        if ($this->validate([
            'otp' => 'required|numeric|min_length[6]|max_length[6]',
        ], $this->validationMessage)) {
           
            try {
                $otp = $this->request->getPost('otp');
                $response = $this->tokpedApi->validasiOTP($otp);
                $response = $this->tokpedApi->loginMutationV2($response['OTPValidate']['validateToken']);
        
                return $this->response($response);
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function isAuth()
    {
        $response = $this->tokpedApi->isAuth();

        return $this->response($response);
    }

    public function cekVaNumber()
    {
        $response = $this->tokpedApi->checkVaNumberMitraBRI();

        return $this->response($response);
    }

    public function cekSaldoMitra()
    {
        $response = $this->tokpedApi->checkSaldoMitraBRI();

        return $this->response($response);
    }

    protected function response($data = null, int $code = 200, $message = null)
    {
        return parent::respond([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
