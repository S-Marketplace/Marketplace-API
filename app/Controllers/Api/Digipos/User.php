<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class User extends MyResourceDigipos
{
    public function getKategori()
    {
        $response = $this->digiposApi->getKategori();

        return $this->response($response);
    }

}
