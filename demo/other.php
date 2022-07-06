<?php

include __DIR__."/main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);
$asiabill->startLogger();


$result = $asiabill->openapi()->request('orderInfo',['path' => [
    'tradeNo' => '2022061517201146055621',
]]);

var_dump($result);

