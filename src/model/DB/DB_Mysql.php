<?php

/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 08/08/2018
 * Time: 7:29 PM
 */
class DB_Mysql
{
    public $db;

    public function __construct()
    {
        $host = "localhost";
        $userName = "root";
        $passwd = "open.akaxin.com1234567890";
        $dbName = "platform_duckchat";
        $port = 3306;
        $this->db = new PDO("mysql:host=$host;dbname=$dbName;", $userName, $passwd);//创建一个pdo对象
    }


    public function checkDBAndTable()
    {
        $this->_checkDBTables();
    }

    private function _checkDBTables()
    {
        $this->_checkPlatformUserTable();
        $this->_checkPlatformSessionTable();
        $this->_checkPlatformSiteTable();
        $this->_checkPlatformUserDeviceTable();
    }


    // platform user
    private function _checkPlatformUserTable()
    {
        $sql = 'CREATE TABLE if Not EXISTS  platformUser (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            userId VARCHAR(100) not null,
            phoneNumber VARCHAR(11) not null ,/* comment "用户手机号"*/
            phoneCountryCode VARCHAR(10) not null default \'86\',
            loginName VARCHAR(100)  not null,
            timeReg BIGINT ,/*comment "创建时间"*/
            UNIQUE (userId),
            UNIQUE (phoneNumber),
            UNIQUE (loginName)
            );';

        $prepare = $this->db->prepare($sql);
        $prepare->execute();

        echo "check table platformUser table finish ";
    }

    // platform session
    private function _checkPlatformSessionTable()
    {
        $sql = 'create table if not EXISTS platformSession (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                userId INTEGER not null ,
                sessionId VARCHAR(100) not null,/*平台session*/
                sitePubkBase64 TEXT not null,
                createTime Long ,/*comment "创建时间"*/
                UNIQUE  (userId, sessionId)
                );';
        $prepare = $this->db->prepare($sql);
        $prepare->execute();
        echo "check table platformSession table finish ";
    }

    private function _checkPlatformSiteTable()
    {
        $sql = "create table if not EXISTS platformSite (
              id INTEGER PRIMARY KEY AUTO_INCREMENT,
              siteId VARCHAR(100) not null ,
              sitePubkPem TEXT not null,/*平台session*/
              siteAddress VARCHAR(100),
              siteName VARCHAR(100),
              siteLogo TEXT ,
              status INTEGER, -- 0:关闭 1：普通站点 2:推荐站点  3：官方站点
              updateTime BIGINT , -- 更新时间
              UNIQUE (siteId)
            );";

        $prepare = $this->db->prepare($sql);
        $prepare->execute();

        echo "check table platformSite table finish ";
    }

    private function _checkPlatformUserDeviceTable()
    {
        $sql = "create table if not EXISTS platformUserDevice (
              id INTEGER PRIMARY KEY AUTO_INCREMENT,
              siteId VARCHAR(100) not null,/*平台session*/
              siteUserId VARCHAR(100),    -- null 只会影响静音
              deviceId VARCHAR(100) not null,
              devicePubkPem text not null,
              siteAddress VARCHAR(50),
              siteName VARCHAR(50),
              pushToken VARCHAR(100),
              pushTokenType INTEGER, -- push os type /android/IOS/xiaomi/huawei/umeng
              pushMark VARCHAR(50),  -- siteUserToken + pushToken + pushTokenType -> pushMark
              mute boolean, -- pushToken 是否可用
              lang INTEGER, -- 0:en 1:zh
              updateTime BIGINT,
              UNIQUE (siteId,deviceId,pushToken),
              INDEX (siteId,siteUserId)
            );";

        $prepare = $this->db->prepare($sql);
        $prepare->execute();

        echo "check table platformUserDevice table finish ";
    }


}