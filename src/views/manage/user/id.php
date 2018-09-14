<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>用户资料<?php } else { ?>User Profile<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
            overflow-x: hidden;
        }

        /* mask and new window */
        .wrapper-mask {
            background: rgba(0, 0, 0, 0.8);
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: fixed;
            z-index: 9999;
            overflow: hidden;
            visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            width: 100%;
            /*height: 100%;*/
            /*display: flex;*/
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            display: flex;
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


        .item-body {
            width: 100%;
            height: 44px;
            /*margin-left: 1rem;*/
            /*margin-top: 5px;*/
            flex-direction: row;
            vertical-align: middle;
        }

        .item-body-display {
            display: flex;
            justify-content: space-between;
            /*margin-right: 7rem;*/
            /*margin-bottom: 3rem;*/
            /*height: 100%;*/
            /*line-height: 3rem;*/
            margin-top: 7px;
        }

        .item-body-desc {
            /*height: 3rem;*/
            font-size: 16px;
            /*color: rgba(76, 59, 177, 1);*/
            margin-top: 5px;
            margin-left: 10px;
        }


    </style>

</head>

<body>


<div class="wrapper" id="wrapper">

    <div class="item-row">
        <div class="item-body">
            <div class="item-body-display">
                <div class="item-body-desc"><?php echo $userId; ?></div>
            </div>

        </div>
    </div>

</div>

</body>
</html>




