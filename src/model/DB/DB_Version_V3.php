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
                      gifId VARCHAR(100) NOT NULL,
                      userId VARCHAR(100) NOT NULL, 
                      gifUrl  VARCHAR(100) NOT NULL, 
                      width INTEGER not null default 0,
                      height INTEGER not null default 0,
                      addTime BIGINT
                    );";
            $this->db->exec($sql);

            for($i=1; $i<8; $i++) {
                $gifId = ZalyHelper::generateStrKey();
                $dataSql = "insert into siteUserGif ( gifId, userId, gifUrl, width, height) VALUES ('{$gifId}', 0, 'default-{$i}.gif', 200, 200);";
                echo $dataSql;
                $this->db->exec($dataSql);
            }

            $sqlIndex = "create index userId on siteUserGif(userId);";
            $this->db->exec($sqlIndex);

        }catch (Exception $ex) {
            $this->wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());
            echo "升级失败";
            die();
        }
    }
}