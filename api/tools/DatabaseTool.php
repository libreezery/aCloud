<?php

include "../../api/v1/including.php";

class DatabaseTool
{

    public static $sqlServer;

    private function __construct($sqlServer2)
    {
        // 实现单例模式
        self::$sqlServer = $sqlServer2;
        return self::$sqlServer;
    }

    public static function connectDatabase()
    {
        global $database_host, $database_password, $database_username;
        $sqlServer = mysqli_connect($database_host, $database_username, $database_password, "s9271372");
        return new DatabaseTool($sqlServer);
    }

    /*
     * 获取MySQL数据库错误英文
     * */

    public function getServerErrorMsg()
    {
        return mysqli_error(self::$sqlServer);
    }

    /**
     * 根据用户名寻找账户
     * @param $username
     * @return array|null
     */
    public function queryUser($username)
    {
        $mysqli_result = mysqli_query(self::$sqlServer, "SELECT * FROM `acloud_userinfo` WHERE username = '$username'");
        if ($mysqli_result) {
            return mysqli_fetch_array($mysqli_result,MYSQLI_ASSOC);
        } else {
            echoMySQLErrorWithSql(self::$sqlServer);
            return null;
        }
    }

    /**
     * 注册账户
     * @param $username
     * @param $password
     * @return bool
     */
    public function addUser($username, $password)
    {
        $psw_md5 = md5($password);
        $base64_encode = base64_encode($username . $password . time());
        $sqlCmd = "INSERT INTO `acloud_userinfo` VALUE('$username','$psw_md5','$base64_encode',1,0)";
        $mysqli_result = mysqli_query(self::$sqlServer, $sqlCmd);
        if ($mysqli_result) {
            return true;
        } else {
            echoMsg($this->getServerErrorCode(), "账号已存在");
            return false;
        }
    }

    public function getServerErrorCode()
    {
        return mysqli_errno(self::$sqlServer);
    }

    /**
     * 查询用户所有的图片信息
     * @param $userToken
     * @return array|null
     */
    public function queryUserAllPics($userToken) {
        $sqlCmd = "SELECT * FROM `acloud_picinfo` WHERE acloud_picinfo.token = '$userToken'";
        $mysqli_result = mysqli_query(self::$sqlServer, $sqlCmd);
        if ($mysqli_result) {
            return mysqli_fetch_all($mysqli_result,MYSQLI_ASSOC);
        } else {
            echoMySQLErrorWithSql(self::$sqlServer);
            return null;
        }
    }

    /**
     * @param $pictureSavePath
     * @param $pictureName
     * @param $userToken
     * @param $expireTime
     * @return bool
     */
    public function addPicture($pictureSavePath,$pictureName,$userToken,$expireTime) {
        $md5_file = md5_file($pictureSavePath);
        $currentTime = time() * 1000;
        $expireTime=($expireTime * 86400000) + $currentTime;
        $sql_cmd = "INSERT INTO `acloud_picinfo` VALUE(
                                 '$pictureSavePath',
                                 '$md5_file',
                                 '$pictureName',
                                 '$userToken',
                                 '$currentTime',
                                '$expireTime')";
        $mysqli_result = mysqli_query(self::$sqlServer, $sql_cmd);
        if ($mysqli_result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $filePath
     * @param $userToken
     */
    public function deletePicture($filePath,$userToken) {
        $cmd = "DELETE FROM acloud_picinfo WHERE `path` = '$filePath' AND `token` = '$userToken'";
        $mysqli_result = mysqli_query(self::$sqlServer, $cmd);
        if ($mysqli_result) {
            // success
            unlink($filePath);
            echoMsg(1,"删除成功");
        } else {
            echoMsg(-1,"删除失败");
        }
    }

    public function queryPictureExpireTime($pic_path) {
        $cmd = "select acloud_picinfo.expire_time from acloud_picinfo where acloud_picinfo.path = '$pic_path'";
        $mysqli_result = mysqli_query(self::$sqlServer, $cmd);
        if ($mysqli_result) {
            return mysqli_fetch_row($mysqli_result)[0];
        }
        return -1;
    }

    /**
     * @return mixed
     */
    public function getSQLServer() {
        return self::$sqlServer;
    }

}