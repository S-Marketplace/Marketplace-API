<?php

namespace App\Libraries;

use CodeIgniter\Config\Config;
use CodeIgniter\Session\Session;
use Config\App;

class RajaOngkirShipping
{
    private static $instances = [];

    private $curl = null;

    private $apiKey = 'aab4d5253a2eda400958c422b37f71b3';

    private $subdomain = ENVIRONMENT != 'production' ? 'sandbox' : 'my';
    private $baseUri = '';
    private $formData = [];

    public function __construct()
    {
        $this->baseUri = "https://api.rajaongkir.com/starter/";

        $this->options = [];
        $options['baseURI'] = $this->baseUri;
        $options['headers']['key'] = $this->apiKey;

        $this->curl = \Config\Services::curlrequest($options);
    }

    /**
     * Ini adalah method static yang mengontrol akses ke singleton
     * instance. Saat pertama kali dijalankan, akan membuat objek tunggal dan menempatkannya
     * ke dalam array statis. Pada pemanggilan selanjutnya, ini mengembalikan klien yang ada
     * pada objek yang disimpan di array statis.
     *
     * Implementasi ini memungkinkan Anda membuat subclass kelas Singleton sambil mempertahankan
     * hanya satu instance dari setiap subclass sekitar.
     * @return RajaOngkirShipping
     */

    public static function getInstance(): RajaOngkirShipping
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Check Province
     *
     * @return void
     */
    public function province($id = null)
    {
        $data = [];

        if($id) $data['id'] = $id;

        $response = $this->setFormData($data)->execute('GET', 'province');

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id ID kota/kabupaten
     * @param [type] $province ID propinsi
     * @return void
     */
    public function city($id = null, $province = null)
    {
        $data = [];

        if ($id && $province) {
            $data['id'] = $id;
            $data['province'] = $province;
        }

        $response = $this->setFormData($data)->execute('GET', 'city');

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param [type] $origin ID kota atau kabupaten asal
     * @param [type] $destination ID kota atau kabupaten tujuan
     * @param [type] $weight Berat kiriman dalam gram
     * @param [type] $courier Kode kurir: jne, pos, tiki.
     * @return void
     */
    public function cost($origin, $destination, $weight, $courier)
    {
        $data = [];
        $data['origin'] = $origin;
        $data['destination'] = $destination;
        $data['weight'] = $weight;
        $data['courier'] = $courier;

        $response = $this->setFormData($data)->execute('POST', 'cost');

        return $response;
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
    private function setFormData(array $params)
    {
        $this->formData = $params;
        $this->curl->setForm($params);
        return $this;
    }

    /**
     * Eksekusi request ke API
     * @param $method
     * @param $url
     * @param array $options
     * @return array|mixed
     */
    private function execute($method, $url, $options = [])
    {
        $options['baseURI'] = $this->baseUri;
        $options['debug'] = WRITEPATH . '/logs/log_curl_raja_ongkir.txt';
        $options['http_errors'] = false;

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);

        if ($response->getStatusCode() == 200) {
            $jsonArray = json_decode($response->getBody(), true);
            return $jsonArray;
        } else {
            return json_decode($response->getBody(), true);
            return [
                'code' => $response->getStatusCode(),
                'message' => json_decode($response->getBody(), true),
                'data' => null,
            ];
        }
    }
}
