<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/09/2018
 * Time: 2:36 PM
 */

class SiteUserGifTable extends BaseTable
{
    /**
     * @var Wpf_Logger
     */
    private $logger;
    private $table = "siteUserGif";
    private $columns = [
        "id",
        "userId",
        "gifId",
        "gifUrl",
        "width",
        "height",
        "addTime"
    ];
    private $queryColumns;


    public function init()
    {
        $this->queryColumns = implode(",", $this->columns);
    }


    public function addGif($data)
    {
        return $this->insertData($this->table, $data, $this->columns);
    }

    public function delGif($userId,$gifId)
    {
        $sql = "delete from $this->table where userId=:userId and gifId=:gifId";
        $prepare = $this->dbSlave->prepare($sql);
        $prepare->bindValue(":userId", $userId, PDO::PARAM_STR);
        $prepare->bindValue(":gifId", $gifId, PDO::PARAM_STR);
        $result = $prepare->execute();
        if($result) {
            return true;
        }
        throw new Exception("删除失败");
    }

    public function getGifByUserId($userId, $offset, $limit)
    {
        $sql = "select gifId from $this->table where (userId=:userId  or userId=0) limit $offset, $limit";
        $prepare = $this->dbSlave->prepare($sql);
        $this->handlePrepareError("site.user.gif", $prepare);
        $prepare->bindValue(":userId", $userId, PDO::PARAM_STR);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getGifByGifId($gifId)
    {
        $sql = "select gifId, gifUrl, width, height from $this->table where gifId=:gifId";
        $prepare = $this->dbSlave->prepare($sql);
        $this->handlePrepareError("site.user.gif", $prepare);
        $prepare->bindValue(":gifId", $gifId, PDO::PARAM_STR);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

}
