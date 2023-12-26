<?php

include '../../api/tools/DatabaseTool.php';

$databaseTool = DatabaseTool::connectDatabase();

$data = $_GET['data'];

// 创建文件夹
$target_fold_path = "../../res/";
if (!file_exists($target_fold_path)) {
    mkdir($target_fold_path);
}

$filepath = $target_fold_path.$data;

$queryPictureExpireTime = $databaseTool->queryPictureExpireTime($filepath);

if (($queryPictureExpireTime!=-1 && (time() * 1000)>$queryPictureExpireTime) || !(file_exists($filepath))) {
    $filepath = '../../img/icon/pic_expired.png';
}


$file_get_contents = file_get_contents($filepath);
header("content-length:".filesize($filepath));
header("Content-Type: image/png; text/html; charset=utf-8");
echo $file_get_contents;
exit;
