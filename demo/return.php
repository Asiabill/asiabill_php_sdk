<?php

include "main.php";

use \Asiabill\Classes\AsiabillIntegration;

$asiabill = new AsiabillIntegration('test',$gateway_no,$sign_key);

/**
 * 验证消息结果
 */

if( $asiabill->verification() ){
    /* Your business code */
    echo 'success';
}



