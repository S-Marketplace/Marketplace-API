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
        // $userToken = $this->generateAuthorization();

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

    function generateAuthorization()
    {
        $str = "44a787903ca28cf0c740eb33ee044c1c400fcd53fd5f1d69f31826e99565b4be153c1292653ed59fd112fecb178afd14c5946c9b7c47700a1ebeaed28242e72a9cadc2c01c886899d269d3fc842bb124dee5d46f93e5fa0fb2fabd68da07eed1e110b0a6f7708b62720059a8a1bee282ad13bf637d6624b05674a9f93a1a1ff6aca8359b2e584d9bdd05285bbc7490210b2157494d0e2718d4da6eeb3887b83f89f935204e238eeab9d3acb8a80aa641b8d74cd749b2c0e72a33a627fa8e997c57d70aad97f74383aba26c7d20189063018cfca7615f055499355bad4ab816120a7dc3ae90635d4eded3c6af55940e685f19ecc30164c61854df1f3a462ba9bcc0d8ccc24a594c8b59d47d7d42859213c407e89f209e2d08d5a4161fdf650e1630855d5d8ebaca0dbabf2d6de6cb51a116cab4428ba0c859e96531c7f78a9c2ad211b777afc2a57987e41bee8e52f7eb6419ec75c5f3fba8d7964870f3d70e98fc4cb26b8d449f87552cd79379e391f0ecce09a3d21d84c2c9d3372de31cf47e28b9b693afd86bc5ee2da1b93cc213e8870cdea06070a2cb1e69fd287f719cd48f939f9de1ec7201036c739b98e689174da4a74049f4732f410dbfea4268c7b56324a97184758d26bd9e4292529f5266754e9f966a47c13833c742276a410898569728059041764d1124c28521dbf1d4da389e87789903d0b03bf760683a95e81d538e5d17d98ab683ba83fe93e395621a9440af0f9f64402b0344333a870dcb231e33123ee1f2ef58795673b86e24645f44b90dd05c4c892135736ff3ec2446c710e535e3d5de3258fd1501d89e7a8a17bcbd4f26674568a2a3409f53212a61";
        // secretKey
        $str2 = "MsbuwcXLI1lEnC2-WUiB5Q==";

        $bigInteger = 0;
        $length = (int)(strlen($str) / 2);
        $length2 = strlen($str2) + $length;
        $i = 0;
        while ($i < strlen($str2)) {
            $i2 = $length + $i;
            $nextInt = 10;$i == 0 ? rand(0, $i2 - 1) + 1 : rand(0, $i2);
            $str = $this->addStrAtOffset($str, bin2hex($str2[$i]), $nextInt * 2);
         
            $bigInteger = bcadd(bcmul($bigInteger, $length2), $nextInt);
            $i++;
        }

        return [
            'authorization' => $str,
            'nonce1' => $bigInteger,
        ];
    }

    function addStrAtOffset($origStr, $insertStr, $offset, $paddingCha = ' ')
    {
        $origStrArr = str_split($origStr, 1);

        if ($offset >= count($origStrArr)) {
            for ($i = count($origStrArr); $i <= $offset; $i++) {
                if ($i == $offset) $origStrArr[] = $insertStr;
                else $origStrArr[] = $paddingCha;
            }
        } else {
            $origStrArr[$offset] = $insertStr . $origStrArr[$offset];
        }

        return implode($origStrArr);
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

    function base64url_decode($data)
    {
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

    // private function generateAuthorization()
    // {
    //     $secretKeyPin = $this->secretKeyPin . strtotime(date('Y-m-d H:i:s'));

    //     return md5($secretKeyPin);
    // }

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

        if ($response->getStatusCode() == 200) {
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
