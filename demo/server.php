<?php

include_once "main.php";


if( isset($_POST['address_details']) ){

    $checkout_data['orderNo'] = $_POST['order_no'];

    $address_details = $_POST['address_details'];

    if( $_POST['payment_type'] == '1' ){

        $checkout_data['billingAddress'] = [
            'address' => $address_details['address_1'].' '.$address_details['address_2'],
            'city' => $address_details['city'],
            'country' => $address_details['country'],
            'firstName' =>  $address_details['first_name'],
            'lastName' =>  $address_details['last_name'],
            'phone' => $address_details['phone'],
            'state' => $address_details['state'],
            'zip' => $address_details['postcode'],
            'email' => $address_details['email'],
        ];
        $checkout_data['deliveryAddress'] = [
            'shipAddress' => $address_details['address_1'].' '.$address_details['address_2'],
            'shipCity' => $address_details['city'],
            'shipCountry' => $address_details['country'],
            'shipFirstName' =>  $address_details['first_name'],
            'shipLastName' =>  $address_details['last_name'],
            'shipPhone' => $address_details['phone'],
            'shipState' => $address_details['state'],
            'shipZip' => $address_details['postcode']
        ];

        $result = $asiabill->request('checkoutPayment', ['body' => $checkout_data]);

        if($result['code'] == '0000'){
            /* Your business code */
            echo json_encode([
                'code' => 1,
                'redirect' => $result['data']['redirectUrl']
            ]);
        }else{
            echo json_encode([
                'code' => 0,
                'msg' => $result['message']
            ]);
        }


    }
    else{
        $checkout_data['shipping'] = [
            'address' => [
                'line1' => $address_details['address_1'],
                'line2' => $address_details['address_2'],
                'city' => $address_details['city'],
                'country' => $address_details['country'],
                'state' => $address_details['state'],
                'zip' => $address_details['postcode']
            ],
            'email' => $address_details['email'],
            'firstName' => $address_details['first_name'],
            'lastName' => $address_details['last_name'],
            'phone' => $address_details['phone'],
        ];
        $checkout_data['customerIp'] = $asiabill::clientIP();
        $checkout_data['tokenType'] = '';
        $checkout_data['customerPaymentMethodId'] = $_POST['payment_method_id'];

        $result = $asiabill->request('confirmCharge',['body' => $checkout_data]);

        if( $result['code'] == '00000' ){

            if( !empty($result['data']['redirectUrl']) ){
                echo json_encode([
                    'code' => 1,
                    'redirect' => $result['data']['redirectUrl']
                ]);
            }
            elseif( in_array($result['data']['orderStatus'],['success','pending']) ) {
                echo json_encode([
                    'code' => 1,
                    'redirect' => 'return.php?tradeNo='.$result['data']['tradeNo']
                ]);
            }
            else{
                echo json_encode([
                    'code' => 0,
                    'msg' => $result['data']['message']
                ]);
            }

        }else{
            echo json_encode([
                'code' => 0,
                'msg' => $result['message']
            ]);
        }

    }

}
