<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class Banner extends BaseController
{
    protected $modelName = 'App\Models\BannerModel';
    protected $format    = 'json';

    protected $rules = [
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'gambar' => ['label' => 'gambar', 'rules' => 'required'],
       'url' => ['label' => 'url', 'rules' => 'required'],
   ];

   public function index()
   {
       return $this->template->setActiveUrl('Banner')
           ->view("Banner/index");
   }

   protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "banner_gambar";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("gambar");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['gambar'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("gambar");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['gambar'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->gambar != '') {
                unset($this->rules['gambar']);
            }
        }
        
        return parent::simpan($primary);
    }

}
