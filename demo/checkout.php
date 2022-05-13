<?php

include __DIR__."/../main.php";

use \Asiabill\Classes\AsiabillIntegration;


$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);
$asiabill->startLogger();
/**
 * 托关结算模式
 * 获取重定向URL：redirectUrl
 */


$result = $asiabill->request('checkoutPayment',['body' => [
    'billingAddress' => [
        'address' => 'address',
        'city' => 'BR',
        'country' => 'country',
        'email' => '123451234@email.com',
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'phone' => '13800138000',
        'state' => 'CE',
        'zip' => '666666'
    ],
    'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/webhook.php',
    'customerId' => '', // asiabill创建的客户id，非网站用户id
    'deliveryAddress' => [
        'address' => 'address',
        'city' => 'BR',
        'country' => 'country',
        'email' => '123451234@email.com',
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'phone' => '13800138000',
        'state' => 'CE',
        'zip' => '666666'
    ],
    'goodsDetails' => [
        [
            'goodscount' => '1',
            'goodsprice' => '6.00',
            'goodstitle' => 'goods_1',
            'goodsurl' => ''
        ]
    ],
    'isMobile' => $asiabill->isMobile(), // 0:web, 1:h5, 2:app_SDK
    'orderAmount' => '7.00',
    'orderCurrency' => 'USD',
    'orderNo' => getOrderNo(),
    'paymentMethod' => 'Credit Card', // 其它支付方式请参考文档说明
    'platform' => 'php_SDK', // 平台标识，用户自定义
    'remark' => '', // 订单备注信息
    'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/return.php',
    'webSite' => $_SERVER['HTTP_HOST']
]]);

var_dump($result);

if($result['code'] == '0000'){
    /* Your business code */
}


