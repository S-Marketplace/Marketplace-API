<?php

namespace App\Libraries;

class TokopediaPaymentApi
{
    private static $instances = [];

    private $curl = null;

    /**
     * Expired 1 Bulan
     *
     * @param [type] $SID_TOKOPEDIA
     */
    public function __construct($SID_TOKOPEDIA)
    {
        $this->options = [];
        $options['http_errors'] = true;
        $options['baseURI'] = 'https://pay.tokopedia.com';
        $options['headers'] = [
            'Cookie' => '_SID_Tokopedia_='.$SID_TOKOPEDIA,
            'Host' => 'pay.tokopedia.com',
            'Cache-Control' => 'max-age=0',
            'Origin' => 'https://mitra.tokopedia.com',
            'Upgrade-Insecure-Requests' => '1',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 7.1.2; G011A Build/N2G48H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.70 Mobile Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Referer' => 'https://mitra.tokopedia.com/digital/pulsa/1',
            // 'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-US,en;q=0.9',
        ];

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    public static function getInstance($SID_TOKOPEDIA): TokopediaPaymentApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($SID_TOKOPEDIA);
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
    private function setBody(string $body)
    {
        $this->body = $body;
        $this->curl->setBody($body)
            ->setHeader('Content-Length', strlen($body));
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
        $options['debug'] = WRITEPATH . '/logs/log_tokped.txt';
        $options['http_errors'] = false;

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);
     
        $data = json_decode($response->getBody(), true);
        
        if(is_array($data) && isset(current($data)['data'])){
            return current($data)['data'];
        } if(is_array($data)){
            return $data;
        } else{
            return $response->getBody();
        }
    }

    // ========================== PAYMENT =============================== //

    public function paymentHtmlPage($body)
    {
        return $this
            ->setBody($body)
            ->execute('POST', '/v2/payment');
    }

    // ======================= END  PAYMENT ============================= //

}
