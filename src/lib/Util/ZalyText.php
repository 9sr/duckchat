<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 31/08/2018
 * Time: 6:45 PM
 */

class ZalyText
{
    public static $textGroupNotExists = "text.group.notExists";
    public static $textGroupNotSpeaker = "text.group.notSpeaker";
    public static $textGroupNotMember = "text.group.notMember";
    public static $textGroupCreate = "text.group.create";

    public static $texts = [
        "text.group.notExists" => ["group is not exists", "当前群组不存在"],
        "text.group.notSpeaker" => ["only speakers and admin can speak", "当前只允许群管理以及发言者发言"],
        "text.group.notMember" => ["you aren't group member", "你不是群组成员"],
        "text.group.create" => ["group created,invite your friends to join chat", "群组已创建成功,邀请你的好友加入群聊吧"],
    ];

    public static function getText($textKey, $lang = Zaly\Proto\Core\UserClientLangType::UserClientLangZH)
    {
        if (isset(self::$texts[$textKey])) {
            return self::$texts[$textKey][$lang];
        }

        throw new Exception("unSupport zaly text key=" . $textKey);
    }


    public static function buildMessageNotice($noticeText)
    {
        $contentMsg = new \Zaly\Proto\Core\NoticeMessage();
        $contentMsg->mergeFromJsonString($noticeText);
        return $contentMsg;
    }

}