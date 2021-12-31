<?php

namespace App\Validation;

use App\Models\JadwalUmumModel;

class CustomValidation
{
    public function cek_hari($string, string &$error = null)
    {
        $request = \Config\Services::request();
        $model = new JadwalUmumModel();

        if ($request->getPost('id')) {
            $id = $request->getPost('id');
            $data = $model->find($id);

            if ($string != $data->hari) {
                $cek = $model->where('jduNamaHari', $string)->find();
                if ($cek) {
                    $error = "Hari yang dipilih sudah ada";
                    return false;
                }
                return true;
            }
        } else {
            $cek = $model->where('jduNamaHari', $string)->find();
            if ($cek) {
                $error = "Hari yang dipilih sudah ada";
                return false;
            }
            return true;
        }
    }
}
