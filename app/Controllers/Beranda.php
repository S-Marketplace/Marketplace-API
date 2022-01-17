<?php

namespace App\Controllers;

use App\Models\BerandaModel;
use App\Controllers\BaseController;

class Beranda extends BaseController
{
    protected $activeUrl = 'Beranda';
    protected $model = '';

    protected $rules = [];

    const BULAN_ARRAY = [
        '1' => '0',
        '2' => '1',
        '3' => '2',
        '4' => '3',
        '5' => '4',
        '6' => '5',
        '7' => '6',
        '8' => '7',
        '9' => '8',
        '10' => '9',
        '11' => '10',
        '12' => '11'
    ];

    const BULAN_LIST = [
        'Jan' => '1',
        'Feb' => '2',
        'Mar' => '3',
        'Apr' => '4',
        'Mei' => '5',
        'Jun' => '6',
        'Jul' => '7',
        'Agu' => '8',
        'Sep' => '9',
        'Okt' => '10',
        'Nov' => '11',
        'Des' => '12'
    ];

    public function __construct()
    {
        // $this->model = new BerandaModel();
    }

    /**
     * dateTest
     *
     * description
     *
     * @return void
     */
    public function dateTest()
    {
        echo date('Y-m-d H:i:s');
    }

    public function index()
    {

        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Beranda/index");
    }

    public function dataBeranda()
    {
        $filter = $this->request->getPost('filter');
        $dari = $this->request->getPost('dari');
        $sampai = $this->request->getPost('sampai');

        $date = date_create($dari);
        $dariTahun = date_format($date, "Y");

        $date = date_create($sampai);
        $sampaiTahun = date_format($date, "Y");

        $categories = [];
        $dataChart = [];
        if ($filter == 'tahun') {
            for ($i = $dariTahun; $i <= $sampaiTahun; $i++) {
                $categories[] = $i;
                $dataKP[] = [
                    'key' => $i,
                    'jumlah' => 0,
                ];
            }
        } else if ($filter == 'bulan') {

            foreach (self::BULAN_LIST as $key => $value) {
                $categories[] = $key;
                $dataKP[] = [
                    'key' => $value,
                    'jumlah' => 0,
                ];
            }
        }

        $kunjungan = $dataKP;
        $penitipan = $dataKP;

        $rekapAntrian = $this->model->jumlahAntrian($filter, $dari, $sampai)->get()->getResultArray();

        foreach ($rekapAntrian as $value) {
            $key = array_search($value[$filter], array_column($dataKP, 'key'));
            $penitipan[$key]['jumlah'] = $value['penitipan'];
            $kunjungan[$key]['jumlah'] = $value['kunjungan'];
        }

        $dataPenitipan = $dataKunjungan = [];
        foreach ($penitipan as $key => $value) {
            $dataPenitipan[] = $value['jumlah'];
        }
        foreach ($kunjungan as $key => $value) {
            $dataKunjungan[] = $value['jumlah'];
        }

        $dataChart['categories'] = $categories;
        $dataChart['penitipan'] = $dataPenitipan;
        $dataChart['kunjungan'] = $dataKunjungan;

        $antrianHariIni = $this->model->antrianHariIni()->get()->getResultArray();
        $hariIni = $antrianHariIni[0];
        $hariIni['kunjungan'] = ($hariIni['kunjungan']) ? $hariIni['kunjungan'] : '0';
        $hariIni['penitipan'] = ($hariIni['penitipan']) ? $hariIni['penitipan'] : '0';

        $jumlahNapi = $this->model->jumlahNapi()->get()->getResultArray();

        $data = [
            'rekapAntrian' => $rekapAntrian,
            'dataChart' => $dataChart,
            'antrianHariIni' => $hariIni,
            'jumlahNapi' => number_format($jumlahNapi[0]['jumlah'], 0, '', '.'),
        ];

        return $this->response->setJSON($data);
    }
}
