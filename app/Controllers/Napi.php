<?php

namespace App\Controllers;

use App\Models\NapiModel;
use App\Models\AgamaModel;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Napi extends BaseController
{
    protected $activeUrl = 'Napi';
    protected $model = '';

    protected $rules = [
        'noReg' => ['label' => 'No Registrasi', 'rules' => 'required'],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'blokKamar' => ['label' => 'Blok Kamar', 'rules' => 'required'],
        'uu' => ['label' => 'Undang-undang', 'rules' => 'required'],
        'lamaPidanaHari' => ['label' => 'Lama Pidana Hari', 'rules' => 'required|numeric'],
        'lamaPidanaBulan' => ['label' => 'Lama Pidana Bulan', 'rules' => 'required|numeric'],
        'lamaPidanaTahun' => ['label' => 'Lama Pidana Tahun', 'rules' => 'required|numeric'],
        'jenisKejahatan' => ['label' => 'Jenis Kejahatan', 'rules' => 'required'],
        'tanggalEkspirasi' => ['label' => 'Tanggal Ekspirasi', 'rules' => 'required'],
        'uptAsal' => ['label' => 'UPT Asal', 'rules' => 'required'],
        'pasalUtama' => ['label' => 'Pasal Utama', 'rules' => 'required'],
        // 'umur' => ['label' => 'Umur', 'rules' => 'required|numeric'],
        'agama' => ['label' => 'Agama', 'rules' => 'required'],
        'kewarganegaraan' => ['label' => 'Kewarganegaraan', 'rules' => 'required|in_list[WNI,WNA]'],
        'tanggalLahir' => ['label' => 'Kewarganegaraan', 'rules' => 'required'],
        'jenisKelamin' => ['label' => 'Jenis Kelamin', 'rules' => 'required|in_list[L,P]'],
        'jenisKejahatanNarkotika' => ['label' => 'Jenis Kejahatan Narkotika', 'rules' => 'required'],
        'statusKerjaWali' => ['label' => 'Status Kerja Wali', 'rules' => 'required'],
        'pasFoto' => ['label' => 'Pas Foto', 'rules' => 'required|uploaded[pasFoto]|max_size[pasFoto,5000]|ext_in[pasFoto,jpg,jpeg,png]|mime_in[pasFoto,image/jpeg,image/jpg,image/png]'],
    ];

    const KEWARGANEGARAAN = [
        'WNI' => 'WNI',
        'WNA' => 'WNA',
    ];

    public function __construct()
    {
        $this->model = new NapiModel();
    }

    public function index()
    {
        helper('form');
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Napi/index");
    }

    public function tambah()
    {
        $data = [
            'aksi' => 'Tambah',
            'id' => '',
            'data' => [],
            'agama' => $this->getAgama(),
            'kewarganegaraan' => self::KEWARGANEGARAAN,
        ];
        helper('form');
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Napi/form", $data);
    }

    public function edit($id = '')
    {
        if ($id) {
            $dataNapi = $this->model->find($id);

            $data = [
                'aksi' => 'Edit',
                'id' => $id,
                'data' => $dataNapi->toArray(),
                'agama' => $this->getAgama(),
                'kewarganegaraan' => self::KEWARGANEGARAAN,
            ];
            helper('form');
            return $this->template->setActiveUrl($this->activeUrl)
                ->view("Napi/form", $data);
        } else {
            return redirect()->to(base_url('Napi'));
        }
    }

    public function grid()
    {
        $this->model->with(['agamaRef']);

        return parent::grid();
    }

    protected function uploadFile()
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "napi";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("pasFoto");
        if ($file && $file->getError() == 0) {
            $noReg = $this->request->getVar('noReg');
            $noReg = str_replace('/', '_', $noReg);

            $mask = 'pas_foto_' . $noReg . '_*.*';
            array_map('unlink', glob($path . DIRECTORY_SEPARATOR . $mask));

            $filename = "pas_foto_" . $noReg  . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['pasFoto'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $id = $this->request->getPost('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->pasFoto != '') {
                unset($this->rules['pasFoto']);
            }
        }

        $file = $this->request->getFile("pasFoto");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['pasFoto'] = '-';
            $this->request->setGlobal("request", $post);
        }

        return parent::simpan($primary);
    }

    public function getAgama()
    {
        $agama = new AgamaModel();
        $data = $agama->find();

        $dataAgama = [];
        foreach ($data as $value) {
            $dataAgama[$value->id] = $value->nama;
        }

        return $dataAgama;
    }

    public function viewImport()
    {
        $modelAgama = new AgamaModel();
        $agama = $modelAgama->findAll();

        $dataAgama = [];
        foreach ($agama as $value) {
            $dataAgama[] = $value->toArray();
        }

        if (!$this->request->getFile('fileImport')) {
            $response = [
                'code' => 400,
                'message' => 'Anda belum memilih file import',
            ];

            return $this->response->setJSON($response);
        }

        $file = $this->request->getFile('fileImport');
        $extension = $file->getClientExtension();

        if ($extension == 'xls') {
            $reader = new Xls();
        } else if ($extension == 'xlsx') {
            $reader = new Xlsx();
        } else {
            $response = [
                'code' => 400,
                'message' => 'Hanya File Excel 2007 (.xlsx) atau File Excel 2003 (.xls) yang diperbolehkan',
            ];

            return $this->response->setJSON($response);
        }

        $spreadsheet = $reader->load($file);
        $dataImport = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        if ($dataImport[11]['B'] == '' && $dataImport[11]['S'] == '') {
            $response = [
                'code' => 400,
                'message' => 'Tidak ada data yang bisa diimport harap isikan data mulai dari baris ke 11.',
            ];

            return $this->response->setJSON($response);
        }

        $row = 1;
        $data = [];
        foreach ($dataImport as $val) {

            $noReg = $val['B'];
            $nama = $val['C'];
            $tanggalLahir = $val['D'];
            $jenisKelamin = $val['E'];
            $agama = $val['F'];
            $kewarganegaraan = $val['G'];
            $blokKamar = $val['H'];
            $uu = $val['I'];
            $pasalUtama = $val['J'];
            $lamaPidanaTahun = $val['K'];
            $lamaPidanaBulan = $val['L'];
            $lamaPidanaHari = $val['M'];
            $jenisKejahatan = $val['N'];
            $jenisKejahatanNarkotika = $val['O'];
            $tanggalEkspirasi = $val['P'];
            $uptAsal = $val['Q'];
            $statusKerjaWali = $val['R'];
            $pasFoto = $val['S'];

            $error = [];
            if ($row > 10) {

                if ($this->checkValidDate($tanggalEkspirasi)) {
                    $tanggalEkspirasi =  $this->checkValidDate($tanggalEkspirasi, true);
                } else {
                    $error['tanggalEkspirasi'] = 'Format tanggal ekspirasi tidak valid';
                }

                if ($this->checkValidDate($tanggalLahir)) {
                    $tanggalLahir =  $this->checkValidDate($tanggalLahir, true);
                } else {
                    $error['tanggalLahir'] = 'Format tanggal lahir tidak valid';
                }

                if ($jenisKelamin != 'L' && $jenisKelamin != 'P') {
                    $error['jenisKelamin'] = 'Jenis Kelamin tidak valid';
                }

                if ($kewarganegaraan != 'WNI' && $kewarganegaraan != 'WNA') {
                    $error['kewarganegaraan'] = 'Kewarganegaraan tidak valid';
                }

                $agamaNama = '';
                foreach ($dataAgama as $a) {
                    if (in_array($agama, $a)) {
                        $agamaNama = $a['nama'];
                    }
                }

                if ($agama == '' || $agamaNama == '') {
                    $error['agama'] = 'ID agama yang dimasukkan tidak tersedia';
                }

                $array = [
                    'noReg' => $noReg,
                    'nama' => $nama,
                    'tanggalLahir' => $tanggalLahir,
                    'jenisKelamin' => $jenisKelamin,
                    'agama' => $agama,
                    'agamaNama' => $agamaNama,
                    'kewarganegaraan' => $kewarganegaraan,
                    'blokKamar' => $blokKamar,
                    'uu' => $uu,
                    'pasalUtama' => $pasalUtama,
                    'lamaPidanaHari' => $lamaPidanaHari,
                    'lamaPidanaBulan' => $lamaPidanaBulan,
                    'lamaPidanaTahun' => $lamaPidanaTahun,
                    'jenisKejahatan' => $jenisKejahatan,
                    'jenisKejahatanNarkotika' => $jenisKejahatanNarkotika,
                    'tanggalEkspirasi' => $tanggalEkspirasi,
                    'uptAsal' => $uptAsal,
                    'statusKerjaWali' => $statusKerjaWali,
                    'pasFoto' => $pasFoto,
                    'error' => $error,
                    'resMessage' => '',
                ];

                $data[] = $array;
            }
            $row++;
        }

        $response = [
            'code' => 200,
            'message' => '',
            'data' => $data,
        ];

        return $this->response->setJSON($response);
    }

    public function importData()
    {
        // if ($this->validate($this->rules)) {

        $data = $this->request->getPost('first');
        if (isset($data['error']) && $data['error']) {
            $response = $this->response(null, 400, $data['error']);
            return $this->response->setJSON($response);
        }

        $cek = $this->model->where([
            'napiNoReg' => $data['noReg'],
            'napiNama' => $data['nama'],
        ])->first();

        if (!$cek) {

            try {

                $entityClass = $this->model->getReturnType();
                $entity = new $entityClass();
                $entity->fill($this->request->getPost('first'));

                $status = $this->model->insert($entity, false);

                $response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
                return $this->response->setJSON($response);
            } catch (DatabaseException $ex) {
                $response =  $this->response(null, 500, 'Gagal menyimpan, periksa kembali koneksi atau data yang di import');
                return $this->response->setJSON($response);
            } catch (\mysqli_sql_exception $ex) {
                $response =  $this->response(null, 500, 'Gagal menyimpan, periksa kembali koneksi atau data yang di import');
                return $this->response->setJSON($response);
            } catch (\Exception $ex) {
                $response =  $this->response(null, 500, 'Gagal menyimpan, periksa kembali koneksi atau data yang di import');
                return $this->response->setJSON($response);
            }
        } else {
            $response =  $this->response(null, 400, 'Data sudah pernah disimpan atau diimport');
            return $this->response->setJSON($response);
        }
        // } else {
        //     $response =  $this->response(null, 400, $this->validator->getErrors());
        //     return $this->response->setJSON($response);
        // }
    }

    protected function checkValidDate($date, bool $returnDate = false)
    {
        $date = str_replace('/', '-', $date);
        $pattern = "/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/";

        if ($returnDate) {
            $dateFormat = date_create_from_format('d-m-Y', $date);
            $date = date_format($dateFormat, 'Y-m-d');
            return $date;
        } else {
            return preg_match($pattern, $date);
        }
    }
}
