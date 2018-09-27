<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/09/2018
 * Time: 10:50 AM
 */

class DB_Version_V3 extends DB_Base
{
    public function __construct()
    {
        parent::__construct();
        $this->upgradeDB();
    }

    private  function upgradeDB()
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try{
            $sql = "create table if not EXISTS siteUserGif(
                      id INTEGER PRIMARY KEY AUTOINCREMENT, 
                      userId VARCHAR(100) NOT NULL, 
                      gifId VARCHAR(100) NOT NULL,
                      addTime BIGINT
                    );";
            $this->db->exec($sql);
            $sqlIndex = "create index userId on siteUserGif(userId);";
            $this->db->exec($sqlIndex);
        }catch (Exception $ex) {
            $this->wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());
            echo "升级失败";
            die();
        }
    }
}