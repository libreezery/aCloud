<?php

/**
 * 打印消息
 * @param $code
 * @param $msg
 * @return false|string
 */
function echoMsg($code, $msg)
{
    $array = array('code' => $code,
        'msg' => $msg);
    echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

/**
 * 打印数据库错误
 * @param $databaseTool
 */
function echoMySQLError($databaseTool)
{
    echoMsg($databaseTool->getServerErrorCode(), $databaseTool->getServerErrorCode());
}

/**
 * 打印数据库错误
 * @param $databaseTool
 */
function echoMySQLErrorWithSql($sqlServer)
{
    echoMsg(mysqli_errno($sqlServer), mysqli_error($sqlServer));
}