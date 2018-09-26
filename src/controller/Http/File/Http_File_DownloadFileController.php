<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/07/2018
 * Time: 8:51 PM
 */


class Http_File_DownloadFileController extends \HttpBaseController
{
    private $msgMimeType = [
        "audio/mp4",
        "audio/x-m4a",
        "video/mp4",
        'application/pdf',
        'application/x-rar-compressed',
        'application/zip',
        'application/msword',
        'application/xml',
        'application/vnd.ms-powerpoint'
    ];
    public function index()
    {
        $tag = __CLASS__."-".__FUNCTION__;
        $fileId = $_GET['fileId'];
        $mimeType = $this->ctx->File_Manager->contentType($fileId);
        $isGroupMessage = isset($_GET['isGroupMessage']) ? $_GET['isGroupMessage'] : "";
        $messageId = isset($_GET['messageId']) ? $_GET['messageId'] : "";
        $returnBase64 = $_GET['returnBase64'];
        try{
            if(in_array($mimeType, $this->msgMimeType) && !$messageId) {
                throw new Exception("it's msg attachment");
            }
            if($messageId) {
                if($isGroupMessage == true) {
                    $info = $this->ctx->SiteGroupMessageTable->checkUserCanLoadImg($messageId, $this->userId);
                    if(!$info) {
                        throw new Exception("no group premission, can't load img");
                    }
                    $this->ctx->Wpf_Logger->info($tag, "info ==" . json_encode($info) );
                } else {

                    ////TODO u2 can load img
                    $info = $this->ctx->SiteU2MessageTable->queryMessageByMsgId([$messageId]);

                    if(!$info) {
                        throw new Exception("no premission, can't load img");
                    }
                    $info = array_shift($info);

                    if($info['fromUserId'] != $this->userId && $info['toUserId'] != $this->userId) {
                        throw new Exception("no read permission, can't load img");
                    }
                }
                $contentJson = $info['content'];
                $contentArr  = json_decode($contentJson, true);
                $url = $contentArr['url'];
                if($url != $fileId) {
                    throw new Exception("get img content is not ok");
                }
            }

            $fileContent = $this->ctx->File_Manager->readFile($fileId);

            if(strlen($fileContent)<1) {
                throw new Exception("load file void");
            }
            header('Cache-Control: max-age=86400, public');
            header("Content-type:$mimeType");

            if($returnBase64) {
                echo base64_decode($fileContent);
            } else {
                echo $fileContent;
            }

        }catch (Exception $e) {
            header("Content-type:$mimeType");
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==" .$e->getMessage() );
            echo "failed";
        }
    }
}
