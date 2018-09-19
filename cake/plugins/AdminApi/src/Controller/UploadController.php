<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Cake\Filesystem\Folder;
use App\Lib\FileUpload;
use Cake\Routing\Router;

/**
 * Upload Controller
 *
 *
 */
class UploadController extends AppController
{
    /*
    * 文件上传公共方法
    *
    * */
    public function fileUpload()
    {
        if (!empty($this->getRequest()->getData('file'))) {
            $filePath = 'files/';
            $this->comm($filePath);
        }
        header('HTTP/1.1 403 Forbidden');
        exit;
    }

    private function comm($filePath)
    {
        $folder = new Folder(WWW_ROOT);
        if (!is_dir($filePath)) {
            $folder->create($filePath);
        }
        $filePath = $filePath . date('Ymd');
        $uploadPath = WWW_ROOT . $filePath;
        $upload = new FileUpload(array(
            'filePath' => $uploadPath,
            'allowType' => array('jpg','gif','png','bmp','pdf','doc','docx','xls','xlsx','zip','rar','7z')
        ));

        if ($upload->uploadFile($this->getRequest()->getData('file')) == 0) {
            $fileName = $upload->getNewFileName();
            $this->apiResponse([
                'filename' => $filePath . '/' . $fileName,
                'fullPath' => Router::url($filePath . '/' . $fileName, true)
            ], 200, '上传成功!', false);
        }
        header('HTTP/1.1 403 Forbidden');
        exit;
    }


    /**
     * 图片上传公用方法
     */
    public function picUpload()
    {
        if (!empty($this->getRequest()->getData('file'))) {
            $filePath = 'files/';
            $folder = new Folder(WWW_ROOT);
            if (!is_dir($filePath)) {
                $folder->create($filePath);
            }
            $filePath = $filePath . date('Ymd');
            $uploadPath = WWW_ROOT . $filePath;
            $upload = new FileUpload(array(
                'filePath' => $uploadPath,
                'allowType' => array('jpg','gif','png','bmp')
            ));

            if ($upload->uploadFile($this->getRequest()->getData('file')) == 0) {
                $fileName = $upload->getNewFileName();
                $this->apiResponse([
                    'filename' => $filePath . '/' . $fileName,
                    'fullPath' => Router::url($filePath . '/' . $fileName, true)
                ], 200, '上传成功!', false);
            }
        }
        if (!empty($this->getRequest()->getData('ajax'))) {
            $this->apiResponse([], 300, '上传失败', false);
        }
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
}
