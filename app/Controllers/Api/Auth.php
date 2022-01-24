<?php

namespace App\Controllers\Api;

use Firebase\JWT\JWT;
use App\Models\UserModel;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Route;
use Firebase\JWT\BeforeValidException;
use App\Controllers\MyResourceController;
use App\Controllers\BaseResourceController;
use Firebase\JWT\SignatureInvalidException;

/**
 * Class Auth
 * @note Resource untuk mendapatkan token access
 * @dataDescription Access token dan Refresh Token
 * @package App\Controllers
 */
class Auth extends MyResourceController
{
    const LIFETIME_ACCESS_TOKEN = (60 * 30);
    const LIFETIME_REFRESH_TOKEN = (60 * 60 * 24 * 30);

    protected $format = "json";

    protected $rulesCreate = [
        'username'=>['rules'=>'required'],
        'password'=>['rules'=>'required'],
    ];

    protected $rulesUpdate = [
        'tokenRefresh'=>['rules'=>'required']
    ];

    public function auth($username, $password, $apiKeys){
        $keyAccess = config("App")->JWTKeyAccess;
        $keyRefresh = config("App")->JWTKeyRefresh;

        $model = new UserModel();
        $model->select('*');
        $model->with(["role"]);
        $user = $model->find($username);

        if (isset($user) && $user->verifyPassword($password)) {
            $accessPayload = [
                "iss" => base_url(),
                "aud" => base_url(),
                "iat" => time(),
                "nbf" => time(),
                "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                "user" => $user->toArray(),
                "key" => $apiKeys
            ];
            $refreshPayload = [
                "iss" => base_url(),
                "aud" => base_url(),
                "iat" => time(),
                "nbf" => time(),
                "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                "user" => $user->toArray(),
                "key" => $apiKeys
            ];

            $accessToken = JWT::encode($accessPayload, $keyAccess);
            $refreshToken = JWT::encode($refreshPayload, $keyRefresh);
            return [
                'code' => 200,
                'message' => null,
                'data' => ['accessToken' => $accessToken, 'refreshToken' => $refreshToken],
            ];
        } else {
            return [
                'code' => 400,
                'message' => 'Username/Password salah',
                'data' => null,
            ];
        }
    }

    /**
     * @note Ambil access token dan refresh token menggunakan Api Key yang telah terdaftar
     * @url /api/token
     * @method POST
     * @requiredHeader X-ApiKey
     * @return array|mixed
     */
    public function create()
    {
        if ($this->validate(['username' => 'required', 'password' => 'required'])) {
            $apiKeys = $this->request->getHeader("X-ApiKey");
            
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            $auth = $this->auth($username, $password, $apiKeys->getValue());
            return $this->response($auth['data'], $auth['code'], $auth['message']);

        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * @note Ambil access token menggunakan refresh token
     * @url  /api/token/refresh
     * @method PUT
     * @requiredHeader X-ApiKey
     * @param null $id
     * @return array|mixed
     */
    public function update($id = null)
    {
        if ($this->validate(['tokenRefresh' => 'required'])) {
            $apiKeys = $this->request->getHeader("X-ApiKey");
            $tokenRefresh = $this->request->getVar("tokenRefresh");

            try {
                $keyRefresh = config("App")->JWTKeyRefresh;
                $decoded = JWT::decode($tokenRefresh, $keyRefresh, ['HS256']);
                $apiKeys = $this->request->getHeader("X-ApiKey");
                $keyAccess = config("App")->JWTKeyAccess;
                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "user" => (array) $decoded->user,
                    "key" => $apiKeys->getValue()
                ];
                $accessToken = JWT::encode($accessPayload, $keyAccess);
                return $this->response(['accessToken' => $accessToken]);
            } catch (BeforeValidException $ex) {
                return $this->response(null, 400, 'Refresh Token belum valid');
            } catch (ExpiredException $ex) {
                return $this->response(null, 400, 'Refresh Token expired');
            } catch (SignatureInvalidException $ex) {
                return $this->response(null, 400, 'Refresh Token Signature Tidak valid');
            } catch (\Exception $ex) {
                return $this->response(null, 400, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
