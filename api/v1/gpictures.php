<?php

// http://www.libreeze.top/web/aCloud/api/v1/pics.php?userToken=bGlicmVlemUxMjM0NTYxNjkxMzI3MTIy

include "../tools/DatabaseTool.php";

$userToken = !empty($_GET)?$_GET['userToken']:"";

$databaseTool = DatabaseTool::connectDatabase();

if ($databaseTool) {
    $queryUserAllPics = $databaseTool->queryUserAllPics($userToken);
    if (!is_null($queryUserAllPics)) {
        echo json_encode($queryUserAllPics,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    } else {
        echo "{}";
    }
} else {
    $serverErrorMsg = $databaseTool->getServerErrorMsg();
    echo $serverErrorMsg;
}