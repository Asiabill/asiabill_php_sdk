<?php

include_once __DIR__ . "/../classes/AsiabillIntegration.php";

$asiabill = new  \Asiabill\Classes\AsiabillIntegration('test', '12246002','12H4567r');
$asiabill->startLogger();

$trade_no = $_GET['tradeNo'];

if( $trade_no ){

    $result = $asiabill->openapi()->request('transactions',['query' => [
        'startTime' => date('Y-m-d').'T00:00:00',
        'endTime' => date('Y-m-d').'T23:59:59',
        'tradeNo' => $trade_no
    ]]);

    if( $result['code'] == '00000' ){
        $order_result = $result['data']['list'][0];
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asiabill 支付演示页面</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            color: #333333;
        }
        .mast{
            max-width: 66.4989378333em;
            margin-left: auto;
            margin-right: auto;
        }

        #masthead{
            padding-top: 2.617924em;
            padding-bottom: 2.617924em;
            border-bottom: 1px solid #f0f0f0;
        }

        #content>div{
            border: 1px solid #bec7cb;
            border-top: none;
            padding: 20px;
            box-shadow: 0 5px 10px #bec7cb;
        }
        .col-1{
            display: inline-block; vertical-align: top;
            width: 45%;
        }
        form label{
            display: block;
            margin-top: 15px;
            margin-bottom: 3px;
        }
        form input,form select{
            padding: 6px 5px;
            width: 80%;
        }
        table{
            width: 100%;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        table td{
            padding: 10px 0;
        }
        .payment_list{
            margin-top: 10px;
        }
        .payment_box{
            background: #f3f2f2;
            padding: 15px 10px;
        }
        #place{
            margin-top: 15px;
        }
        #place button{
            background-color: #333333;
            border-color: #333333;
            color: #ffffff;
            width: 130px;
            padding: 10px 0;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header id="masthead">
    <div class="mast">
        <img src="https://www.asiabill.com/templates/asb2019/images/logo.png">
        <a target="_blank" href="https://www.asiabill.com/">官方网站</a>
        <a target="_blank" href="https://asiabill.gitbook.io/docs/gai-lan/gai-lan">开发者文档</a>
    </div>
</header>
<div id="content">
    <div class="mast">
        <h3 style="text-align: center"><?=$order_result['tradeStatus']?></h3>
        <table>
            <tr>
                <td>orderNo</td>
                <td><?=$order_result['orderNo']?></td>
            </tr>
            <tr>
                <td>tradeNo</td>
                <td><?=$order_result['tradeNo']?></td>
            </tr>
            <tr>
                <td>tradeAmount</td>
                <td><?=$order_result['tradeAmount']?></td>
            </tr>
            <tr>
                <td>tradeCurrency</td>
                <td><?=$order_result['tradeCurrency']?></td>
            </tr>
            <tr>
                <td>tradeDate</td>
                <td><?=$order_result['tradeDate']?></td>
            </tr>
            <tr>
                <td>tradeInfo</td>
                <td><?=$order_result['tradeInfo']?></td>
            </tr>
        </table>
        <div id="place">
            <a href="checkout.php"><button>返回Checkout</button></a>
        </div>
    </div>
</div>
</body>
</html>
