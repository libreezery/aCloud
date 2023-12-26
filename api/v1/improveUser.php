<?php

include "../tools/UserTool.php";

if (!empty($_POST)) {
    $method = $_POST['m'];
    $userToken = $_POST['token'];
    if ($method == 0) {
        // 方式0为激活码激活
        /**
         * 激活码激活所需参数：
         * 1. token - 通用
         * 2. code - 激活码
         */
        $code = $_POST['code'];
        $userTool = new UserTool();
        // 获取用户信息
        $queryUserByToken1 = $userTool->queryUserByToken($userToken);
        $userInfo = json_decode($queryUserByToken1, true);
        $identity_expire1 = (int)$userInfo['identity_expire'];
        $queryUserByToken = $userTool->queryUserByToken($code);
        if ($queryUserByToken) {
            $json_decode = json_decode($queryUserByToken, true);
            $username = $json_decode['username'];
            $password = $json_decode['password'];
            if (substr($username, 0, 4) === "CODE" && empty($password)) {
                $identity1 = $json_decode['identity'];
                $identity_expire = (int)$json_decode['identity_expire'];
                $identity = $json_decode['identity'];
                $finalExpireTime = 0;
                if ($identity_expire1 === 0 || $identity_expire1 < time()) {
                    $finalExpireTime = time() + $identity_expire;
                } else {
                    $finalExpireTime = $identity_expire + $identity_expire1;
                }
                $improveUserIdentity = $userTool->improveUserIdentity($userToken, $identity, $finalExpireTime);
                if ($improveUserIdentity) {
                    $userTool->deleteUser($code);
                    $time = $identity_expire / 24 / 60 / 60;
                    echo json_encode(array("code" => 1, "date" => $time), JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(array("code" => -1), JSON_UNESCAPED_UNICODE);
                }
                return;
            }
        }
        echo json_encode(array("code" => 2), JSON_UNESCAPED_UNICODE);
    } else if ($method == 1) {
        // 方式1为付费激活

    }
}