<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Libraries\RajaOngkirShipping;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserAlamatModel;

/**
 * Class Keranjang
 * @note Resource untuk mengelola data t_keranjang
 * @dataDescription t_keranjang
 * @package App\Controllers
 */
class RajaOngkir extends MyResourceController
{
    private $rajaOngkir;
    private $originId = '35'; // Kalimantan Selatan

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

    /**
     * Get ongkir berdasarkan user
     *
     * @return void
     */
    function getOngkir(){
        $userAlamatModel = new UserAlamatModel();
        $keranjangModel = new KeranjangModel();

        $data = $userAlamatModel->where([
            'usralUsrEmail' => $this->user['email'],
            'usralIsActive' => '1',
        ])->find();
        $data = current($data);
        
        $destination = $data->kotaId;
        $weight = $keranjangModel->getBeratKeranjangCheck($this->user['email']);
        $courier = ['jne', 'jnt'];
        
        $ongkir = [];
        $tujuan = [];

        foreach ($courier as $value) {
            $dataOngkir = $this->rajaOngkir->cost($this->originId, $destination, $weight, $value);
            $ongkir = array_merge($ongkir, $dataOngkir['data']);
            $tujuan = [
                'asal' => $dataOngkir['extra']['origin_details'],
                'tujuan' => $dataOngkir['extra']['destination_details'],
            ];
        }

        $data = [
            'code' => 200,
            'message' => null,
            'data' => [
                'ongkir' => $ongkir,
                'detail' => $tujuan,
            ]
        ];
        
        return $this->response->setJSON($data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $checkoutId
     * @return void
     */
    public function getStatusPerjalanan($checkoutId){
        $modelCheckout = new CheckoutModel();
        $data = $modelCheckout->find($checkoutId);
        $statusPerjalanan = $this->rajaOngkir->waybill($data->noResiKurir, $data->kurir);
        
        return $this->response->setJSON($statusPerjalanan);
    }
}
