<?php

ini_set('display_errors','1');

include_once __DIR__ . "/../classes/AsiabillIntegration.php";

$asiabill = new  \Asiabill\Classes\AsiabillIntegration('test', '12246002','12H4567r');
$asiabill->startLogger();

function getOrderNo(){
    $orderNo = 'php-sdk-'.date('YmdHis');
    for ($i=0;$i<8;$i++){
        $orderNo .= rand(0,9);
    }
    return $orderNo;
}


$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))? 'https': 'http';

$checkout_data = [
    'orderAmount' => '7.00',
    'orderCurrency' => 'USD',
    'orderNo' => getOrderNo(),
    'goodsDetails' => [
        [
            'goodsCount' => '1',
            'goodsPrice' => '6.00',
            'goodsTitle' => 'goods_1'
        ]
    ],
    'isMobile' => $asiabill::isMobile(), // 0:web, 1:h5, 2:app_SDK
    'customerId' => '', // asiabill创建的客户id，非网站用户id
    'paymentMethod' => 'Credit Card', // 其它支付方式请参考文档说明
    'platform' => 'php_SDK', // 平台标识，用户自定义
    'remark' => '', // 订单备注信息
    'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/demo/return.php',
    'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/demo/webhook.php',
    'webSite' => $_SERVER['HTTP_HOST']
];






