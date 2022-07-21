<?php

include_once __DIR__ . "/../classes/AsiabillIntegration.php";

$asiabill = new  \Asiabill\Classes\AsiabillIntegration('test', '12246002','12H4567r');
$asiabill->startLogger();

/**
 * 验证消息结果
 */
if( $asiabill->verification() ){
    $data = $asiabill->getWebhookData();
    /* Your business code */
}
echo 'success';
exit();



