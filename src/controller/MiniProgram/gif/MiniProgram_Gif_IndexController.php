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
        if ($method == 'POST') {
            try{
                $type = isset($_POST['type']) ? $_POST['type'] :"send_msg";
                switch ($type) {
                    case "send_msg" :
                        $this->sendWebMessage($_POST);
                        break;
                    case "add_gif":
                        $this->addGif($_POST);
                }
                $this->ctx->Wpf_Logger->error($tag, "post msg =" . json_encode($_POST));
                echo json_encode(["errorCode" => "success", "errorInfo" => ""]);
            }catch (Exception $ex) {
                echo json_encode(["errorCode" => "error.alert", 'errorInfo' => $ex->getMessage()]);
            }
        } else {
            $pageUrl = $_COOKIE['duckchat_page_url'];
            $pageUrl = parse_url($pageUrl);
            parse_str($pageUrl['query'], $queries);
            $x = $queries['x'];
            list($type, $toId) = explode("-", $x);
            if($toId == $this->userId) {
                return;
            }

            if($type == $this->groupType) {
                $roomType = "MessageRoomGroup";
            }elseif($type == $this->u2Type) {
                $roomType = "MessageRoomU2";
            }

            $results = [
                "roomType" => $roomType,
                "toId" => $toId,
                "fromUserId" => $this->userId,
            ];

            $gifs = $this->ctx->SiteUserGifTable->getGifByUserId($this->userId, 0, $this->limit);
            foreach ($gifs as $key => $gif) {
                $url = "./index.php?action=http.file.gifDownload&gifId=".$gif['gifId'];
                $gif['gifId'] = ZalyHelper::getFullReqUrl($url);
                $gifs[$key] = $gif;
            }

            $results['gifs'] = $gifs;
            $results['gifs'] = json_encode($results['gifs']);
            echo $this->display("miniProgram_gif_index", $results);
            return;
        }
    }
    private function sendWebMessage($msg)
    {

        $sendMsg  = $msg['message'];
        $roomType = $sendMsg['roomType'] == "MessageRoomU2" ? \Zaly\Proto\Core\MessageRoomType::MessageRoomU2 : \Zaly\Proto\Core\MessageRoomType::MessageRoomGroup;

        if($roomType == \Zaly\Proto\Core\MessageRoomType::MessageRoomU2) {
            $userRelationReq = new \Zaly\Proto\Plugin\DuckChatUserRelationRequest();
            $userRelationReq->setUserId($this->userId);
            $userRelationReq->setOppositeUserId($sendMsg['toUserId']);
            $response = $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->userRelationAction, $userRelationReq);

            if($response->getRelationType() != \Zaly\Proto\Core\FriendRelationType::FriendRelationFollow) {
                $errorCode = $this->zalyError->errorFriend;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                throw new Exception($errorInfo);
            }

            $userRelationReq = new \Zaly\Proto\Plugin\DuckChatUserRelationRequest();
            $userRelationReq->setUserId($sendMsg['toUserId']);
            $userRelationReq->setOppositeUserId($this->userId);
            $response = $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->userRelationAction, $userRelationReq);

            if($response->getRelationType() != \Zaly\Proto\Core\FriendRelationType::FriendRelationFollow) {
                $errorCode = $this->zalyError->errorFriend;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                throw new Exception($errorInfo);
            }

        }

        $webMsg = new \Zaly\Proto\Core\WebMessage();

        $webMsg->setWidth($sendMsg['web']['width']);
        $webMsg->setHeight($sendMsg['web']['height']);
        $webMsg->setCode($sendMsg['web']['code']);
        $webMsg->setHrefURL($sendMsg['web']['hrefURL']);
        $webMsg->setTitle($this->title);

        $message = new \Zaly\Proto\Core\Message();
        $message->setMsgId($sendMsg['msgId']);
        $message->setType(\Zaly\Proto\Core\MessageType::MessageWeb);
        $message->setTimeServer($sendMsg['timeServer']);
        $message->setWeb($webMsg);
        $message->setRoomType($roomType);
        $message->setFromUserId($this->userId);
        if($roomType == \Zaly\Proto\Core\MessageRoomType::MessageRoomU2) {
            $message->setToUserId($sendMsg['toUserId']);
        } else {
            $message->setToGroupId($sendMsg['toGroupId']);
        }

        $duckchatReqData = new \Zaly\Proto\Plugin\DuckChatMessageSendRequest();
        $duckchatReqData->setMessage($message);
        $this->requestDuckChatInnerApi($this->gifMiniProgramId, $this->action, $duckchatReqData);
    }

    public function addGif($data)
    {
        $gifId = $data['gifId'];
        $data = [
            'userId' => $this->userId,
            'gifId' => $gifId,
            'addTime' => ZalyHelper::getMsectime()
        ];
        $this->ctx->SiteUserGifTable->addGif($data);
    }
}