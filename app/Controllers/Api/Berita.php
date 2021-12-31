<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Berita extends BaseResourceController
{
	protected $modelName = 'App\Models\BeritaModel';
    protected $format    = 'json';

	protected $rulesCreate = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'link' => ['label' => 'Link', 'rules' => 'required'],
        'icon' => ['label' => 'Icon', 'rules' => 'required'],
    ];
}
