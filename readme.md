#Asiabill PHP SDK

一个集成了Asiabill的payment和openApi接口的组件，通过传递指定请求类型和对应的参数即可完成接口请求。使用前请先阅读Asiabill[接口文档](https://app.gitbook.com/o/x4DAbywbcDWHNZfPmbr4/s/Mb9UzyxGUyxHylm4UJSJ/) 

##PHP要求
* php >= 5.6  
* [curl](https://www.php.net/manual/en/book.curl.php)
* [json](https://www.php.net/manual/en/book.json.php)
* [openssl](https://www.php.net/manual/en/book.openssl.php)


##使用PHP SDK
1、加载AsiabillIntegration.php文件  
```php 
include_once "Classes/AsiabillIntegration.php"; 
```
2、初始化对象
```php
use \Asiabill\Classes\AsiabillIntegration;
$model = 'test'; // test or live
$asiabill = new AsiabillIntegration($model,$gateway_no,$sign_key);
```
3、开启日志，可以通过参数设置目录，如果不开启则跳过这一步
```php 
$asiabill->startLogger($bool，$dir);
```
4、发起payment请求
```php 
$asiabill->request($type,$data);
$asiabill->payment()->request($type,$data);
```
5、发起openapi请求
```php
$asiabill->openapi()->request($type,$data);
```

##参数说明
>type：请求类型：自定义字符串<br/>
>data：请求参数：数组参数，包含path，body，query三个部分

##示例代码
###创建交易：
```php
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
    'callbackUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/Asiabill/return.php',
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
    'returnUrl' => $http_type.'://'.$_SERVER['HTTP_HOST'].'/Asiabill/return.php',
    'webSite' => $_SERVER['HTTP_HOST']
]]);

if($result['code'] == '0000'){
    /* Your business code */
}
```

###查询交易信息：
```php
$asiabill->openapi()->request('orderInfo',['path' => [
    'tradeNo' => $tradeNo
]]);
```

###创建客户：
```php
$asiabill->request('customers',['body' => [
    'description' => 'test customer',
    'email' => '123451234@email.com',
    'firstName' => 'firstName',
    'lastName' => 'lastName',
    'phone' => '13800138000'
]]);
```

###删除客户：
```php
$asiabill->request('customers',['path' => [
    'customerId' => $customer_id
],'delete' => true]);
```

###签名校验
```php
asiabill->verification()
```

###获取webhook数据
```php
$asiabill->getWebhookData();
```

##payment类型

| 类型                    | 说明                | 接口                                                             |
|-----------------------|-------------------|----------------------------------------------------------------|
| customers             | 操作客户（包含创建、修改、删除）  | /customers <br/>/customers/{customerId}                        |
| sessionToken          | 生成会话接口            | /sessionToken                                                  |
| paymentMethods        | 创建支付方式            | /payment_methods                                               |
| paymentMethods_list   | 根据客户获取所有支付方式      | /payment_methods/list/{customerId}                             |
| paymentMethods_update | 更新paymentMethod信息 | /payment_methods/update                                        |
| paymentMethods_query  | 获取支付方式            | /payment_methods/{customerPaymentMethodId}                     |
| paymentMethods_detach | 解绑支付方式            | /payment_methods/{customerPaymentMethodId}/detach              |
| paymentMethods_attach | 客户附加支付方式          | /payment_methods/{customerPaymentMethodId}/{customerId}/attach |
| confirmCharge         | 确认扣款              | /confirmCharge                                                 |
| checkoutPayment       | 获取支付页面地址          | /checkout/payment                                              |


##openApi类型

| 类型           | 说明     | 接口                   |
|--------------|--------|----------------------|
| Authorize    | 预授权    | /AuthorizeInterface  |
| chargebacks  | 拒付查询   | /chargebacks         |
| refund       | 退款申请   | /refund              |
| refund_query | 退款查询   | /refund/{batchNo}    |
| logistics    | 上传物流信息 | /logistics           |
| transactions | 交易流水列表 | /transactions        |
| orderInfo    | 交易详情   | /orderInfo/{tradeNo} |


##添加自定义类型
* $request_type 请求类型，自定义字符，与request第一个参数一致，已经存在的类型不能添加
* $request_path 接口路径，参考asiabill接口文档
```php
$asiabill->addRequest($request_type,$request_path)->request($request_type,$data);
$asiabill->addRequest($request_type,$request_path)->openapi()->request($request_type,$data);
```
