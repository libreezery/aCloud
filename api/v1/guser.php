<?php

include "../tools/UserTool.php";

$t = $_POST['t'];
if (!empty($t)) {
    $userTool = new UserTool();
    echo $userTool->queryUserByToken($t);
}
