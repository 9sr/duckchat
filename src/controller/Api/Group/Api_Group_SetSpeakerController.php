<?php

/**
 * Class Api_Group_SetSpeakerController
 * @author SAM<an.guoyue254@gmail.com>
 */
class Api_Group_SetSpeakerController extends Api_Group_BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiGroupSetSpeakerRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiGroupSetSpeakerResponse';


    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiGroupSetSpeakerRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $response = new Zaly\Proto\Site\ApiGroupSetSpeakerResponse();
        try {
            $userId = $this->userId;
            $groupId = $request->getGroupId();
            $setType = $request->getSetType();
            $setSpeakers = $request->getSpeakerUserIds();

            if (empty($groupId)) {
                $this->throwZalyException(ZalyError::$errorGroupEmptyId);
            }

            //group admin can set speaker
            if ($this->isGroupAdmin($groupId)) {
                $this->throwZalyException(ZalyError::$errorGroupPermission);
            }

            $groupInfo = $this->getGroupInfo($groupId);

            $groupSpeakers = $groupInfo['speakers'];

            switch ($setType) {
                case \Zaly\Proto\Site\SetSpeakerType::AddSpeaker:
                    $latestSpeakers = $this->addGroupSpeakers($groupId, $groupSpeakers, $setSpeakers);
                    $response->setSpeakerUserIds($latestSpeakers);
                    break;
                case \Zaly\Proto\Site\SetSpeakerType::RemoveSpeaker:
                    $latestSpeakers = $this->removeGroupSpeakers($groupId, $groupSpeakers, $setSpeakers);
                    $response->setSpeakerUserIds($latestSpeakers);
                    break;
                case \Zaly\Proto\Site\SetSpeakerType::CloseSpeaker:
                    $this->closeGroupSpeaker($groupId, $groupSpeakers);
                    break;
            }

            $this->proxyGroupNotice($groupId, $this->userId, $response->getSpeakerUserIds(), $setType);

            $this->returnSuccessRPC($response);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
            $this->returnErrorRPC(new $this->classNameForResponse(), $e);
        }
    }


    private function addGroupSpeakers($groupId, $groupSpeakers, $setSpeakers)
    {
        if (empty($groupSpeakers)) {
            $groupSpeakers = $setSpeakers;
        } else {
            $groupSpeakers = array_merge($groupSpeakers, $setSpeakers);
        }

        $result = $this->updateGroupSpeakers($groupId, $groupSpeakers);

        if (!$result) {
            throw new Exception("add group speakers fail");
        }

        return $groupSpeakers;
    }

    private function removeGroupSpeakers($groupId, $groupSpeakers, $setSpeakers)
    {
        if (empty($groupSpeakers)) {
            return [];
        }

        $groupSpeakers = array_diff($groupSpeakers, $setSpeakers);

        $result = $this->updateGroupSpeakers($groupId, $groupSpeakers);

        if (!$result) {
            throw new Exception("remove group speakers fail");
        }

        return $groupSpeakers;
    }

    private function closeGroupSpeaker($groupId)
    {
        if (empty($groupSpeakers)) {
            return true;
        }

        $result = $this->updateGroupSpeakers($groupId);

        if (!$result) {
            throw new Exception("close group speakers fail");
        }

        return true;
    }

    private function updateGroupSpeakers($groupId, array $speakers = [])
    {
        if (empty($speakerList)) {
            $speakers = "";
        } else {
            $speakers = implode(",", $speakers);
        }
        $data = [
            'speakers' => $speakers,
        ];
        $where = [
            'groupId' => $groupId,
        ];
        return $this->ctx->SiteGroupTable->updateGroupInfo($where, $data);
    }

    private function throwZalyException($errCode)
    {
        $errInfo = ZalyError::getErrorInfo2($errCode, $this->language);
        throw new ZalyException($errCode, $errInfo);
    }


    private function proxyGroupNotice($groupId, $groupAdminId, $speakeIds, $setType)
    {
        $noticeText = $this->buildGroupNotice($groupAdminId, $speakeIds, $setType);
        $this->logger->error("=============", "noticeText=" . $noticeText);

        $this->ctx->Message_Client->proxyGroupNoticeMessage($groupAdminId, $groupId, $noticeText);
    }

    private function buildGroupNotice($groupAdminId, $speakerIds, $setType)
    {

        $nameBody = "";

        if (isset($groupAdminId)) {
            $name = $this->getUserName($groupAdminId);
            if ($name) {
                $nameBody .= $name;
            }
        }

        if ($setType == Zaly\Proto\Site\SetSpeakerType::RemoveSpeaker) {
            $nameBody .= " 关闭了";
        } elseif ($setType == Zaly\Proto\Site\SetSpeakerType::CloseSpeaker) {
            $nameBody .= " 关闭了发言者功能";
            return $nameBody;
        } else {//
            $nameBody .= " 设置";
        }

        if (empty($speakerIds)) {
            return false;
        }

        foreach ($speakerIds as $num => $userId) {

            $name = $this->getUserName($userId);

            if ($name) {
                if ($num == 0) {
                    $nameBody .= $name;
                } else {
                    $nameBody .= "," . $name;
                }
            }

        }

        if ($setType == Zaly\Proto\Site\SetSpeakerType::RemoveSpeaker) {
            $nameBody .= " 发言人身份";
        } else {//
            $nameBody .= " 为发言人";
        }

        return $nameBody;
    }

    /**
     * @param $userId
     * @return null
     */
    private function getUserName($userId)
    {
        $userInfo = $this->ctx->SiteUserTable->getUserByUserId($userId);

        if (!empty($userInfo)) {
            $userName = $userInfo['nickname'];

            if (empty($userName)) {
                $userName = $userInfo['loginName'];
            }

            return $userName;
        } else {
            return null;
        }

    }
}