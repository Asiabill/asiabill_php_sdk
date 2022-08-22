<?php

include_once "main.php";

$session_token = $asiabill->request('sessionToken');

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
        .payment_box>span{
            display: inline-block;
            margin-bottom: 5px;
            color: #888;
        }
        #place{
            margin-top: 15px;
        }
        #place>button{
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
        <div>
            <div class="col-1">
                <h3>Billing / Shipping details</h3>
                <form id="checkout_form">
                    <p class="form_row">
                        <label>First name:</label>
                        <input class="form_val" id="first_name" value="test"/>
                    </p>
                    <p class="form_row">
                        <label>Last name:</label>
                        <input class="form_val" id="last_name" value="test" />
                    </p>
                    <p class="form_row">
                        <label>Country:</label>
                        <select class="form_val" id="country">
                            <option value="US" selected >United States</option>
                            <option value="CN">China</option>
                        </select>
                    </p>
                    <p class="form_row">
                        <label>Street address 1:</label>
                        <input class="form_val" id="address_1" value="address_1" />
                    </p>
                    <p class="form_row">
                        <label>Street address 2:</label>
                        <input class="form_val" id="address_2" value="address_2" />
                    </p>
                    <p class="form_row">
                        <label>City:</label>
                        <input class="form_val" id="city" value="city" />
                    </p>
                    <p class="form_row">
                        <label>Province:</label>
                        <input class="form_val" id="state" value="province" />
                    </p>
                    <p class="form_row">
                        <label>Postcode / ZIP:</label>
                        <input class="form_val" id="postcode" value="04002-0001" />
                    </p>
                    <p class="form_row">
                        <label>Phone:</label>
                        <input class="form_val" id="phone" value="13800138000" />
                    </p>
                    <p class="form_row">
                        <label>Email address:</label>
                        <input class="form_val" id="email" value="test@asiabill.com" />
                    </p>
                </form>
            </div>
            <div class="col-1">
                <h3>Your order：<?=$checkout_data['orderNo']?></h3>
                <table>

                    <tr>
                        <td>Product</td>
                        <td>$6.00</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>$1.00</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>$7.00</td>
                    </tr>
                </table>

                <h3>Payment method</h3>
                <div>
                    <p class="payment_list">
                        <label> <input class="payment_method" type="radio" name="payment"  value="1" checked /> 托管支付</label>
                        <div class="payment_box" id="payment_out">
                            <span>重定向到支付页面</span>
                        </div>
                    </p>
                </div>
                <div>
                    <p class="payment_list">
                        <label><input class="payment_method" type="radio" name="payment" value="2" /> 站内支付</label>
                        <div class="payment_box" id="payment_in">
                            <span>测试卡：4242 4242 4242 4242</span>
                            <div id="asiabill-card-form">
                                <div id="asiabill-card-element" class="ab-elemen"></div>
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </div>
                    </p>
                </div>

                <div id="place">
                    <button>Pay now</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="<?=$asiabill->getJsScript()?>"></script>
<script>
    $(function () {
        try {
            var ab = AsiabillPay('<?=$session_token?>');

            // 初始化
            ab.elementInit("payment_steps", {
                formId: 'asiabill-card-form',
                formWrapperId: 'asiabill-card-element',
                frameId: 'asiabill-card-frame',
                customerId: '',
                autoValidate:true,
                layout: {
                    pageMode:'block',
                    style: {
                        frameMaxHeight: '100', // 设置iframe高度
                        input: {
                            FontSize:14,
                            FontFamily:'',
                            FontWeight:'',
                            Color:'',
                            ContainerBorder:'1px solid #ddd',
                            ContainerBg:'',
                            ContainerSh:''
                        }
                    }
                }
            }).then((res) => {
                console.log("initRES", res)
            }).catch((err) => {
                console.log("initERR", err)
            });

            var address_details = {};

            $('#place').click(function () {

                $(this).attr("disabled",true);

                $('.form_val').each(function () {
                    address_details[$(this).attr('id')] = $(this).val();
                });

                var payment_type = $('.payment_method:checked').val();

                var data = {
                    payment_type: payment_type,
                    address_details: address_details,
                    order_no: '<?=$checkout_data["orderNo"]?>'
                }

                if (payment_type === '1'){
                    request(data);
                }else {

                    var paymentMethodObj = {
                        "billingDetail": {
                            "address": {
                                "city": address_details.city,
                                "country": address_details.country,
                                "line1": address_details.address_1,
                                "line2": address_details.address_2,
                                "postalCode": address_details.postcode,
                                "state": address_details.state
                            },
                            "email": address_details.email,
                            "firstName": address_details.first_name,
                            "lastName": address_details.last_name,
                            "phone": address_details.phone
                        },
                        "card": {
                            "cardNo": "",
                            "cardExpireMonth": "",
                            "cardExpireYear": "",
                            "cardSecurityCode": "",
                            "issuingBank": ""
                        },
                        "customerId": '',
                    };

                    ab.confirmPaymentMethod({
                        apikey: '<?=$session_token?>',
                        trnxDetail: paymentMethodObj
                    }).then((result) => {
                        if( result.data.code === "0" ){
                            // 保存成功
                            data['payment_method_id'] = result.data.data.customerPaymentMethodId
                            request(data);
                        }
                        else {
                            // 保存失败
                            alert(result.data.message);
                        }
                    });


                }

            });


            function request(data){
                $.ajax({
                    url: "server.php",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function (result) {

                        $('#place').attr("disabled",false);

                        if( result.code === 1 && result.redirect !== '' ){
                            location.href = result.redirect;
                        }else {
                            alert(result.msg)
                        }
                    },

                })
            }

        }catch( error ) {
            console.log( error );
        }



    })
</script>
</html>