<?php

include "DatabaseTool.php";

// 用户信息操作类

class UserTool
{
    private $databaseTool;
    private $sqlServer;

    public function __construct()
    {
        $this->databaseTool = DatabaseTool::connectDatabase();
        $this->sqlServer = $this->databaseTool->getSQLServer();
    }

    public function getDatabaseTool()
    {
        return $this->databaseTool;
    }

    /**
     * 通过Token获取用户信息
     * @param $token
     * @return false|string
     */
    public function queryUserByToken($token)
    {
        $sqlCMD = "select * from `acloud_userinfo` where token = '${token}'";
        $mysqli_result = mysqli_query($this->sqlServer, $sqlCMD);
        if (!empty($mysqli_result)) {
            $mysqli_fetch_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);
            if (!empty($mysqli_fetch_row)) {
                return json_encode($mysqli_fetch_row, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 查询用户已上传图片数量
     * @param $token
     * @return int
     */
    public function queryUserUploadedPicturesSizeByToken($token)
    {
        $queryUserAllPics = $this->databaseTool->queryUserAllPics($token);
        return sizeof($queryUserAllPics);
    }

    /**
     * 提升用户等级
     * @param $t token
     * @param $i 身份
     * @param $e 过期时间
     * @return bool
     */
    public function improveUserIdentity($t, $i, $e)
    {
        $sqlCMD = "UPDATE acloud_userinfo SET acloud_userinfo.identity=$i, acloud_userinfo.identity_expire='$e' WHERE acloud_userinfo.token='$t'";
        $mysqli_result = mysqli_query($this->sqlServer, $sqlCMD);
        if ($mysqli_result) {
            return true;
        }
        return false;
    }

    /**
     * 获取激活码数据
     * @param $code 激活码
     * @return false|string|void
     */
    public function queryCode($code)
    {
        return $this->queryUserByToken($code);
    }

    /**
     * 删除用户
     * @param $token
     * @return bool
     */
    public function deleteUser($token)
    {
        $sqlCMD = "DELETE FROM acloud_userinfo WHERE acloud_userinfo.token='$token'";
        $mysqli_result = mysqli_query($this->sqlServer, $sqlCMD);
        if ($mysqli_result) {
            return true;
        }
        return false;
    }


}