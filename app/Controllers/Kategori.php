<?php namespace App\Controllers;

use App\Controllers\MyResourceController;
/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class Kategori extends MyResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'alUsrId' => ['label' => 'alUsrId', 'rules' => 'required'],
       'alNama' => ['label' => 'alNama', 'rules' => 'required'],
       'alDeletedAt' => ['label' => 'alDeletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'alUsrId' => ['label' => 'alUsrId', 'rules' => 'required'],
       'alNama' => ['label' => 'alNama', 'rules' => 'required'],
       'alDeletedAt' => ['label' => 'alDeletedAt', 'rules' => 'required'],
   ];
}
