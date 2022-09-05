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
        $secretKeyResponse = $this->digiposApi->generateSecretKey('c77ec1794801e322dc93ceef39afbfa57f7527de385f740fa9fa4736e24dbb04954e64a46dc98cb9d7cc46ce218c8f6aeac9594bdf01259762f4755e1e311e646034395471e04f34657844fa1353786e16512b9aa0739a617453feacfe747c8505a5773efcbb3d309685792ca13d0bf7ff0e7d9de674ea8570a9fcc29ff49f8ba3c610de820f69f347a45074cb8f7049972c13fcb695c5b85cf315b074b19c36dd595be3eef871950965b324b25757af6172efb168d2b5e52dcc8d1a032410ba857f939fd9996af3047b14def077618d2016f804ce27b9a268afea3f7a106b2fe21b305aef1c7ef9a623eb125c6ec5a2535d6af68d7156424c459a7250c8813c625698ccf371f0f760e6699318ec949ec92ead2c44dfd76ce247b557255c33e8129fd236b7f0f196ba25eab811b2c9eb6fdcd85657bab83cf3a11a0f7b4a5c48af223e90a373f5234a815622efaea857c1a74ac7e79aa98bd5e3e0c2a14eea7a7ac81002ea1b7b052b18ef476d24019b4729f22fc183ec7cff430b9c79217445d7bf5c880ae4f401f138067cf24a779af811f6fcdf25196b04ea9aa6259368979caca9acb5ab940f3f842ff2c15e1e1ffcae95f6ba3dc16e5581ff5fff1326bebb0740ae4866347a45bd43271cc4e3946fc87f65f830d2d86eb991ba9bfdc0c109b6ebc8e5a8b49d3eaccfe967a4b395400b867d12a56dca41ebcef1568c1a77ef24209b52fe0e3c3f45d44820186ee9b2e5107c21dbcf23b69b7cdfab319383c630405ca43574aaaa20ebb8678be7372429b9329feb0fafeca500fc72955f6ecb9c76e018de30e2d98402e0f9bf981e669cca33f66bb4149bb7be01638981cc99b1367e2c1651b8', '732306357607073103738401', '390537044333677761756485291291100');
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

            return $this->convertResponse($response);
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
           
                if ($response->status == 0) {
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
                    $response->data->secretKey = $this->digiposApi->secretKey;

                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response->data,
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response->data,
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
                    "secret" => (array) $decoded->secret,
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
