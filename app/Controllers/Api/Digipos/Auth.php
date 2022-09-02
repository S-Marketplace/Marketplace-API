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
        $secretKeyResponse = $this->digiposApi->generateSecretKey('44a7874d903c73a28cf0c76240eb33ee044c751c400fcd53fd5f1d7769f31826e9639565b4be15583c1292653ed59fd1124cfecb178a49fd14c5946c319b6c7c47700a1e45beae6ed28242e72a9cadc243c01c886899d269d332fc842bb124dee5d42d6f93e5fa0fb2fa57bd68da07eed1e155106942b0a635f7708b6272005951a8a1bee2823dad13bf3d637d6624b05674a9f93a1a1ff6aca8359b2e584d9bdd05285bbc7490210b2157494d0e2718d4da6eeb3887b83f89f935204e238eeab9d3acb8a80aa641b8d74cd749b2c0e72a33a627fa8e997c57d70aad97f74383aba26c7d20189063018cfca7615f055499355bad4ab816120a7dc3ae90635d4eded3c6af55940e685f19ecc30164c61854df1f3a462ba9bcc0d8ccc24a594c8b59d47d7d42859213c407e89f209e2d08d5a4161fdf650e1630855d5d8ebaca0dbabf2d6de6cb51a116cab4428ba0c859e96531c7f78a9c2a4f694bf7405125f3c258c8f666365eae4f286591223c419bb7e0bcf7fd593f6dfc4cb26b8d449f87552cd79379e391f0ecce09a3d21d84c2c9d3372de31cf47e28b9b693afd86bc5ee2da1b93cc213e8870cdea06070a2cb1e69fd287f719cd48f939f9de1ec7201036c739b98e689174da4a74049f4732f410dbfea4268c7b5f2a7a93be0f49261188c1425d1963dd8bc8aa514d13482b7f229567498dac66f9bf92571c727549f5d422c5fde662d0a31f7917c99352bd47e2dbd7d51748c3f5c94a99918ee084e92728d23f95118de1d75aeab726a85001f2d382b3aaceb6041f1a155e57dd7eddde92915ec006847c905997bba4d8722c4d2106e7bd6cc021531f0d940aeefb51ef0f64893ab4608', '284573530554867512879812', '1120924280795018860791387952048369');
        $cryptPin = new Cryptography('e19bfde71b2141cef379691aa53f7251', 'AES-128-ECB');
        $cryptResponse = new Cryptography($secretKeyResponse, 'AES-128-ECB');

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

                if (isset($response['access_token'])) {
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
