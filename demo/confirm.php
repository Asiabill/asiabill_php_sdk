<?php

include __DIR__."/../main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);

/**
 *  一次扣款模式
 *  需要PCI认证
 */

$result = $asiabill->request('confirmCharge',['body' => [
    'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/callback.php',
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
            'cardNo' => '4111111111111111',
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
            'goodsPrice' => '6.00',
            'goodsTitle' => 'goods_1'
        ]
    ],
    'isMobile' => $asiabill->isMobile(), // 0:web, 1:h5, 2:app_SDK
    'orderAmount' => '7.00',
    'orderCurrency' => 'USD',
    'orderNo' => getOrderNo(),
    'platform' => 'php_SDK', // 平台标识，用户自定义
    'remark' => '', // 订单备注信息
    'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/return.php',
    'webSite' => $_SERVER['HTTP_HOST'],
    'tokenType' => ''
]]);

var_dump($result);

if($result['code'] == '0000'){
    /* Your business code */
}