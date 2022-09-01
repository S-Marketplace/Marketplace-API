<?php namespace App\Controllers\Api\Digipos;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use App\Controllers\Api\Digipos\MyResourceDigipos;
use App\Libraries\Cryptography;

class Auth extends MyResourceDigipos
{
    public function cryptographyPlayground(){
        $cryptPin = new Cryptography('e19bfde71b2141cef379691aa53f7251', 'AES-128-ECB');
        $cryptResponse = new Cryptography('be1d1aac4a2db00a207f502883d93794', 'AES-128-ECB');

        return $this->response([
            'pin' => [
                'enc' => $cryptPin->sslEncrypt(('918607')), // EXPECT: cfc6557b7254f4261eb34bb3538e112e
                'dec' => $cryptPin->sslDecrypt((hex2bin('cfc6557b7254f4261eb34bb3538e112e')))
            ],
            'response' => [
                'dec' => $cryptResponse->sslDecrypt((hex2bin('839cb3f400b3c4219f36d2ca8eadcfb550cffe2963e1524e164020a021d9e1f6d200d57b6ef81f25a4d87128a318f5fa98e42800ff8f2a26e2b29e4a512a16578bacacc0d66524d35286edae9d8ceaece55808a93f9d1ed4ab1467048d2fff95d55383ba05a66f8af1b72631985ffa524f1856e406c3145fe9a67d0bb0e7561e13c363af699462541b5b0f8904a0666dd62bd22ab19776eb0e1533c39a5e2e1f31fae30da13d1a398ee4393b8c483ca6a70897887ade3fbf5f58daf07284b571')))
            ]
        ]);
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
            'msisdn' => 'required|numeric',
            'retailerId' => 'required|numeric',
        ], $this->validationMessage)) {
            
            $otp = $this->request->getPost('otp');
            $msisdn = $this->request->getPost('msisdn');
            $retailerId = $this->request->getPost('retailerId');

            try {
                // Example Data
                $response = json_decode('{
                    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJxckNvZGUiOiIwMDI1OTA5NCIsInVzZXJfbmFtZSI6IjA4OTk0NTg3MTA3Iiwic2NvcGUiOlsicmVhZCIsIndyaXRlIl0sInJldGFpbGVyTmFtZSI6IlN1bWJ1IENlbGwiLCJpc0ZpcnN0dGltZSI6ZmFsc2UsImdhdGV3YXlUb2tlbiI6InNmYnl0c3phMjVua3cydDMzdXphbTNzeCIsIm1zaXNkbiI6IjA4OTk0NTg3MTA3IiwiYXV0aG9yaXRpZXMiOlsiVVNFUiJdLCJqdGkiOiJjMGZiNDFjZC1mOTBmLTQ0ZmEtYjBhNi1lM2VmYTY1Njg3MGMiLCJjbGllbnRfaWQiOiJyaXRhMiIsInN0YXR1cyI6dHJ1ZX0.da59DrIKdNAYz8uem1FoEEe6t9UfmxqVVfp_EkeSAds",
                    "token_type": "bearer",
                    "scope": "read write",
                    "qrCode": "00259094",
                    "retailerName": "Sumbu Cell",
                    "isFirsttime": false,
                    "gatewayToken": "sfbytsza25nkw2t33uzam3sx",
                    "msisdn": "08994587107",
                    "status": true,
                    "jti": "c0fb41cd-f90f-44fa-b0a6-e3efa656870c"
                }', true);

                $response = $this->ritaApi->verifyToken($msisdn, $otp, $retailerId);
                
                if(isset($response['access_token'])){
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
        
                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "user" => $response,
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN, 
                        "user" => $response,
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
