<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>群资料<?php } else { ?>Group Profile<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="../../public/jquery/weui.min.css"/>
    <link rel="stylesheet" href="../../public/jquery/jquery-weui.min.css"/>

    <link rel="stylesheet" href="../../public/manage/config.css"/>

    <style>
        .site-image {
            width: 30px;
            height: 30px;
            /*margin-top: 5px;*/
            margin-bottom: 7px;
            /*border-radius: 50%;*/
            cursor: pointer;
        }

    </style>

</head>

<body>

<!--<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>-->

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row" id="group-id" data="<?php echo $groupId; ?>">

        <div class="list-item-center">

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群ID</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group ID</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value"><?php echo $groupId ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="user-nickname">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群组名称</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group Name</div>
                        <?php } ?>

                        <div class="item-body-tail" id="user-nickname-text">
                            <div class="item-body-value"><?php echo $name ?></div>
                            <div class="item-body-value">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: group logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群组头像</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group Avatar</div>
                        <?php } ?>

                        <div class="item-body-tail" id="group-avatar-img-id" fileId="<?php echo $avatar ?>">

                            <div class="item-body-value">
                                <img id="group-avatar-img" class="site-image"
                                     onclick="uploadFile('group-avatar-img-input')"
                                     src="./../public/img/msg/group_default_avatar.png">

                                <input id="group-avatar-img-input" type="file"
                                       accept="image/gif,image/jpeg,image/jpg,image/png,image/svg"
                                       style="display: none;">
                            </div>
                            <!--                            <img class="more-img"-->
                            <!--                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!-- part 2  register && login plugin-->
    <div class="layout-all-row">

        <div class="list-item-center">

            <div class="item-row" id="group-max-members">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设置最大成员</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Set Max Members</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <div class="item-body-value"><?php
                                if (isset($maxMembers) && $maxMembers > 0) {
                                    echo $maxMembers;
                                } else {
                                    echo 100;
                                }
                                ?></div>
                            <div class="item-body-value">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>
            <!--
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设置是否允许分享</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Share Group</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableShareGroup == 1) { ?>
                                <input id="enableShareGroupSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableShareGroupSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>-->

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设为站点默认群组</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Add Site Default Groups</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($isDefaultGroup == 1) { ?>
                                <input id="addDefaultGroupSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="addDefaultGroupSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!--   part 3  -->
    <div class="layout-all-row">

        <div class="list-item-center">
            <div class="item-row" id="manage-group-members">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群成员管理</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Manage Group Members</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>


    <!--   part 4  -->
    <div class="layout-all-row">

        <div class="list-item-center">
            <div class="item-row" id="remove-group">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">解散群组</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Remove Group</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-bottom">

            </div>
        </div>
    </div>

</div>

<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>

<div class="popup-template" style="display:none;">

    <div class="config-hidden" id="popup-group">

        <div class="flex-container">
            <div class="header_tip_font popup-group-title">创建群组</div>
        </div>

        <div class="" style="text-align: center">
            <input type="text" class="popup-group-input"
                   data-local-placeholder="enterGroupNamePlaceholder" placeholder="please input">
        </div>

        <div class="line"></div>

        <div class="" style="text-align:center;">
            <?php if ($lang == "1") { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();"> 修改
                </button>
            <?php } else { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();">Update
                </button>
            <?php } ?>
        </div>

    </div>

</div>


<script type="text/javascript" src="../../public/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../../public/jquery/jquery-weui.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-confirm.js"></script>

<script type="text/javascript" src="../../public/manage/native.js"></script>

<script type="text/javascript">

    $(function () {
        var fileId = $("#group-avatar-img-id").attr("fileId");
        showImage(fileId, 'group-avatar-img');
    });

    function uploadFile(obj) {
        // $("#" + obj).val("");
        // $("#" + obj).click();
    }

    downloadFileUrl = "./index.php?action=http.file.downloadFile";


    function showImage(fileId, htmlImgId) {

        var requestUrl = "./_api_file_download_/test?fileId=" + fileId;

        if (!isMobile()) {
            requestUrl = downloadFileUrl + "&fileId=" + fileId + "&returnBase64=0";
        }

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && (this.status == 200 || this.status == 304)) {
                var blob = this.response;
                var src = window.URL.createObjectURL(blob);
                $("#" + htmlImgId).attr("src", src);
            }
        };
        xhttp.open("GET", requestUrl, true);
        xhttp.responseType = "blob";
        // xhttp.setRequestHeader('Cache-Control', "max-age=2592000, public");
        xhttp.send();
    }

</script>

<script type="text/javascript">

    function showWindow(jqElement) {
        jqElement.css("visibility", "visible");
        $(".wrapper-mask").css("visibility", "visible").append(jqElement);
    }


    function removeWindow(jqElement) {
        jqElement.remove();
        $(".popup-template").append(jqElement);
        $(".wrapper-mask").css("visibility", "hidden");
        $("#update-user-button").attr("data", "");
        $(".popup-group-input").val("");
        $(".popup-template").hide();
    }


    $(".wrapper-mask").mouseup(function (e) {
        var targetId = e.target.id;
        var targetClassName = e.target.className;

        if (targetId == "wrapper-mask") {
            var wrapperMask = document.getElementById("wrapper-mask");
            var length = wrapperMask.children.length;
            var i;
            for (i = 0; i < length; i++) {
                var node = wrapperMask.children[i];
                node.remove();
                // addTemplate(node);
                $(".popup-template").append(node);
                $(".popup-template").hide();
            }
            $("#update-user-button").attr("data", "");
            $(".popup-group-input").val("");
            wrapperMask.style.visibility = "hidden";
        }
    });


    $("#user-nickname").click(function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "name");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);

    });

    $("#group-max-members").click(function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "maxMembers");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);
    });


    function updateConfirm() {
        var groupId = $("#group-id").attr("data");
        var value = $(".popup-group-input").val();
        var keyName = $("#update-user-button").attr("data");

        if (keyName == null || keyName == "") {
            alert("update fail");
            return;
        }

        var data = {
            'groupId': groupId,
            'key': keyName,
            'value': value,
        };

        var url = "index.php?action=manage.group.update&lang=" + getLanguage();
        zalyjsCommonAjaxPostJson(url, data, updateGroupResponse)

        removeWindow($(".config-hidden"));
    }

    function updateGroupResponse(url, data, result) {
        if (result) {
            var res = JSON.parse(result);

            if ("success" == res.errCode) {
                location.reload();
            } else {
                alert(getLanguage() == 1 ? "删除失败" : "delete error");
            }

        } else {
            alert(getLanguage() == 1 ? "删除失败" : "delete error");
        }
    }

    //enable realName
    $("#enableShareGroupSwitch").change(function () {
        var groupId = $("#group-id").attr("data");
        var lang = getLanguage();
        var isChecked = $(this).is(':checked')
        var url = "index.php?action=manage.group.update&lang=" + lang;

        var data = {
            'groupId': groupId,
            'key': 'enableShareGroup',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, enableShareGroupResponse)
    });

    //暂时无用
    function enableShareGroupResponse(url, data, result) {
        alert(result);
    }


    $("#addDefaultGroupSwitch").change(function () {

        var groupId = $("#group-id").attr("data");
        var isChecked = $(this).is(':checked')
        var url = "index.php?action=manage.group.update&lang=" + getLanguage();

        var data = {
            'groupId': groupId,
            'key': 'addDefaultGroup',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, addDefaultGroupResponse)

    });

    function addDefaultGroupResponse(url, data, result) {
        if (result) {
            var res = JSON.parse(res);

            if ("success" != res.errCode) {
                alert(getLanguage() == 1 ? "操作失败" : "operate error");
            }
        } else {
            alert(getLanguage() == 1 ? "操作失败" : "operate error");
        }
    }


    $("#manage-group-members").click(function () {
        var groupId = $("#group-id").attr("data");

        var url = "index.php?action=manage.group.members&groupId=" + groupId + "&lang=" + getLanguage();

        zalyjsCommonOpenPage(url);
    });


    $("#remove-group").click(function () {

        var lang = getLanguage();
        $.modal({
            title: lang == 1 ? '删除群组' : 'Delte Group',
            text: lang == 1 ? '确定删除？' : 'Confirm Delete?',
            buttons: [
                {
                    text: lang == 1 ? "取消" : "cancel", className: "default", onClick: function () {
                        // alert("cancel");
                    }
                },
                {
                    text: lang == 1 ? "确定" : "confirm", className: "main-color", onClick: function () {
                        var groupId = $("#group-id").attr("data");

                        var url = "index.php?action=manage.group.delete&lang=" + getLanguage();

                        var data = {
                            'groupId': groupId
                        };

                        zalyjsCommonAjaxPostJson(url, data, removeGroupResponse)
                    }
                },

            ]
        });

    });

    function removeGroupResponse(url, data, result) {
        if (result) {
            var res = JSON.parse(result);

            if ("success" == res.errCode) {
                var url = "index.php?action=manage.group&lang=" + getLanguage();
                window.location.href = url;
            } else {
                alert(getLanguage() == 1 ? "删除失败" : "delete error");
            }

        } else {
            alert(getLanguage() == 1 ? "删除失败" : "delete error");
        }
    }

</script>


</body>
</html>




