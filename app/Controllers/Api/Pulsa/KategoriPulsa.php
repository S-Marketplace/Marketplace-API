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
       'prefix' => ['label' => 'prefix', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'prefix' => ['label' => 'prefix', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
