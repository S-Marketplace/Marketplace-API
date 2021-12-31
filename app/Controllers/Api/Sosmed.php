<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Sosmed extends BaseResourceController
{
	protected $modelName = 'App\Models\SosmedModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
