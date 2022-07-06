<?php

include __DIR__."/main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);

$customer_id = $_COOKIE['ab_customerId'];

/**
 * 创建客户
 */

if( !$customer_id  ){
    $customers_result = $asiabill->request('customers',['body' => [
        'description' => 'test customer',
        'email' => '123451234@email.com',
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'phone' => '13800138000'
    ]]);

    if( $customers_result['code'] == '00000' ){
        setcookie('ab_customerId',$customers_result['data']['customerId'],time()+1000);
    }
}


/**
 * 查询所有客户列表
 */
$customers_list = $asiabill->request('customers');

/**
 * 分页查询客户列表
 */
$customers_page = $asiabill->request('customers',['query' => [
    'pageIndex' => '1', //当前页码，从1开始，最长10位，默认为1
    'pageSize' => '5', //每页显示记录数，最大1000，默认10
]]);

/**
 * 查询单个客户
 */
if( $customer_id ){
    $customer_info = $asiabill->request('customers',['path' => [
        'customerId' => $customer_id
    ]]);
}

/**
 * 删除客户
 */

if($customer_id ){
    $customer_delete = $asiabill->request('customers',['path' => [
        'customerId' => $customer_id
    ],'delete' => true]);

    if( $customer_delete['code'] == '0000' ){
        setcookie('ab_customerId',null,-1);
    }
}
