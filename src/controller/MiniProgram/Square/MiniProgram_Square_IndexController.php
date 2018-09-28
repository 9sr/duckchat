<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 05/09/2018
 * Time: 2:27 PM
 */

class MiniProgram_Square_IndexController extends MiniProgramController
{

    private $squarePluginId = 199;
    private $pageSize = 12;

    public function getMiniProgramId()
    {
        return $this->squarePluginId;
    }

    public function preRequest()
    {
        //do nothing
    }

    public function doRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {

            $result = [];

            $pageNum = $_POST['pageNum'];

            $pageSize = isset($_POST['pageSize']) ? $_POST['pageSize'] : $this->pageSize;

            $this->logger->error("============", "pageNum=" . $pageNum);
            $this->logger->error("============", "pageSize=" . $pageSize);

            $userList = $this->buildUserDataList($pageNum, $pageSize);

            $this->logger->error("============", "result=" . var_export($userList, true));

            if (!empty($userList)) {
                $result['loading'] = true;
                $result['data'] = $userList;
            } else {
                $result['loading'] = false;
            }

            echo json_encode($result);
        } else {
            //request
            $pageSize = $this->pageSize;
            if (isset($_GET["pageSize"])) {
                $pageSize = $_GET["pageSize"];
            }

            $userList = $this->buildUserDataList(1, $pageSize);

            $params = [
                'userList' => $userList,
            ];
            echo $this->display("miniProgram_square_index", $params);
        }
        return;
    }

    public function requestException($ex)
    {
//        $this->showPermissionPage();
    }


    private function buildUserDataList($pageNum, $pageSize)
    {
        $userList = $this->getSiteUserList($this->userId, $pageNum, $pageSize);

        if (!empty($userList)) {
            foreach ($userList as $i => $user) {

                if ($this->userId == $user['userId']) {
                    unset($userList[$i]);
                    continue;
                }

                $friendId = $user['friendId'];

                if (isset($friendId)) {
                    $user['isFollow'] = true;
                }
                $userList[$i] = $user;
            }
        }
        return $userList;
    }

    private function getSiteUserList($userId, $pageNum, $pageSize)
    {
        $result = $this->ctx->SiteUserTable->getSiteUserListWithRelation($userId, $pageNum, $pageSize);
        return $result;
    }
}