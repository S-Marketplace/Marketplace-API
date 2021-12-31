<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Napi extends BaseResourceController
{
	protected $modelName = 'App\Models\NapiModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
