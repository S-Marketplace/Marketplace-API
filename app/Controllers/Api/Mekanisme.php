<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Mekanisme extends BaseResourceController
{
	protected $modelName = 'App\Models\MekanismeModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
