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
    private $resetPassword = "api.passport.passwordModifyPassword";

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

                $siteLoginName = $this->loginName;
                if($siteLoginName != $loginName) {
                    $errorCode = $this->zalyError->errorUpdatePasswordLoginName;
                    $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                    echo json_encode(["errCode" => $errorInfo]);
                    return;
                }

                $this->modifyPassportPassword($loginName);
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

    private function modifyPassportPassword($loginName)
    {
        $tag = __CLASS__ . "-". __FUNCTION__;

        try{

            $sessionClearRequest = new \Zaly\Proto\Plugin\DuckChatSessionClearRequest();
            $sessionClearRequest->setUserId($this->userId);
            $sessionClearUrl = "/index.php?action=" . $this->sessionClear . "&body_format=base64pb&miniProgramId=".$this->passporAccountPluginId;
            $sessionClearUrl = ZalyHelper::getFullReqUrl($sessionClearUrl);
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
        $transportData->setHeader(["_".\Zaly\Proto\Core\TransportDataHeaderKey::HeaderUserClientLang => $this->language]);
        $data = $transportData->serializeToString();
        $data = base64_encode($data);

        $pluginProfile =  $this->getMiniProgramProfile($this->passporAccountPluginId);
        $authKey = $pluginProfile['authKey'];
        $data = $this->ctx->ZalyAes->encrypt($data, $authKey);

        $result = $this->ctx->ZalyCurl->request("post", $url, $data);
        $authKey = $pluginProfile['authKey'];
        $result = $this->ctx->ZalyAes->decrypt($result, $authKey);
        $result = base64_decode($result);

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