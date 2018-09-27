<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 05/09/2018
 * Time: 2:27 PM
 */

class MiniProgram_Gif_IndexController extends  MiniProgramController
{

    private $gifMiniProgramId = 104;
    private $action = "duckChat.message.send";
    private $groupType = "g";
    private $u2Type = "u";
    private $userRelationAction = "duckChat.user.relation";
    private $limit=30;
    private $title = "Gif扩展";
    private $roomType="";
    private $toId;

    public function getMiniProgramId()
    {
        return $this->gifMiniProgramId;
    }

    public function requestException($ex)
    {
        $this->showPermissionPage();
    }

    public function preRequest()
    {
    }

    public function doRequest()
    {
        header('Access-Control-Allow-Origin: *');
        $method = $_SERVER['REQUEST_METHOD'];
        $tag = __CLASS__ ."-".__FUNCTION__;

        $pageUrl = $_COOKIE['duckchat_page_url'];
        $pageUrl = parse_url($pageUrl);
        parse_str($pageUrl['query'], $queries);
        $x = $queries['x'];
        list($type, $this->toId) = explode("-", $x);
        if($this->toId == $this->userId) {
            return;
        }

        if($type == $this->groupType) {
            $this->roomType = \Zaly\Proto\Core\MessageRoomType::MessageRoomGroup;
        }elseif($type == $this->u2Type) {
            $this->roomType = \Zaly\Proto\Core\MessageRoomType::MessageRoomU2;
        }

        if ($method == 'POST') {
            try{
                $type = isset($_POST['type']) ? $_POST['type'] :"send_msg";
                switch ($type) {
                    case "send_msg" :
                        $this->sendWebMessage($_POST);
                        break;
                    case "add_gif":
                        $this->addGif($_POST);
                        break;
                    case "del_gif":
                        $this->delGif($_POST);
                        break;
                }
                $this->ctx->Wpf_Logger->error($tag, "post msg =" . json_encode($_POST));
                echo json_encode(["errorCode" => "success", "errorInfo" => ""]);
            }catch (Exception $ex) {
                echo json_encode(["errorCode" => "error.alert", 'errorInfo' => $ex->getMessage()]);
            }
        } else {
            $results = [
                "roomType" => $this->roomType,
                "toId" => $this->toId,
                "fromUserId" => $this->userId,
            ];

            $gifs = $this->ctx->SiteUserGifTable->getGifByUserId($this->userId, 0, $this->limit);
            foreach ($gifs as $key => $gif) {
                $url = "./index.php?action=http.file.downloadGif&gifId=".$gif['gifId'];
                $gif['gifUrl'] = ZalyHelper::getFullReqUrl($url);
                $gifs[$key] = $gif;
            }

            $results['gifs'] = $gifs;
            $results['gifs'] = json_encode($results['gifs']);
            echo $this->display("miniProgram_gif_index", $results);
            return;
        }
    }
    private function sendWebMessage($data)
    {
        $gifId = $data['gifId'];


        $roomType = $this->roomType ? \Zaly\Proto\Core\MessageRoomType::MessageRoomU2 : \Zaly\Proto\Core\MessageRoomType::MessageRoomGroup;

        if($roomType == \Zaly\Proto\Core\MessageRoomType::MessageRoomU2) {
            $userRelationReq = new \Zaly\Proto\Plugin\DuckChatUserRelationRequest();
            $userRelationReq->setUserId($this->userId);
            $userRelationReq->setOppositeUserId($this->toId);
            $response = $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->userRelationAction, $userRelationReq);

            if($response->getRelationType() != \Zaly\Proto\Core\FriendRelationType::FriendRelationFollow) {
                $errorCode = $this->zalyError->errorFriend;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                throw new Exception($errorInfo);
            }

            $userRelationReq = new \Zaly\Proto\Plugin\DuckChatUserRelationRequest();
            $userRelationReq->setUserId($this->toId);
            $userRelationReq->setOppositeUserId($this->userId);
            $response = $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->userRelationAction, $userRelationReq);

            if($response->getRelationType() != \Zaly\Proto\Core\FriendRelationType::FriendRelationFollow) {
                $errorCode = $this->zalyError->errorFriend;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                throw new Exception($errorInfo);
            }

        }

        $gifInfo = $this->ctx->SiteUserGifTable->getGifByGifId($gifId);
        $url = "./index.php?action=http.file.downloadGif&gifId=".$gifInfo['gifId'];
        $gifUrl = ZalyHelper::getFullReqUrl($url);
        $webCode = '<!DOCTYPE html> <html> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"></head> <body> <img src="'.$gifUrl.'" width="100%" > </body> </html>';

        $webHrefUrl = "./index.php?action=miniProgram.gif.add&gifId=".$gifInfo['gifId'];
        $webMsg = new \Zaly\Proto\Core\WebMessage();

        $webMsg->setWidth($gifInfo['width']);
        $webMsg->setHeight($gifInfo['height']);
        $webMsg->setCode($webCode);
        $webMsg->setHrefURL($webHrefUrl);
        $webMsg->setTitle($this->title);

        $messageId = ZalyHelper::getMsgId($this->roomType, $this->toId);

        $message = new \Zaly\Proto\Core\Message();
        $message->setMsgId($messageId);
        $message->setType(\Zaly\Proto\Core\MessageType::MessageWeb);
        $message->setTimeServer(ZalyHelper::getMsectime());
        $message->setWeb($webMsg);
        $message->setRoomType($roomType);
        $message->setFromUserId($this->userId);
        if($roomType == \Zaly\Proto\Core\MessageRoomType::MessageRoomU2) {
            $message->setToUserId($this->toId);
        } else {
            $message->setToGroupId($this->toId);
        }

        $duckchatReqData = new \Zaly\Proto\Plugin\DuckChatMessageSendRequest();
        $duckchatReqData->setMessage($message);
        $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->action, $duckchatReqData);
    }

    public function addGif($data)
    {
        $gifUrl = $data['gifId'];
        $gifId = md5($gifUrl);
        $data = [
            'userId'  => $this->userId,
            'gifId'   => $gifId,
            'gifUrl'  => $gifUrl,
            'width'   => $data['width'],
            'height'  => $data['height'],
            'addTime' => ZalyHelper::getMsectime()
        ];
        $this->ctx->SiteUserGifTable->addGif($data);
    }

    public function delGif($data)
    {
        $gifId = $data['gifId'];
        return $this->ctx->SiteUserGifTable->delGif($this->userId, $gifId);
    }
}