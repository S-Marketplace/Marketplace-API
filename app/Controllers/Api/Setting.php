<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseResourceController;

class Setting extends BaseResourceController
{
	protected $modelName = 'App\Models\SettingModel';
    protected $format    = 'json';

	protected $rulesCreate = [
    ];
}
