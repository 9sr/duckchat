
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GIF小程序</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="../../../public/js/jquery.min.js"></script>
    <script src="../../../public/js/zalyjsNative.js"></script>
    <script src="../../../public/js/template-web.js"></script>
    <style>
        body, html {
            font-size: 10.66px;
            width: 100%;
        }
        .zaly_container {
            width: 100%;
            height:100%;
            display: flex;
            justify-content: center;
            text-align: center;
        }
        .save_button {
            width:7.5rem;
            height:3.38rem;
            background:rgba(76,59,177,1);
            border-radius:0.38rem;
            font-size:1.5rem;
            font-family:PingFangSC-Regular;
            font-weight:400;
            color:rgba(255,255,255,1);
        }
        .gif_div {
            width: 19rem;
            height:19rem;
        }
    </style>
</head>
<body>

<div class="zaly_container" >
    <input type="hidden" class="roomType" value='<?php echo $roomType;?>'>
    <input type="hidden" class="toId" value='<?php echo $toId;?>'>
    <input type="hidden" class="fromUserId" value='<?php echo $fromUserId;?>'>
    <?php if(!isset($gifId)) {?>
        出错啦~~~
    <?php }else {?>
        <div class="gif_div">
            <img id="gifInfo" src='<?php echo $gifUrl?>' class='gif' gifId='<?php echo $gifId?>'>
        </div>
        <div>
            <button class="save_gif save_button" gifId='<?php echo $gifId?>'>收藏</button>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    roomType = $(".roomType").val();
    fromUserId = $(".fromUserId").val();
    toId = $(".toId").val();
    UserClientLangZH = "1";
    UserClientLangEN = "0";
    var imgObject = {};
    var saveGifType = "save_gif";

    var languageName = navigator.language == "en-US" ? "en" : "zh";
    var languageNum = languageName == "zh" ? 1 : UserClientLangEN;
    var src = $("#gifInfo").attr("src");
    autoImgSize(src, 200, 200);

    function autoImgSize(src, h, w)
    {
        var image = new Image();
        image.src = src;
        var imageNaturalWidth  = image.naturalWidth;
        var imageNaturalHeight = image.naturalHeight;

        if (imageNaturalWidth < w && imageNaturalHeight<h) {
            imgObject.width  = imageNaturalWidth == 0 ? w : imageNaturalWidth;
            imgObject.height = imageNaturalHeight == 0 ? h : imageNaturalHeight;
        } else {
            if (w / h <= imageNaturalWidth/ imageNaturalHeight) {
                imgObject.width  = w;
                imgObject.height = w* (imageNaturalHeight / imageNaturalWidth);
            } else {
                imgObject.width  = h * (imageNaturalWidth / imageNaturalHeight);
                imgObject.height = h;
            }
        }
        $("#gifInfo")[0].style.width =  imgObject.width+"px";
        $("#gifInfo")[0].style.height =  imgObject.height+"px";
    }

    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            return true;
        }
        return false;
    }

    $(".save_gif").on("click", function () {
        var gifId = $(this).attr("gifId");
        var reqData = {
            gifId : gifId,
            type:saveGifType,
        }
        sendPostToServer(reqData, saveGifType);
        return false;
    });

    function sendPostToServer(reqData, type)
    {
        $.ajax({
            method: "POST",
            url:"./index.php?action=miniProgram.gif.index&lang="+languageNum,
            data: reqData,
            success:function (data) {
                data = JSON.parse(data);
                if(data.errorCode == 'error.alert') {
                    zalyjsAlert(data.errorInfo);
                    return false;
                }
            }
        });
    }

    function updateServerGif(fileId)
    {
        var reqData = {
            gifId : fileId,
            type:addGifType,
            width:imgObject.width,
            height:imgObject.height
        }
        sendPostToServer(reqData, addGifType);
    }



</script>
</body>
</html>