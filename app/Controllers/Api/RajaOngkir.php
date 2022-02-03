<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Libraries\RajaOngkirShipping;

/**
 * Class Keranjang
 * @note Resource untuk mengelola data t_keranjang
 * @dataDescription t_keranjang
 * @package App\Controllers
 */
class RajaOngkir extends MyResourceController
{
    private $rajaOngkir;
    function __construct()
    {
        $this->rajaOngkir = new RajaOngkirShipping();
    }

    function getKota(){
        $id = $this->request->getVar('id');
        $provinsi = $this->request->getVar('provinsi');
        
        return $this->response->setJSON($this->rajaOngkir->city($id, $provinsi));
    }

    function getProvinsi(){
        $id = $this->request->getVar('id');
        
        return $this->response->setJSON($this->rajaOngkir->province($id));
    }

    function getKecamatan(){
        $city = $this->request->getVar('city');
        
        return $this->response->setJSON($this->rajaOngkir->subdistrict($city));
    }
}
