<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 08/09/2018
 * Time: 10:25 AM
 */

class MiniProgram_Passport_AccountController extends MiniProgramController
{
    private $passporAccountPluginId = 105;
    private $errorCode = "";
    private $sessionClear  = "duckchat.session.clear";
    private $resetPassword = "api.passport.passwordResetPassword";

    public function getMiniProgramId()
    {
        return $this->passporAccountPluginId;
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
        $tag = __CLASS__.'-'.__FUNCTION__;
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try{
            if($method == "post") {

                $loginName = $_POST['loginName'];
                $token = $_POST['token'];
                $password = $_POST['password'];

                $siteLoginName = $this->loginName;
                if($siteLoginName != $loginName) {
                    echo json_encode(["errCode" => "登录名不正确"]);
                    return;
                }
                $this->updatePassportPassword($loginName, $token, $password);
                echo json_encode(["errCode" => "success"]);
                return;
            } else {
                $this->ctx->Wpf_Logger->error($tag, "duckchat.session.clear userUd == ".$this->userId);
                echo $this->display("miniProgram_passport_account", ['passporAccountPluginId' => $this->passporAccountPluginId]);
                return;
            }
        }catch (Exception $ex) {
            $errorCode = $this->errorCode ? $this->errorCode : "修改失败";
            echo json_encode(["errCode" => $errorCode]);
            return;
        }
    }

    private function updatePassportPassword($loginName, $token, $password)
    {
        $tag = __CLASS__ . "-". __FUNCTION__;

        try{
            $updatePasswordReq = new \Zaly\Proto\Site\ApiPassportPasswordResetPasswordRequest();
            $updatePasswordReq->setLoginName($loginName);
            $updatePasswordReq->setPassword($password);
            $updatePasswordReq->setToken($token);
            $siteAddress = ZalyConfig::getConfig("siteAddress");
            $updatePasswordUrl = $siteAddress . "/index.php?action=" . $this->resetPassword . "&body_format=pb";
            $this->sendReq( $this->resetPassword, $updatePasswordUrl, $updatePasswordReq);

             $sessionClearRequest = new \Zaly\Proto\Plugin\DuckChatSessionClearRequest();
             $sessionClearRequest->setUserId($this->userId);
             $siteAddress = ZalyConfig::getConfig("siteAddress");
             $sessionClearUrl = $siteAddress . "/index.php?action=" . $this->sessionClear . "&body_format=pb&miniProgramId=".$this->passporAccountPluginId;
             $this->sendReq($this->sessionClear, $sessionClearUrl, $sessionClearRequest);

        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, $ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }

    private function sendReq($action, $url, $dataReq)
    {

        $anyBody = new \Google\Protobuf\Any();
        $anyBody->pack($dataReq);

        $transportData = new \Zaly\Proto\Core\TransportData();
        $transportData->setBody($anyBody);
        $transportData->setAction($action);
        $data = $transportData->serializeToString();

        $pluginProfile =  $this->getMiniProgramProfile($this->passporAccountPluginId);

        if($action == $this->sessionClear) {
            $authKey = $pluginProfile['authKey'];
            $data = $this->ctx->ZalyAes->encrypt($data, $authKey);
        }

        $result = $this->ctx->ZalyCurl->request("post", $url, $data);

        if($action == $this->sessionClear) {
            $authKey = $pluginProfile['authKey'];
            $result = $this->ctx->ZalyAes->decrypt($data, $authKey);
        }

        //解析数据
        $transportData = new \Zaly\Proto\Core\TransportData();
        $transportData->mergeFromString($result);

        $header = $transportData->getHeader();

        foreach ($header as $key => $val) {
            if ($key == "_1" && $val != "success") {
                $this->errorCode = $header["_2"];
                throw new Exception(" failed");
            }
        }
    }

    private function getMiniProgramProfile($miniProgramId)
    {
        $miniProgramProfile = $this->ctx->SitePluginTable->getPluginById($miniProgramId);

        if (!empty($miniProgramProfile)) {

            if (empty($miniProgramProfile['authKey'])) {
                if (empty($authKey)) {
                    $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_PLUGIN_PLBLIC_KEY);
                    $miniProgramProfile['authKey'] = $config[SiteConfig::SITE_PLUGIN_PLBLIC_KEY];
                }
            }

        }

        return $miniProgramProfile;
    }
}