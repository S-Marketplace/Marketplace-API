<?php namespace App\Controllers\Api\Pulsa;

use App\Controllers\MyResourceController;
/**
 * Class KategoriPulsa
 * @note Resource untuk mengelola data m_kategori_pulsa
 * @dataDescription m_kategori_pulsa
 * @package App\Controllers
 */
class KategoriPulsa extends MyResourceController
{
    protected $modelName = 'App\Models\Pulsa\KategoriPulsaModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'kelompok' => ['label' => 'kelompok', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'kelompok' => ['label' => 'kelompok', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

   public function kelompok(){
        $this->applyQueryFilter();
        if ($this->request->getGet("with")) {
            $tableName = $this->model->getTableName();
            $this->model->select($tableName . ".*");
            $this->model->with($this->request->getGet("with"));
        }

        $data = $this->model->find();
        $group = [];
        foreach ($data as $key => $value) {
            $group[$value->kelompok][] = $value;
        }

        $kelompok = [];
        foreach ($group as $groups => $value) {
            $kelompok[] = [
                'kelompok' => $groups,
                'kategori' => $value
            ];
        }

        return $this->response($kelompok);
    }
}
