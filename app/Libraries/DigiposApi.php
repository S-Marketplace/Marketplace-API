<?php

namespace App\Libraries;

use Exception;

class DigiposApi
{
    private static $instances = [];

    private $curl = null;
    private $secretKeyPin = 'digiposoutletapp';

    /**
     * Expired 1 Bulan
     *
     * @param [type] $userToken
     */
    public function __construct($userToken)
    {
        $userToken = $this->generateAuthorization();

        $this->options = [];
        $options['http_errors'] = false;
        $options['baseURI'] = 'https://digipos.telkomsel.com';
        $options['headers'] = [
            'Host' => 'digipos.telkomsel.com',
            'Authorization' => 'Bearer',
            'X-Dgp-Nonce' => '0',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept-Encoding' => 'gzip, deflate',
            'User-Agent' => 'okhttp/3.12.12'
        ];

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    
    function generateSecretKey($authorization = '', $nonce = '', $nonce1 = '')
    {
        // Authorization
        $str = $authorization;
        // X-DGP-nonce
        $bigInteger = $nonce;
        // X-DGP-nonce1
        $bigInteger2 = $nonce1;
        $sb = "";

        $length = strlen($bigInteger);
        $valueOf = $length;
        $iArr = array_fill(0, $length, 0);
        for ($i = 0; $i < $length; $i++) {
            $iArr[intval(bcmod($bigInteger2, $valueOf))] = intval(bcmod($bigInteger, 10));
            $bigInteger = bcdiv($bigInteger, 10);
            $bigInteger2 = bcdiv($bigInteger2, $valueOf);
        }

        $i2 = 0;
        for ($i3 = 0; $i3 < $length; $i3++) {
            $i2 += $iArr[$i3];
            $i4 = $i2 * 2;
            $sb .= substr($str, $i4, 2);
            $str = substr_replace($str, '', $i4, 2);
        }

        $result = implode(array_map("chr", $this->_generateBase64Format($sb)));
        $result = md5(($this->base64url_decode($result)));
        return $result;
    }

    function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), 4 - ((strlen($data) % 4) ?: 4), '=', STR_PAD_RIGHT));
      }

    private function _generateBase64Format($str)
    {
        $length = (int)(strlen($str) / 2);
        $bArr = array_fill(0, $length, 0);
        for ($i = 0; $i < $length; $i++) {
            $i2 = $i * 2;
            $bArr[$i] = intval(substr($str, $i2, 2), 16);
        }
        return $bArr;
    }

    private function generateAuthorization()
    {
        $secretKeyPin = $this->secretKeyPin . strtotime(date('Y-m-d H:i:s'));

        return md5($secretKeyPin);
    }

    public static function getInstance($userToken): DigiposApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($userToken);
        }

        return self::$instances[$cls];
    }

    /**
     * Mengembalikan CURL default
     * @return \CodeIgniter\HTTP\CURLRequest
     */
    private function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param array $params
     * @return $this
     */
    private function setBody($body)
    {
        $this->body = $body;
        $this->curl->setBody($body);
        return $this;
    }

    /**
     * Eksekusi request ke API
     * @param $method
     * @param $url
     * @param array $options
     * @return array|mixed
     */
    public function execute($method, $url, $options = [])
    {
        $options['debug'] = WRITEPATH . '/logs/log_digipos.txt';

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);
   
        if($response->getStatusCode() == 200){
            $data = json_decode($response->getBody(), true);
            
            return $data;
            // if (isset($data['data'])) {
            //     return $data['data'];
            // } else {
            //     return $data;
            // }
        }

        throw new Exception($response->getBody());

    }

    // ========================== AUTH =============================== //

    public function sendOTP($username, $password)
    {
        $passwordHash = md5($password);
        
        $response = $this
            ->setBody(json_encode([
                "appVersion" => "5.13.1", 
                "browser" => "Native", 
                "browserVersion" => "", 
                "deviceId" => "353739786799247", 
                "fcmToken" => "f0-qrBStRvC2xK0GTIjall:APA91bGR--rzG5fv5vV4sH9tTgoypsMx8hs-f1yz1OVh4TQlnIA7C78sEbsCbO7SckXQuxzwo786FUYjCnnFvYaG53SP_6Io78zNro2DvycptRLRyqEleGx2n_-St6NfwUU85MN0ojS5", 
                "forceLogin" => "true", 
                "isBrowser" => "false", 
                "karyawan" => "false", 
                "keepMeLoggedIn" => true, 
                "os" => "Android", 
                "osVersion" => "7.1.2", 
                "password" => "yas{$passwordHash}", 
                "username" => $username 
             ]))
            ->execute('POST', "/api/secure/user/auth/v2");

        return $response;
    }


}
