<?php

include __DIR__."/../main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);

$customersId = '';

/**
 *  先存后付 先保存paymentMethodsId然后进行扣款
 *  1、有PCI认证，商户可以收集用户卡信息，从服务器端调用paymentMethods获取生产paymentMethodsId
 *  2、无PCI认证，商户通过sessionToken调用jsSDK获取paymentMethodsId
 */

if( $customersId ){
    /**
     * 查询客户的customerPaymentMethodId
     */
    $paymentMethods_list = $asiabill->request('paymentMethods_list',['path' => [
        'customerId' => $customersId
    ]]);
}


$pci = false;
$customerPaymentMethodId = null;

if( $pci ){

    /**
     * 网站有PCI认证
     * 获取customerPaymentMethodId，
     * 用于绑定到customer 或 扣款请求
     */
    $paymentMethods_result = $asiabill->request('paymentMethods',[
        'body' => [
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
        ]]);

    if( $paymentMethods_result['code'] == '00000' ){

        $customerPaymentMethodId = $paymentMethods_result['data']['customerPaymentMethodId'];

    }else{
        echo $paymentMethods_result['message'];
    }

}else{

    /**
     * 网站无PCI认证
     * 获取sessiontoken，用于前端调用jsSDK
     * 通过前端jsSDK获取customerPaymentMethodId
     */
    $sessiontoken = $asiabill->request('sessionToken');

    if( $sessiontoken ){
        /* js sdk */
        $customerPaymentMethodId = null ;
    }

}

if( $customerPaymentMethodId ){

    /**
     * 扣款,传customerPaymentMethodId
     */
    $confirmCharge = $asiabill->request('confirmCharge',[
        'body' => [
            'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/callback.php',
            'customerId' => $customersId, // asiabill创建的客户id，非网站用户id。1：为空：不绑定customerPaymentMethodId，2：不为空：自动绑定customerPaymentMethodId
            'customerPaymentMethodId' => $customerPaymentMethodId,
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
            'customerIp' => '127.0.0.1',
            'orderAmount' => '7.00',
            'orderCurrency' => 'USD',
            'orderNo' => getOrderNo(),
            'platform' => 'php_SDK', // 平台标识，用户自定义
            'remark' => '', // 订单备注信息
            'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/return.php',
            'webSite' => $_SERVER['HTTP_HOST'],
            'tokenType' => ''
        ]]);

    var_dump($confirmCharge);
    if( $paymentMethods_result['code'] == '00000' ){
        /* Your business code */
    }

}








