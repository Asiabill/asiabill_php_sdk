<?php

include "main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);
$asiabill->startLogger();
/**
 * 验证消息结果
 */
if( $asiabill->verification() ){
    $data = $asiabill->getWebhookData();
    /* Your business code */
    echo 'success';
}

exit();



