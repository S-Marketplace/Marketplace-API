<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class LayananPengaduan extends BaseResourceController
{
	protected $modelName = 'App\Models\LayananPengaduanModel';
    protected $format    = 'json';

	protected $rulesCreate = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'link' => ['label' => 'Link', 'rules' => 'required'],
        'icon' => ['label' => 'Icon', 'rules' => 'required'],
    ];
}
