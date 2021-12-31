<?php


namespace App\Controllers;


use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use App\Libraries\MyDownloadResponse;

class File extends BaseController
{
    public function get($dir, $filename)
    {
        //Sanitasi filename dari backslash folder
        $filename = basename($filename);
        $fullpath = Config::get("App")->uploadPath . "$dir" . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($fullpath)) {
            $file = new \CodeIgniter\Files\File($fullpath);
            if (!in_array($file->getMimeType(), [
                'image/png', 'image/jpg', 'image/jpeg', 'application/pdf'
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
