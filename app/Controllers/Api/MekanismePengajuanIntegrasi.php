<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\PengajuanIntegrasiModel;

class MekanismePengajuanIntegrasi extends BaseResourceController
{
	protected $modelName = 'App\Models\MekanismePengajuanIntegrasiModel';
    protected $format    = 'json';
}
