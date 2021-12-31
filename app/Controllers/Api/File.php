<?php


namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\MyDownloadResponse;
use CodeIgniter\Config\Config;

class File extends BaseController
{
    public function __construct()
    {
        $this->pathFotoBeranda = Config::get("App")->uploadPath.'foto_beranda';
        $this->pathFotoMekanisme = Config::get("App")->uploadPath.'foto_mekanisme';
        $this->pathFotoSetting = Config::get("App")->uploadPath.'foto_setting';
        $this->pathFotoUserIntegrasi = Config::get("App")->uploadPath.'foto_user_integrasi';
    }

    public function fotoBeranda($filename){
        return $this->_getFile($this->pathFotoBeranda, $filename);
    }

    public function fotoMekanisme($filename){
        return $this->_getFile($this->pathFotoMekanisme, $filename);
    }

    public function fotoSetting($filename){
        return $this->_getFile($this->pathFotoSetting, $filename);
    }

    public function fotoUserIntegrasi($filename){
        return $this->_getFile($this->pathFotoUserIntegrasi, $filename);
    }

    private function _getFile($path, $filename)
    {
        //Sanitasi filename dari backslash folder
        $filename = basename($filename);
        $fullpath = $path . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($fullpath)) {
            $file = new \CodeIgniter\Files\File($fullpath);
            if (!in_array($file->getMimeType(), [
                    'image/png', 
			        'image/pjpeg',
                    'image/jpg', 
                    'image/jpeg', 
                    'application/pdf', 
                    'application/excel', 
                    'application/msword', 
                    'application/powerpoint',
                    'application/vnd.ms-excel',
                    'application/msexcel',
                    'application/x-msexcel',
                    'application/x-ms-excel',
                    'application/x-excel',
                    'application/x-dos_ms_excel',
                    'application/xls',
                    'application/x-xls',
                    'application/excel',
                    'application/download',
                    'application/vnd.ms-office',
                    'application/vnd.ms-powerpoint',
                    'application/powerpoint',
                    'application/vnd.ms-office',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/x-zip',
                    'application/zip',
                    'application/xml',
                    'text/xsl',
                    'text/xml',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/zip',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel',
			        'application/octet-stream',

                ])) {
                return $this->response->setJSON([
                    'code' => 403,
                    'message' => 'Tipe File dilarang'
                ]);
            }
            $download = new MyDownloadResponse($fullpath, true);
            return $download->notForce();
        } else {
            return $this->response->setJSON([
                'code' => 404,
                'message' => 'File not found'
            ]);
        }
    }
}
