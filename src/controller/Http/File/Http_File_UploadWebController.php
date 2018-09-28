<?php

/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/07/2018
 * Time: 8:51 PM
 */

class Http_File_UploadWebController extends \HttpBaseController
{
    public function index()
    {
        $originFileName = "";

        try{
            $tag = __CLASS__.'-'.__FUNCTION__;
            $isMessageAttachment = isset( $_POST['isMessageAttachment']) ?  $_POST['isMessageAttachment'] : false;

            $fileType = isset( $_POST['fileType']) ?  $_POST['fileType'] : \Zaly\Proto\Core\FileType::FileInvalid;
            if($fileType == "FileInvalid") {
                throw new Exception( "文件类型不符合要求，上传失败");
            }
            $file = $_FILES['file'];
            $this->ctx->Wpf_Logger->error($tag, "shaoye files info =" . json_encode($_FILES));

            if($file['error'] != UPLOAD_ERR_OK) {
                throw new Exception("上传失败");
            }

            switch ($fileType) {
                case \Zaly\Proto\Core\FileType::FileImage:
                case \Zaly\Proto\Core\FileType::FileAudio:
                    $originFileName = $this->saveFile($file, \Zaly\Proto\Core\FileType::FileImage);
                    break;
                case \Zaly\Proto\Core\FileType::FileDocument:
                    $originFileName = $this->saveFile($file, \Zaly\Proto\Core\FileType::FileDocument);
                    break;
            }
            $fileInfo = ["fileId" => $originFileName];
            echo json_encode($fileInfo);
        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "shaoye error msg =" . $ex->getMessage());
            $fileInfo = ["fileId" => $originFileName];
            echo json_encode($fileInfo);
        }
    }

    private function saveFile($file, $type)
    {
        $tmpName  = $file['tmp_name'];
        $tmpFile = file_get_contents($tmpName);

        if($type == \Zaly\Proto\Core\FileType::FileDocument) {
            $name = $file['name'];
            $ext = array_pop(explode(".", $name));
            $fileName = $this->ctx->File_Manager->saveDocument($tmpFile, $ext);
        } else{
            $fileName = $this->ctx->File_Manager->saveFile($tmpFile);
        }
        return $fileName;
    }

}

