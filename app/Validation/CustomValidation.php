<?php

namespace App\Validation;

use App\Models\ProdukModel;
use Exception;

class CustomValidation
{
    public function valid_array($post){
        return is_array($post);
    }

    public function json_array_not_empty(string $string, string $fields, array $data)
    {
        $json = @json_decode($string, true);
        $status = ($json !== false);
        if ($status) {
            return (isset($json[$fields]) && is_array($json[$fields]) && count($json[$fields]) > 0);
        }
        return $status;
    }

    /**
     * Cek Data terdapat dalam baris pada suatu table
     * ex validation : in_table[nama_table,nama_field,groupDb]
     * Note : groupDb bersifat opsional
     * @param $string
     * @param string $fields
     * @param array $data
     * @param string|null $error
     * @return bool
     */
    public function in_table($string, string $fields, array $data, string &$error = null)
    {
        if ($string) {
            $fields = explode(',', $fields);
            $dbGroup = $fields[2] ?? null;
            $db = \Config\Database::connect($dbGroup);
            $builder = $db->table($fields[0]);
            $result = $builder->where($fields[1], $string)->countAllResults() > 0;
            if ($result === false) {
                $showError = $fields[3] ?? 1;
                if ($showError == '1')
                    $error = "$fields[1] dengan nilai $string tidak terdapat di table $fields[0]";
                return false;
            }
        }
        return true;
    }

    public function cek_kode_sudah_digunakan($string, string $fields, array $data, string &$error = null)
    {
        $idSekarang = $string;
        $idSebelumnya = $data[$fields];
        
        if($idSebelumnya != $idSekarang){
            $productModel = new ProdukModel();
            $findData = $productModel->find($idSekarang);

            if(!empty($findData)){
                $error = "Kode produk $idSekarang sudah digunakan.";
                return false;
            }
        }

        return true;
        if (isset($data[$fields]) && $data[$fields] == 'fisik') {
            if ($string != '') {
               
                $nilai = explode(',', '1');

                if (in_array($string, $nilai)) {
                    return true;
                } else {
                    $error = "Jumlah Legalisir tidak tersedia.";
                    return false;
                }
            } else {
                $error = "Jumlah Legalisir wajib diisi.";
                return false;
            }
        }
        return true;
    }

    // public function check_jumlah_legalisir($string, string $fields, array $data, string &$error = null)
    // {
    //     if (isset($data[$fields]) && $data[$fields] == 'fisik') {
    //         if ($string != '') {
               
    //             $nilai = explode(',', '1');

    //             if (in_array($string, $nilai)) {
    //                 return true;
    //             } else {
    //                 $error = "Jumlah Legalisir tidak tersedia.";
    //                 return false;
    //             }
    //         } else {
    //             $error = "Jumlah Legalisir wajib diisi.";
    //             return false;
    //         }
    //     }
    //     return true;
    // }

}
