<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 18/07/2018
 * Time: 8:45 AM
 */

class ZalyText
{
    public static $textGroupNotExists = "text.group.notExists";
    public static $textGroupNotSpeaker = "text.group.notSpeaker";
    public static $textGroupNotMember = "text.group.notMember";

    public static $texts = [
        "text.group.notExists" => ["group is not exists", "当前群组不存在"],
        "text.group.notSpeaker" => ["only speakers and admin can speak", "当前只允许群管理以及发言者发言"],
        "text.group.notMember" => ["you aren't group member", "你不是群组成员"],
    ];


    public static function getText($textKey, $lang = Zaly\Proto\Core\UserClientLangType::UserClientLangZH)
    {
        if (isset(self::$texts[$textKey])) {
            return self::$texts[$textKey][$lang];
        }

        throw new Exception("unSupport zaly text key=" . $textKey);
    }

}