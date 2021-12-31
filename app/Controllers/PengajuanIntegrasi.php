<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\PegawaiModel;
use App\Controllers\BaseController;
use App\Models\StatusPengajuanModel;
use App\Models\PengajuanIntegrasiModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PengajuanIntegrasi extends BaseController
{
    protected $activeUrl = 'PengajuanIntegrasi';
    protected $model = '';

    protected $rules = [
        'nik' => ['label' => 'Hari', 'rules' => 'required'],
        'napiId' => ['label' => 'Hari', 'rules' => 'required'],
        'status' => ['label' => 'Hari', 'rules' => 'required|in_list[0,1,2,3,4,5,6]'],
        'hubungan' => ['label' => 'Hari', 'rules' => 'required'],
        'tanggal' => ['label' => 'Hari', 'rules' => 'required'],
    ];

    public function __construct()
    {
        $this->model = new PengajuanIntegrasiModel();
    }

    public function index()
    {
        $data = [
            'status' => $this->statusPengajuan(),
        ];

        helper('form');
        return $this->template->setActiveUrl($this->activeUrl)
            ->view("PengajuanIntegrasi/index", $data);
    }

    public function grid()
    {
        $this->model->with(['napi', 'user', 'statusPengajuan']);
        return parent::grid();
    }

    public function simpan($primary = 'id')
    {
        if ($this->request->isAJAX()) {

            helper('form');
            if ($this->validate($this->rules)) {
                try {
                    $this->uploadFile();
                } catch (\Exception $ex) {
                    $response =  $this->response(null, 500, $ex->getMessage());
                    return $this->response->setJSON($response);
                }

                try {
                    $entityClass = $this->model->getReturnType();
                    $entity = new $entityClass();
                    $entity->fill($this->request->getVar());

                    $this->model->transStart();
                    $this->model->set($entity->toRawArray())
                        ->update($this->request->getVar($primary));

                    $this->model->transComplete();
                    $status = $this->model->transStatus();

                    // if ($status && $entity->status == 6) {

                    //     $this->model->select('*');
                    //     $this->model->with(['napi', 'user', 'agama']);

                    //     $data = $this->model->find($this->request->getVar($primary));

                    //     $pegawai = new PegawaiModel();
                    //     $pegawai->select('*');
                    //     $pegawai->with(['jabatan']);

                    //     $dataPegawai = $pegawai->where('pgwJabatanId', 1)->first();
                    //     $data = array_merge($data->toArray(), ['pegawai' => $dataPegawai->toArray()]);

                    //     helper('datetime');

                    //     // Begin : Pernyataan Integrasi
                    //     $html = view("PengajuanIntegrasi/cetak/pernyataan_integrasi", $data);

                    //     $options = new Options();
                    //     $dompdf = new Dompdf($options);
                    //     $options->set('isRemoteEnabled', TRUE);
                    //     $dompdf->loadHtml($html);
                    //     $dompdf->setPaper('A4', 'portrait');
                    //     $dompdf->setHttpContext(
                    //         stream_context_create([
                    //             'ssl' => [
                    //                 'allow_self_signed' => TRUE,
                    //                 'verify_peer' => FALSE,
                    //                 'verify_peer_name' => FALSE,
                    //             ]
                    //         ])
                    //     );
                    //     $dompdf->render();
                    //     $output = $dompdf->output();

                    //     $path = Config::get("App")->uploadPath . "pengajuan_integrasi";
                    //     if (!is_dir($path)) {
                    //         mkdir($path, 0777, true);
                    //     }

                    //     $filename = $this->request->getVar($primary) . "_" . $this->request->getVar('nik') . "_pernyataan_integrasi.pdf";
                    //     array_map('unlink', glob($path . DIRECTORY_SEPARATOR . $filename));

                    //     file_put_contents($path . DIRECTORY_SEPARATOR . $filename, $output);
                    //     // End : Pernyataan Integrasi

                    //     // Begin : Pernyataan Integrasi
                    //     $html = view("PengajuanIntegrasi/cetak/penjamin_integrasi", $data);

                    //     $options = new Options();
                    //     $dompdf = new Dompdf($options);
                    //     $options->set('isRemoteEnabled', TRUE);
                    //     $dompdf->loadHtml($html);
                    //     $dompdf->setPaper('A4', 'portrait');
                    //     $dompdf->setHttpContext(
                    //         stream_context_create([
                    //             'ssl' => [
                    //                 'allow_self_signed' => TRUE,
                    //                 'verify_peer' => FALSE,
                    //                 'verify_peer_name' => FALSE,
                    //             ]
                    //         ])
                    //     );
                    //     $dompdf->render();
                    //     $output = $dompdf->output();

                    //     $path = Config::get("App")->uploadPath . "pengajuan_integrasi";
                    //     if (!is_dir($path)) {
                    //         mkdir($path, 0777, true);
                    //     }

                    //     $filename = $this->request->getVar($primary) . "_" . $this->request->getVar('nik') . "_penjamin_integrasi.pdf";
                    //     array_map('unlink', glob($path . DIRECTORY_SEPARATOR . $filename));

                    //     file_put_contents($path . DIRECTORY_SEPARATOR . $filename, $output);
                    //     // End : Pernyataan Integrasi
                    // }

                    $response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
                    return $this->response->setJSON($response);
                } catch (DatabaseException $ex) {
                    $response =  $this->response(null, 500, $ex->getMessage());
                    return $this->response->setJSON($response);
                } catch (\mysqli_sql_exception $ex) {
                    $response =  $this->response(null, 500, $ex->getMessage());
                    return $this->response->setJSON($response);
                } catch (\Exception $ex) {
                    $response =  $this->response(null, 500, $ex->getMessage());
                    return $this->response->setJSON($response);
                }
            } else {
                $response =  $this->response(null, 400, $this->validator->getErrors());
                return $this->response->setJSON($response);
            }
        }
    }

    public function statusPengajuan()
    {
        $status = new StatusPengajuanModel();
        $status = $status->find();

        $dataStatus = [];
        foreach ($status as $value) {
            $dataStatus[$value->id] = $value->status;
        }
        return $dataStatus;
    }

    public function surat($tipe, $id)
    {
        $this->model->select('*');
        $this->model->with(['napi', 'user', 'agama']);

        $data = $this->model->find($id);

        if (!$data) {
            return redirect()->to(base_url('PengajuanIntegrasi'));
        }

        $pegawai = new PegawaiModel();
        $pegawai->select('*');
        $pegawai->with(['jabatan']);

        $dataPegawai = $pegawai->where('pgwJabatanId', 1)->first();
        $data = array_merge($data->toArray(), ['pegawai' => $dataPegawai->toArray()]);

        helper('datetime');

        if ($tipe == 'penjamin') {
            $view = 'penjamin_integrasi';
            $filename = 'Surat Penjamin Integrasi.pdf';
        } else if ($tipe == 'pernyataan') {
            $view = 'pernyataan_integrasi';
            $filename = 'Surat Pernyataan Integrasi.pdf';
        } else {
            return redirect()->to(base_url('PengajuanIntegrasi'));
        }

        $html = view("PengajuanIntegrasi/cetak/{$view}", $data);

        $options = new Options();
        $dompdf = new Dompdf($options);
        $options->set('isRemoteEnabled', TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $dompdf->render();
        $dompdf->stream($filename, array("Attachment" => false));
        exit;
    }
}
