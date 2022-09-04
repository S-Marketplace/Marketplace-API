<?php

namespace App\Controllers\Api\Digipos;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use App\Controllers\Api\Digipos\MyResourceDigipos;
use App\Libraries\Cryptography;

class Auth extends MyResourceDigipos
{
    public function cryptographyPlayground()
    {
        $secretKeyResponse = $this->digiposApi->generateSecretKey('ed04d4ec2a24e380e830f0e835c64850be2367e8406682c5f0c3a18d9f379d3948a075794d99ae3630a18abcd617613a6bd139e3895b2d8402da7ec30b42fda252a6c3d4c2d09d5133c1a23c34b97aa19a51571b631c990b66a127346df78daf3f474b6b84b6fd3bd55e0392e42d22397e89f774e45057dc52d44c063655c7abb7f271fe7290336a33346f437ec867d8f587e03d3c6e6586a43db80e0283d8ae29c8993c27e80aaca37beff2e42301ac718116628564b66cfd73bb7352d5b6e278fda0ec20f916aed13cfd63279dd65b2e3bf8a75ab4329f11c33a8f7d22edc4d1ebe81f6af1ee70ead515e8a90c723ac8b8cc8a9badd0cb6cff8350e6d8b16961ac2dca7d1ef3f4ebf0f82ef8ef56fe31fdaec81fa52018245de8576d5e7e87ab66e291c4ee2f2ec660f061f744c23a9162ad30691a5e1c582cdea780d1d42b900718c8b9b5b8ea6bb83959464be62684e5b859e1ba2a97e421c525f3d55f12cd7c440b04d64929a9b40672511add9909d3955e1cd903dfbef4133679cb0efadfb38a69c896ae9a350879e4c17d5dc4afdb0a0971062700a7934151ac0def98341cc89a513e13826b6cd9e254cb2a7a9f3bfbc3eb14d28ba2e2819f13d36bbcd86843797b983844888013a0b13fd6ef1f7f0cccf53000b94ed470f273ec8234c3d79b0110c38dfa70bee365279e5c57f2b2726ed52659ad03ac87efafebf79e580f422a96e44d6a8941ef83c8dc2090c589480b938381acef55d9f090b5826edafa2ff910a27b4fcfb19f1b1ff8ea6623e4e74445376a5305295b24e6845b6547fa3828b4c1494372411e3689586bc65c71c9c76b9de4901d0e617acce373291999a872a2317e9b', '819996365593972518054187', '792936813294733423580447392507267');
        // $cryptPin = new Cryptography('e19bfde71b2141cef379691aa53f7251', 'AES-128-ECB');
        // $cryptResponse = new Cryptography($secretKeyResponse, 'AES-128-ECB');

        return $this->response([
            'secretKey' => $secretKeyResponse,
        //     'pin' => [
        //         'enc' => $cryptPin->sslEncrypt(('918607')), // EXPECT: cfc6557b7254f4261eb34bb3538e112e
        //         'dec' => $cryptPin->sslDecrypt((hex2bin('cfc6557b7254f4261eb34bb3538e112e')))
        //     ],
        //     'response' => [
        //         'dec' => $cryptResponse->sslDecrypt((hex2bin('839cb3f400b3c4219f36d2ca8eadcfb550cffe2963e1524e164020a021d9e1f6d200d57b6ef81f25a4d87128a318f5fa98e42800ff8f2a26e2b29e4a512a16578bacacc0d66524d35286edae9d8ceaece55808a93f9d1ed4ab1467048d2fff95d55383ba05a66f8af1b72631985ffa524f1856e406c3145fe9a67d0bb0e7561e13c363af699462541b5b0f8904a0666dd62bd22ab19776eb0e1533c39a5e2e1f31fae30da13d1a398ee4393b8c483ca6a70897887ade3fbf5f58daf07284b571')))
        //     ], 
            // 'authorization' => $this->digiposApi->generateAuthorization('be1d1aac4a2db00a207f502883d93794')
        ]);
        
    }

    function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    public function sendOTP()
    {
        if ($this->validate([
            'username' => 'required',
            'password' => 'required',
        ], $this->validationMessage)) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $response = $this->digiposApi->sendOTP($username, $password);

            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function auth()
    {
        if ($this->validate([
            'otp' => 'required|numeric|min_length[6]|max_length[6]',
            'token' => 'required',
        ], $this->validationMessage)) {

            $otp = $this->request->getPost('otp');
            $token = $this->request->getPost('token');

            try {
                $response = $this->digiposApi->auth($otp, $token);
           
                if ($response['status'] == 0) {
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
                    $response['data']['secretKey'] = $this->digiposApi->secretKey;

                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response['data'],
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response['data'],
                        "key" => $apiKeys
                    ];

                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    $refreshToken = JWT::encode($refreshPayload, $keyRefresh);

                    return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken], 200);
                }

                return $this->response($response, 403, 'Login gagal');
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function refresh()
    {
        if ($this->validate(['tokenRefresh' => 'required'])) {
            $apiKeys = $this->request->getHeaderLine("X-ApiKey");
            $tokenRefresh = $this->request->getVar("tokenRefresh");

            try {
                $keyRefresh = config("App")->JWTKeyRefresh;
                $decoded = JWT::decode($tokenRefresh, $keyRefresh, ['HS256']);
                $keyAccess = config("App")->JWTKeyAccess;
                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "user" => (array) $decoded->user,
                    "key" => $apiKeys
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

    public function isAuth()
    {
        $response = $this->tokpedApi->isAuth();

        return $this->response($response);
    }
}
