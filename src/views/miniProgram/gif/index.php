
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="../../../public/js/jquery.min.js"></script>
    <script src="../../../public/js/zalyjsNative.js"></script>
    <script src="../../../public/js/template-web.js"></script>
    <style>
        body, html {
            font-size: 10.66px;
        }
        .zaly_container {
            height: 18rem;
        }
        .gif {
            width:5rem;
            height:5rem;
            margin-left: 2rem;
            margin-top: 3rem;
        }
        .gif_div_hidden {
            display: none;
        }
        .sliding {
            margin-right: 1rem;
            width:5px;
        }
        .slide_div {
            margin-top: 3rem;
            text-align: center;
        }
        .add_gif{
            width: 5rem;
            height: 5rem;
            margin-left: 2rem;
            margin-top: 3rem;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="zaly_container" >

    <input type="hidden" class="roomType" value='<?php echo $roomType;?>'>
    <input type="hidden" class="roomId" value='<?php echo $roomId;?>'>
    <input type="hidden" class="toId" value='<?php echo $toId;?>'>
    <input type="hidden" class="fromUserId" value='<?php echo $fromUserId;?>'>
</div>

<div class="slide_div">

</div>

<script src="../../../public/js/im/zalyKey.js"></script>
<script src="../../../public/js/im/zalyAction.js"></script>
<script src="../../../public/js/im/zalyClient.js"></script>
<script src="../../../public/js/im/zalyBaseWs.js"></script>

<script type="text/javascript">
    gifs  = '<?php echo $gifs;?>';
    gifArr = JSON.parse(gifs);
    gifLength = gifArr.length + 1;
    var line = 0;
    roomId = $(".roomId").val();
    roomType = $(".roomType").val();
    fromUserId = $(".fromUserId").val();
    toId = $(".toId").val();
    var startX, startY, moveEndX,moveEndY;
    var imgObject={};
    var addGifType = "add_gif";

    var languageName = navigator.language == "en-US" ? "en" : "zh";
    var languageNum = languageName == "zh" ? UserClientLangZH : UserClientLangEN;

    if(gifLength>1) {
        for(var i=1; i<gifLength ;i ++) {
            var gif = gifArr[i];
            var gifId = "";
            try{
                var url = gif.url;
            }catch (error) {
            }
            try{
                gifId=gif.gifId;
            }catch (error) {
                gifId="";
            }
            console.log(JSON.stringify(gif));
            if(i == 1) {
                var html = '';
                line = line+1;
                html += "<div class='gif_div gif_div_0'  gif-div='"+(line-1)+"'>";
            }
            if((i-9)%10 == 1) {
                var html = '';
                line = line+1;
                var divNum = Math.ceil(((i-9)/10));
                html += "<div class='gif_div gif_div_hidden gif_div_"+divNum+"' gif-div='"+(line-1)+"'>";
            }

            if(i==1) {
                html += "<img src='../../../public/img/add.png' class='add_gif'>  " +
                    "<input id='gifFile' type='file' onchange='uploadFile(this)' accept='image/gif;capture=camera' style='display: none;'>";
            }
            if(gifId != "" && gifId != undefined) {
                html += "<img id=gifId_"+i+" src='"+gifId+"' class='gif' gifId='"+gifId+"'>";
            } else {
                html += "<img src='"+url+"' class='gif'>";
            }

            if(i==4) {
                html +="<br/>";
            } else if (i>5 && (i-5)%5 == 4) {
                html +="<br/>";
            }

            if((i-9)%10 == 0){
                html += "<div/>";
                $(".zaly_container").append(html);
            } else if(i == gifLength-1) {
                html += "<div/>";
                $(".zaly_container").append(html);
            }
        }
    }
    var slideHtml = "";
    for(var i=0; i<line; i++){
        slideHtml += "<img src='../../../public/gif/sliding_unselect.png' select_gif_div= '"+i+"' class='sliding sliding_img sliding_uncheck sliding_uncheck_"+i+"'/>";
        $(".slide_div").html(slideHtml);
    }

    currentGifDivNum = 0;

    var flag = false;

    $(".add_gif").on("touchstart click", function (event) {
        $("#gifFile").val("");
        $("#gifFile").click();
    });

    function uploadFile(obj) {
        if (obj) {
            if (obj.files) {
                var formData = new FormData();
                formData.append("file", obj.files.item(0));
                formData.append("fileType", "FileImage");
                formData.append("isMessageAttachment", false);
                var src = window.URL.createObjectURL(obj.files.item(0));
                uploadFileToServer(formData, src);
            }
            return obj.value;
        }
    }
    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            return true;
        }
        return false;
    }


    function uploadFileToServer(formData, src) {

        var url = "./index.php?action=http.file.uploadWeb";

        if (isMobile()) {
            url = "/_api_file_upload_/?fileType=1";  //fileType=1,表示文件
        }

        $.ajax({
            url: url,
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (imageFileIdResult) {
                if (imageFileIdResult) {
                    var fileId = imageFileIdResult;
                    if (isMobile()) {
                        var res = JSON.parse(imageFileIdResult);
                        fileId = res.fileId;
                    }
                    updateServerGif(fileId, src);
                } else {
                    alert(getLanguage() == 1 ? "上传返回结果空 " : "empty response");
                }
            },
            error: function (err) {
                alert("update image error");
                // return false;
            }
        });
    }


    function autoMsgImgSize(src, h, w)
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
    }



    $(".gif").on('touchstart click', function(event){
        if(!flag) {
            flag = true;
            event.stopPropagation();
            event.preventDefault();
            var src = $(this).attr("src");
            autoMsgImgSize(src, 200, 300);
            var gifId = $(this).attr("gifId");
            if(gifId) {
                var  downloadFileUrl = "./index.php?action=http.file.downloadFile";
                var src = downloadFileUrl + "&fileId=" + gifId + "&returnBase64=0";
            }
            sendGifMsg(src);
            setTimeout(function(){ flag = false; }, 100);
        }
        return false
    });

    $(".zaly_container").on("touchstart", function(e) {
        e.preventDefault();
        startX = e.originalEvent.changedTouches[0].pageX,
            startY = e.originalEvent.changedTouches[0].pageY;
    });

    $(".zaly_container").on("touchend", function(e) {
        moveEndX = e.originalEvent.changedTouches[0].pageX;
        moveEndY = e.originalEvent.changedTouches[0].pageY;
        if(startX == undefined) {
            startX = moveEndX;
        }
        if(startY == undefined) {
            startY = moveEndY;
        }
        X = moveEndX - startX;
        Y = moveEndY - startY;

        if ( Math.abs(X) > Math.abs(Y) && X > 10 ) {
            ////右滑喜欢
            if(currentGifDivNum == 0) {
                return;
            }
            rightSlide();
        }
        else if ( Math.abs(X) > Math.abs(Y) && X < -10 ) {
            ////左滑不喜欢
            if(currentGifDivNum == (line-1)) {
                return;
            }
            leftSlide();
        }
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
                if(type == addGifType) {
                }
            }
        });
    }

    function sendGifMsg(msgContent)
    {
        var msgId  = Date.now();

        var message = {};
        message['fromUserId'] = fromUserId;
        var msgIdSuffix = "";
        if(roomType == U2_MSG) {
            message['roomType'] = U2_MSG;
            message['toUserId'] = toId
            msgIdSuffix = "U2-";
        } else {
            message['roomType'] = GROUP_MSG;
            message['toGroupId'] = toId;
            msgIdSuffix = "GROUP-";
        }
        var msgId = msgIdSuffix + msgId+"";
        message['msgId'] = msgId;

        message['timeServer'] = Date.parse(new Date());
        message['type'] = MessageType.MessageWeb;
        var webHtml = '<!DOCTYPE html> <html> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"></head> <body> <img src="'+msgContent+'" width="100%" > </body> </html>'
        message['web'] = {code:webHtml, width:imgObject.width, height:imgObject.height, hrefURL:msgContent}

        var action = "miniProgram.gif.index";
        var reqData = {
            "message" : message
        };

        sendPostToServer(reqData, "send_msg");
    }

    function updateServerGif(fileId, src)
    {
        var reqData = {
            gifId : fileId,
            type:addGifType,
        }
        sendPostToServer(reqData, addGifType);
    }

    function leftSlide()
    {
        var oldGifDivNum = currentGifDivNum;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "none";
        currentGifDivNum = currentGifDivNum + 1;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "block";
        changeSlideImg(oldGifDivNum);
    }

    function rightSlide()
    {
        var oldGifDivNum = currentGifDivNum;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "none";

        currentGifDivNum = currentGifDivNum -1;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "block";
        changeSlideImg(oldGifDivNum);
    }

    function changeSlideImg(oldGifDivNum)
    {
        var selectImg = "../../public/gif/sliding_select.png";
        $("[select_gif_div='"+currentGifDivNum+"']").attr("src", selectImg);

        var unSelectImg = "../../public/gif/sliding_unselect.png";
        $("[select_gif_div='"+oldGifDivNum+"']").attr("src", unSelectImg);
    }

</script>
</body>
</html>