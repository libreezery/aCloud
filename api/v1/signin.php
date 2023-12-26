<?php

include "../tools/DatabaseTool.php";

$username = $_POST['username'];
$password = $_POST['password'];
if ($username === '' || $password === '') {
    echoMsg(-1,"请输入账号密码");
} else {
    $databaseTool = DatabaseTool::connectDatabase();
    if ($databaseTool) {
        // 数据库连接成功
        $queryUser = $databaseTool->queryUser($username);
        if (!is_null($queryUser)) {
            // 登录账户
            /*
             * {"username":"","password":"","token":"","identity":"1","identity_expire":"0"}}
             * */
            $md5 = md5($password);
            if ($md5 === $queryUser['password']) {
                // $returnArray = array('msg' => "登陆成功", 'data' => base64_encode(json_encode($queryUser,JSON_UNESCAPED_UNICODE)));
                 $returnArray = array('msg' => "登陆成功", 'data' => $queryUser['token']);
                echoMsg(1,json_encode($returnArray,JSON_UNESCAPED_UNICODE));
            } else {
                echoMsg(-1,"密码错误");
            }
        } else {
            // 注册账户
            $addUser = $databaseTool->addUser($username, $password);
            if ($addUser) {
                echoMsg(2,"注册账户成功");
            }
        }
    } else {
        echoMySQLError($databaseTool);
    }
}