<?php

// 高级用户价格
$advanceUser = array(
    "price"=>3,
    "date"=>30,
);

// 至尊用户价格
$supremeUser = array(
    "price"=>8,
    "date"=>30,
);

$data = array("advance"=>$advanceUser,
    "supreme"=>$supremeUser);

echo json_encode($data,JSON_UNESCAPED_UNICODE);