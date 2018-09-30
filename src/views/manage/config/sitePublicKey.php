<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>站点公钥<?php } else { ?>Site Public Key<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!--    <link rel=stylesheet href="../../public/css/manage_base.css"/>-->

    <style>

        html, body {
            padding: 0px;
            margin: 0px;
            font-family: PingFangSC-Regular, "MicrosoftYaHei";
            /*overflow: hidden;*/
            width: 100%;
            height: 100%;
            background: rgba(245, 245, 245, 1);
            font-size: 14px;

        }

        .wrapper {
            width: 100%;
            height: 100%;
            /*display: flex;*/
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            /*display: flex;*/
            /*align-items: stretch;*/
            overflow: hidden;
            flex-shrink: 0;
        }

        .item-row {
            background: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 44px;
        }

        /*.item-row:hover{*/
        /*background: rgba(255, 255, 255, 0.2);*/
        /*}*/

        .item-row:active {
            background: rgba(255, 255, 255, 0.2);
        }

        .item-bottom {
            background: rgba(245, 245, 245, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 25px;
        }

        .item-body {
            width: 100%;
            height: 44px;
            flex-direction: row;
        }

        .list-item-center {
            width: 100%;
            /*height: 11rem;*/
            /*background: rgba(255, 255, 255, 1);*/
            padding-bottom: 11px;
            /*padding-left: 1rem;*/

        }

        .item-body-display {
            display: flex;
            justify-content: space-between;
            /*margin-right: 7rem;*/
            /*margin-bottom: 3rem;*/
            height: 100%;
            /*line-height: 3rem;*/
        }

        .item-body-desc {
            height: 44px;
            font-size: 16px;
            /*color: rgba(76, 59, 177, 1);*/
            margin-left: 10px;
            line-height: 44px;
        }

        .line {
            width: 28.14rem;
            height: 0.01rem;
            border: 0.09rem solid rgba(153, 153, 153, 1);
            overflow: hidden;
            text-align: center;
            margin: 0 auto;
            margin-top: 0.1rem;
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

        .site-pubk-pem {
            height: 230px;
            background: rgba(245, 245, 245, 1);
            margin: 5px 15px 5px 15px;
        }

        .site-pubk-textarea {
            width: 100%;
            height: 100%;
            font-size: 12px;
            background: rgba(245, 245, 245, 1);
            border-width: 0px;
        }
    </style>

</head>

<body>

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row" id="site-name">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">站点公钥（长按复制）</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Site RSA Public Key</div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <div class="site-pubk-pem">
                <textarea class="site-pubk-textarea" disabled readonly><?php echo trim($pubkPem) ?></textarea>
            </div>

            <!--      part1: site logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">站点公钥（长按复制）</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Site RSA Public Key</div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>

</div>

<!--<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

    function isAndroid() {

        var userAgent = window.navigator.userAgent.toLowerCase();
        if (userAgent.indexOf("android") != -1) {
            return true;
        }

        return false;
    }

    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            return true;
        }
        return false;
    }

    function getLanguage() {
        var nl = navigator.language;
        if ("zh-cn" == nl || "zh-CN" == nl) {
            return 1;
        }
        return 0;
    }


    function zalyjsAjaxPostJSON(url, body, callback) {
        zalyjsAjaxPost(url, jsonToQueryString(body), function (data) {
            var json = JSON.parse(data)
            callback(json)
        })
    }


    function zalyjsNavOpenPage(url) {
        var messageBody = {}
        messageBody["url"] = url
        messageBody = JSON.stringify(messageBody)

        if (isAndroid()) {
            window.Android.zalyjsNavOpenPage(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
        }
    }

    function zalyjsCommonAjaxGet(url, callBack) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (result) {

                callBack(url, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }


    function zalyjsCommonAjaxPost(url, value, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: value,
            success: function (result) {
                callBack(url, value, result);
            },
            error: function (err) {
                alert("error");
            }
        });

    }

    function zalyjsCommonAjaxPostJson(url, jsonBody, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: jsonBody,
            success: function (result) {

                callBack(url, jsonBody, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }

    /**
     * _blank    在新窗口中打开被链接文档。
     * _self    默认。在相同的框架中打开被链接文档。
     * _parent    在父框架集中打开被链接文档。
     * _top    在整个窗口中打开被链接文档。
     * framename    在指定的框架中打开被链接文档。
     *
     * @param url
     * @param target
     */
    function zalyjsCommonOpenPage(url, target = "_blank") {
        // window.open(url, target);
        location.href = url;
    }

</script>

<script type="text/javascript">


    var timeOutEvent = 0;

    $(function () {
        $(".site-pubk-pem").on({
            touchstart: function (e) {
                //超时事件
                timeOutEvent = setTimeout(longPress, 1000);
                e.preventDefault();
            },
            touchmove: function () {
                clearTimeout(timeOutEvent);
                timeOutEvent = 0;
            },
            touchend: function () {
                clearTimeout(timeOutEvent);
                if (timeOutEvent == 0) {
                    alert(getLanguage() == 1 ? "复制成功" : "Copied to Clipboard");
                }
                return false;
            }
        });
    });


    function longPress() {
        // alert("long press");
    }

</script>


</body>
</html>




