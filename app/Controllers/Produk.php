<?php namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use CodeIgniter\Config\Config;
use App\Models\ProdukGambarModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use App\Controllers\MyResourceController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Border;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Produk
 * @note Resource untuk mengelola data m_produk
 * @dataDescription m_produk
 * @package App\Controllers
 */
class Produk extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $format    = 'json';

    protected $rules = [
       'id' => ['label' => 'Kode Produk', 'rules' => 'required|min_length[4]|cek_kode_sudah_digunakan[idBefore]'],
       'nama' => ['label' => 'Nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required'],
       'harga' => ['label' => 'Harga', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
       'stok' => ['label' => 'Stok', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
       'diskon' => ['label' => 'Diskon', 'rules' => 'required|numeric|less_than_equal_to[100]|greater_than_equal_to[0]'],
    //    'hargaPer' => ['label' => 'hargaPer', 'rules' => 'required'],
       'berat' => ['label' => 'Berat', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
       'kategoriId' => ['label' => 'Kategori', 'rules' => 'required'],
       'gambar[]' => ['label' => 'Gambar', 'rules' => 'required|uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,jpeg,jpg]|mime_in[gambar, image/jpg,image/jpeg]'],
   ];
   
    public function index()
    {
        return $this->template->setActiveUrl('Produk')
           ->view("Produk/index");
    }
    
    /**
     * Mengambil data kategori
     *
     * @return void
     */
    private function getKategori()
    {
        $kategoriModel = new KategoriModel();

        $kategoriData = $kategoriModel->asObject()->find();

        $res = [];
        foreach ($kategoriData as $key => $value) {
            $res[$value->ktgId] = $value->ktgNama;
        }
        return $res;
    }

    /**
     * Menambahkan data kategori
     *
     * @return void
     */
    public function tambah()
    {
        $data = [
           'kategori' => $this->getKategori(),
       ];
      
        return $this->template->setActiveUrl('Produk')
           ->view("Produk/tambah", $data);
    }
    
    /**
     * Mengubah data produk ke halaman baru
     *
     * @param [type] $produkId
     * @return void
     */
    public function ubah($produkId)
    {
        $produkGambar = new ProdukGambarModel();

        $data = [
           'kategori' => $this->getKategori(),
           'produk' => $this->model->asObject()->find($produkId),
           'produkGambar' => $produkGambar->where(['prdgbrProdukId' => $produkId])->asObject()->find(),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('Produk')
           ->view("Produk/tambah", $data);
    }

    /**
     * Menghapus gambar rpoduk
     *
     * @param [type] $id
     * @param [type] $produkId
     * @return void
     */
    public function hapusGambar($id, $produkId){
        try {
            $produkGambar = new ProdukGambarModel();
            $length = $produkGambar->where(['prdgbrProdukId' => $produkId])->asObject()->find();

            if(count($length) <= 1){
			    $response = $this->response(null, '500', 'Tidak bisa dihapus, setidaknya minimal ada 1 gambar');
    			return $this->response->setJSON($response);
            }

            $status = $produkGambar->delete($id);

			$response = $this->response(null, ($status ? 200 : 500));
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
    }

    /**
     * Mengupload photo produk
     *
     * @param [type] $id
     * @return void
     */
    protected function uploadFile($id)
    {
        $produkGambarModel = new ProdukGambarModel();
        foreach($this->request->getFileMultiple('gambar') as $file)
        {   
            if($file->getClientName() == ''){
                continue;
            }

            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/produk_gambar', $newName);

            $data = [
                'prdgbrProdukId' =>  $id,
                'prdgbrFile' =>  $newName,
            ];

            $save = $produkGambarModel->insert($data);

            $post = $this->request->getVar();
            $post['gambar[]'] = 'filename';
            $this->request->setGlobal("request", $post);
        }
    }

    /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori']);
        $this->model->withGambarProduk();

        return parent::grid();
    }

    /**
     * Menyimpan data produk
     *
     * @param string $primary
     * @return void
     */
    public function simpan($primary = '')
    {
        $post = $this->request->getVar();
        $post['harga'] = str_replace(['.', ','], '', $post['harga']);
        $this->request->setGlobal("request", $post);

        $file = current($this->request->getFileMultiple("gambar"));
        if ($file && $file->getError() == 0) {
            $post['gambar[]'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('idBefore');
        if ($id != '') {
            $checkData = $this->checkData($id);
           
            if (!empty($checkData)) {
                unset($this->rules['gambar[]']);
            }
        }

        if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
			
				try {
					$primaryId = $this->request->getVar('idBefore');
					$entityClass = $this->model->getReturnType();
					$entity = new $entityClass();
					$entity->fill($this->request->getVar());

					$this->model->transStart();
					if ($primaryId == '') {
						$this->model->insert($entity, false);
						if ($this->model->getInsertID() > 0) {
							$primaryId = $this->model->getInsertID();
							$entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
						}
					} else {
						$this->model->set($entity->toRawArray())
							->update($primaryId);
					}

					$this->model->transComplete();
					$status = $this->model->transStatus();

                    try {
                        $this->uploadFile($primaryId);
                    } catch (\Exception $ex) {
                        $response =  $this->response(null, 500, $ex->getMessage());
                        return $this->response->setJSON($response);
                    }

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

    private $productStartIndexExcel = 3;
    /**
     * Download Template produk
     *
     * @param integer $minimumStock
     * @return void
     */
    public function downloadTemplate($minimumStock = 0){
        $reader = new Xlsx();
        $spreadsheet = $reader->load(ROOTPATH . 'public/file_templates/Template Produk.xlsx');
        $sheet = $spreadsheet->setActiveSheetIndexByName('Template');

        $styleArrayRef = [
            'font' => [
                'bold' => false,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $refRowStart = $this->productStartIndexExcel;

        $no = 'A';
        $produkId = 'B';
        $produkNama = 'C';
        $produkStok = 'D';

        $refProgramId = 'F';
        $refProgramNama = 'G';

        // Referensi Produk
        $produkModel = new ProdukModel();
        $produk = $produkModel->where(['produkStok <=' => $minimumStock])->asObject()->find();
        $refRowProduk = $refRowStart;
        foreach ($produk as $key => $val) {
            $refRowProduk++;
            $sheet->setCellValue("{$no}{$refRowProduk}", $key+1);
            $sheet->setCellValue("{$produkId}{$refRowProduk}", $val->produkId);
            $sheet->setCellValue("{$produkNama}{$refRowProduk}", $val->produkNama);
            $sheet->setCellValue("{$produkStok}{$refRowProduk}", $val->produkStok);
        }
        $sheet->getStyle("{$no}{$refRowStart}:{$produkStok}{$refRowProduk}")->applyFromArray($styleArrayRef);


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('filename:Template_Produk.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Template_Produk.xlsx"');
        ob_end_clean();
        $writer->save("php://output");
        exit;
    }

    public function bulkUpdate(){
        $file = $this->request->getFile('file');
        $extension = $file->getClientExtension();

        if ($extension == 'xls') {
            $reader = new Xls();
        } else if ($extension == 'xlsx') {
            $reader = new Xlsx();
        } else {
            $response = [
                'code' => 400,
                'message' => [
                    'file' => 'Hanya File Excel 2007 (.xlsx) atau File Excel 2003 (.xls) yang diperbolehkan'
                ],
            ];

            return $this->response->setJSON($response);
        }

        $spreadsheet = $reader->load($file);
        $dataImport = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $dataImport = array_slice($dataImport, $this->productStartIndexExcel);
        
        $produkModel = new ProdukModel();
        $countUpdate = 0;
        foreach ($dataImport as $key => $value) {
            $id = $value['B'];
            if(!empty($id)){
                $countUpdate++;
                $produkModel->update($id, [
                    'produkNama'=> $value['C'],
                    'produkStok'=> $value['D'],
                ]);
            }
        }

        $response = [
            'code' => 200,
            'message' => $countUpdate.' Produk Berhasil di update',
        ];

        return $this->response->setJSON($response);
    }
}
