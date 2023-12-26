<?php
$cookies = !empty($_COOKIE)?$_COOKIE["token"]:"";
$token = !empty($_POST)?$_POST["token"]:"";

if (strcmp($token,"-1")==0) {
    setcookie("token");
    echo 1;
    return;
}

if (!empty($cookies)) {
    echo $cookies;
} else if (empty($token)) {
    echo "null";
} else {
    $options = time() + 60*60*24*3;
//    $options = time() + 60*3;
    setcookie("token", $token, $options);
}