<?php

ini_set('display_errors','1');

$gateway_no = '12246002';
$sign_key = '12H4567r';

function getOrderNo(){
    $orderNo = 'php-sdk-'.date('YmdHis');
    for ($i=0;$i<8;$i++){
        $orderNo .= rand(0,9);
    }
    return $orderNo;
}

$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))? 'https': 'http';

include_once __DIR__ . "/../classes/AsiabillIntegration.php";




