<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>账户安全</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../../../public/css/login.css">
    <script type="text/javascript" src="../../../public/js/jquery.min.js"></script>
    <script src="../../../public/js/jquery.i18n.properties.min.js"></script>
    <script src="../../../public/js/template-web.js"></script>
    <script src="../../../public/js/zalyjsNative.js"></script>

</head>
<body>

<div class="zaly_container" >
    <div class="zaly_login zaly_site_register zaly_site_register-repwd" >
        <div class="login_input_div" >
            <div class="d-flex flex-row justify-content-center login-header " style="text-align: center;margin-top: 8rem;">
                <span class="login_phone_tip_font"  data-local-value="resetPwdTip">Reset Password</span>
            </div>

            <div class="login_name_div login_name_div_mobile">
                <image src="../../public/img/login/loginName.png" class="img"/>
                <input type="text" class="input_login_site forget_input_loginName" data-local-placeholder="loginNamePlaceholder" placeholder="Please Enter LoginName">
                <img src="../../../public/img/msg/msg_failed.png" class="img-failed forget_input_loginName_failed">
                <div class="line"></div>
            </div>


            <div class=" d-flex flex-row justify-content-left login_name_div margin-top2"  >
                <image src="../../public/img/login/code.png" class="img"/>
                <input type="text"  value="" class="input_login_site  forget_input_code" data-local-placeholder="enterVerifyCodePlaceholder"  placeholder="Please Enter Verify Code"  >
                <span class="get_verify_code" onclick="getVerifyCode()" data-local-value="getVerifyCodeTip" >Get Verify Code</span>
                <img src="../../../public/img/msg/msg_failed.png" class="img-failed forget_input_code_failed">

                <div class="line"></div>
            </div>

            <div class="login_name_div forget_input_pwd_div margin-top2"  >
                <image src="../../public/img/login/pwd.png" class="img"/>
                <input type="password" class="input_login_site forget_input_pwd"  data-local-placeholder="enterPasswordPlaceholder"  placeholder="Please Enter Password" >
                <div class="pwd_div" onclick="changeImgByClickPwd()"><image src="../../public/img/login/hide_pwd.png" class="pwd" img_type="hide"/></div>
                <img src="../../../public/img/msg/msg_failed.png" class="img-failed forget_input_pwd_failed">

                <div class="line"></div>
            </div>

            <div class="login_name_div forget_input_repwd_div margin-top2" >
                <image src="../../public/img/login/re_pwd.png" class="img"/>
                <input type="password" class="input_login_site forget_input_repwd"  data-local-placeholder="enterRepasswordPlaceholder"  placeholder="Please Enter Password Again"  >
                <div class="repwd_div" onclick="changeImgByClickRepwd()"><image src="../../public/img/login/hide_pwd.png" class="repwd" img_type="hide"/></div>
                <img src="../../../public/img/msg/msg_failed.png" class="img-failed forget_input_repwd_failed">

                <div class="line" ></div>
            </div>

            <div class="d-flex flex-row justify-content-center ">
                <button type="button" class="btn reset_pwd_button"><span class="span_btn_tip" data-local-value="resetPwdTip">Reset Password</span></button>
            </div>
        </div>
    </div>

</div>
<script src="../../public/js/im/zalyKey.js"></script>
<script src="../../public/js/im/zalyAction.js"></script>
<script src="../../public/js/im/zalyClient.js"></script>
<script src="../../public/js/im/zalyBaseWs.js"></script>
<script src="../../../public/js/login/account.js"></script>

</body>
</html>
