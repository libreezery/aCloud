<?php

/*
 * {"name":[],"type":[],"tmp_name":[],"error":[],"size":[]}
 * */

include "../tools/UserTool.php";

//$databaseTool = DatabaseTool::connectDatabase();
$userTool = new UserTool();
$databaseTool = $userTool->getDatabaseTool();

$upload = $_FILES['upload'];
if (true) {
    $token = $_POST['token'];
    $identity = json_decode($userTool->queryUserByToken($token), true)['identity'];
    $allPic = $userTool->queryUserUploadedPicturesSizeByToken($token);

    $userMaxUploadCount = 20;
    $userMaxUploadSize = 1048576;
    $expireTime = 3;
    switch ($identity) {
        case 2:
            $userMaxUploadCount = 40;
            $userMaxUploadSize = $userMaxUploadSize * 5;
            $expireTime = 7;
            break;
        case 3:
            $userMaxUploadCount = 100;
            $userMaxUploadSize = $userMaxUploadSize * 10;
            $expireTime = 30;
            break;
    }

    $name = $upload['name'];
    $size = $upload['size'];

// 创建文件夹
    $target_fold_path = "../../res/";
    if (!file_exists($target_fold_path)) {
        mkdir($target_fold_path);
    }

    $fail_pic = array();
    $success_pic = array();
    $fail_reason = array();
    for ($index = 0; $index < sizeof($name); $index++) {
        if ($upload['size'][$index] > $userMaxUploadSize) {
            $fail_pic[] = $upload['name'][$index];
            $fail_reason[] = "超出大小限制";
        } else if ($allPic >= $userMaxUploadCount) {
            $fail_pic[] = $upload['name'][$index];
            $fail_reason[] = "超出数量限制";
        } else {
            $savePath = $target_fold_path . md5($upload['name'][$index] . $token) . '.' . pathinfo($upload['name'][$index], PATHINFO_EXTENSION);
            $success_pic[] = $upload['name'][$index];
            move_uploaded_file($upload['tmp_name'][$index], $savePath);
            $databaseTool->addPicture($savePath, $upload['name'][$index], $token, $expireTime);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8"/>
    <title>文件上传</title>
    <link rel="stylesheet" href="http://www.libreeze.top/res/css/bootstrap/bootstrap.css">
    <script src="http://www.libreeze.top/res/js/jquery.js"></script>
    <script src="http://www.libreeze.top/res/js/vue.global.js"></script>
    <meta name="viewport"
          content="width=device-width,initial-scale=1"/>
</head>
<body style="background: #f5f5f5">
<section class="bg-dark">
    <div class="container d-flex align-items-center">
        <div class="nav navbar">
            <div class="navbar-brand text-light">
                <h2>aCloud</h2>
            </div>
        </div>
    </div>
</section>
<section style="margin-top: 5%">
    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-lg-6">
            <div class="card-header">
                <h1>上传完毕</h1>
            </div>
            <div class="card-body">
                <h5>上传成功:<label class="text-success">
                        <?php
                        echo sizeof($success_pic)
                        ?>
                    </label>张,上传失败<label class="text-danger">
                        <?php
                        echo sizeof($fail_pic);
                        ?>
                    </label>张</h5>
                <textarea disabled style="height: 150px" class="w-100 text-start">
                    <?php
                    for ($index = 0; $index < sizeof($fail_pic); $index++) {
                        echo $fail_pic[$index] . "(${fail_reason[$index]})" . "\n";
                    }
                    ?>
                </textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" onclick="window.location.replace(document.referrer);">返回</button>
            </div>
        </div>
    </div>
</section>
</body>
</html>



