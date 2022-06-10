<?php


namespace App\Controllers;


use Bepsvpt\Blurhash\BlurHash;
use CodeIgniter\Config\Config;
use App\Controllers\BaseController;
use App\Libraries\MyDownloadResponse;

class File extends BaseController
{
    const NOT_EXIST_IMAGE = WRITEPATH . "404.jpg";

    public function get($dir, $filename)
    {
        $type = $this->request->getGet('type') ?? 'file';
        $size = $this->request->getGet('size');

        $filename = basename($filename);
        $path = $fullpath = Config::get("App")->uploadPath . "$dir" . DIRECTORY_SEPARATOR;
        $fullpath = $path . $filename;

        if (file_exists($fullpath)) {
            $file = new \CodeIgniter\Files\File($fullpath);
            // Resize Image
            if (!empty($size)) {
                $realFileName = explode('.', $file->getFilename())[0];
                $fileName = $realFileName . '_' . $size . '.' . $file->getExtension();
                $newCompressPath = $path . $realFileName;
                $newCompressPathFile = $newCompressPath . DIRECTORY_SEPARATOR . $fileName;
                
                // Create folder thumbnail
                if (!is_dir($newCompressPath)) {
                    mkdir($newCompressPath, 0777, true);
                }
    
                // Compress if file not exist
                if (!file_exists($newCompressPathFile)) {
                    $image = \Config\Services::image()
                        ->withFile($file)
                        ->resize($size, $size, true, 'height')
                        ->save($newCompressPathFile);
                }
    
                $fullpath = $newCompressPathFile;
            }
        }

        if ($type == 'file') {
            //Sanitasi filename dari backslash folder
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
                $filename = self::NOT_EXIST_IMAGE;
                if (file_exists($filename)) {
                    $mime = mime_content_type($filename); 
                    header('Content-Length: ' . filesize($filename)); 
                    header("Content-Type: $mime");  
                    header('Content-Disposition: inline; filename="' . $filename . '";'); 
                    readfile($filename); 
                    exit();
                }

                return $this->response->setJSON([
                    'code' => 404,
                    'message' => 'File not found'
                ]);
            }
        } else if ($type == 'blur') {
            // Blurhash image
            if (file_exists($fullpath)) {
                $file = new \CodeIgniter\Files\File($fullpath);
                $image = imagecreatefromstring(file_get_contents($file));
                $blurHash = new BlurHash(4, 3);
                echo $blurHash->encode($image);
            } else {
                $image = imagecreatefromstring(file_get_contents(self::NOT_EXIST_IMAGE));
                $blurHash = new BlurHash(4, 3);
                echo $blurHash->encode($image);
            }
        }
    }

    /**
     * Experimental
     * 
     * Deleted all file not used from database
     *
     * @param [type] $dir
     * @return void
     */
    public function checkNotUsedFile($dir){
        $usedFile = [];

        if(!empty($usedFile)){
            $path  = Config::get("App")->uploadPath . "$dir" . DIRECTORY_SEPARATOR;
            $files = scandir($path);
            $mergePath = array_flip($files);
            unset($mergePath['.'],$mergePath['..']);
    
            foreach ($mergePath as $fileName => $value) {
                if(!preg_grep('~' . $fileName . '~', $usedFile)){
                    try {
                        unlink($path . $fileName);
                    } catch (\Throwable $th) {
                        $this->deleteDirectory($path . $fileName);
                    }
                }
            }
        }
    }

    private function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
    }
}
