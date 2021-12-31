<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class FotoBeranda extends BaseResourceController
{
	protected $modelName = 'App\Models\FotoBerandaModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
