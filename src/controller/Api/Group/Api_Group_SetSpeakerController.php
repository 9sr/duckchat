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
        throw new ZalyException($errInfo);
    }
}