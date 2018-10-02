<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>用户管理<?php } else { ?>User Management<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="../../public/manage/config.css"/>
</head>

<body>

<div class="wrapper" id="wrapper">

    <div class="layout-all-row">

        <div class="list-item-center">

            <div class="item-row-title">
                <div class="" style="flex-direction: row;vertical-align: bottom;width: 100%;">
                    <div class="item-body-display">

                        <div class="" style="margin-left: 10px">
                            <?php if ($lang == "1") { ?>
                                站点成员列表
                            <?php } else { ?>
                                Site Users
                            <?php } ?>
                        </div>

                        <div class="" style="margin-right: 10px">
                            <?php echo $totalUserCount ?>
                        </div>

                    </div>
                </div>
            </div>

            <?php foreach ($userList as $key => $profile) { ?>

                <div class="item-row">
                    <div class="item-body" onclick="showUserProfile('<?php echo($profile["userId"]) ?>')"
                         id="user-list-id" userId="<?php echo($profile["userId"]) ?>">
                        <div class="item-body-display">
                            <div class="item-body-desc">
                                <?php
                                if ($profile["nickname"]) {
                                    echo $profile["nickname"];
                                } else if ($profile["loginName"]) {
                                    echo $profile["loginName"];
                                } else {
                                    echo $profile["userId"];
                                }

                                ?>
                            </div>

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
            <?php } ?>

        </div>

    </div>
</div>


<script type="text/javascript" src="../../public/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../../public/manage/native.js"></script>

<script type="text/javascript">

    function showUserProfile(userId) {
        var url = "./index.php?action=manage.user.profile&lang=" + getLanguage() + "&userId=" + userId;
        zalyjsCommonOpenPage(url);
    }

</script>


</body>
</html>




