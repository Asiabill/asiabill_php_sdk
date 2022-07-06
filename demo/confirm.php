<?php

include __DIR__."/main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test','12246003',$sign_key);
$asiabill->startLogger();
/**
 *  一次扣款模式
 *  需要PCI认证
 */

$result = $asiabill->request('confirmCharge',['body' => [
    'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/demo/callback.php',
    'customerId' => '', // asiabill创建的客户id，非网站用户id
    'customerPaymentMethod' => [
        'billingDetail' => [
            'address' => [
                'line1' => 'line1',
                'line2' => 'line2',
                'city' => 'BR',
                'country' => 'country',
                'state' => 'CE',
                'zip' => '666666'
            ],
            'email' => '123451234@email.com',
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'phone' => '13800138000',
        ],
        'card' => [
            'cardNo' => '4242424242424242',
            'cardExpireMonth' => '05',
            'cardExpireYear' => '2055',
            'cardSecurityCode' => '123'
        ]
    ],
    'shipping' => [
        'address' => [
            'line1' => 'line1',
            'line2' => 'line2',
            'city' => 'BR',
            'country' => 'country',
            'state' => 'CE',
            'zip' => '666666'
        ],
        'email' => '123451234@email.com',
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'phone' => '13800138000',
    ],
    'goodsDetails' => [
        [
            'goodsCount' => '1',
            'goodsPrice' => '59',
            'goodsTitle' => 'iphone',
            'goodsUrl' => 'string',
        ],
        [
            'goodsCount' => '2',
            'goodsPrice' => '20',
            'goodsTitle' => 'orange',
            'goodsUrl' => 'string',
        ]
    ],
    'isMobile' => $asiabill->isMobile(), // 0:web, 1:h5, 2:app_SDK
    'customerIp' => '127.0.0.1',
    'orderAmount' => '7.00',
    'orderCurrency' => 'USD',
    'orderNo' => getOrderNo(),
    'platform' => 'php_SDK', // 平台标识，用户自定义
    'remark' => '', // 订单备注信息
    'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/asiabill_php_sdk/demo/return.php',
    'webSite' => $_SERVER['HTTP_HOST'],
    'tokenType' => ''
]]);

echo '<pre>';
var_dump($result);

if($result['code'] == '0000'){
    /* Your business code */
}