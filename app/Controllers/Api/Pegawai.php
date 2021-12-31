<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Pegawai extends BaseResourceController
{
	protected $modelName = 'App\Models\PegawaiModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
