<?php 
$hashRequest='';
$hashKey=$params['hashKey']; // generated from easypay account
$storeId=$params['storeID'];
$amount=number_format($params['invoiceData']->subtotal_fare, 1, '.', '');
$orderRefNum="FMREFNO_".$params['invoiceid'];
$postBackURL=base_url('gateways/easypaysaController/checkout/'.$orderRefNum);
$expiryDate=$params['expiryDateTime']; // 20190721 112300
$autoRedirect=0;
$paymentMethod='CC_PAYMENT_METHOD';
$emailAddr=$_SESSION['notifyable_user_email'];
$mobileNum=$_SESSION['notifyable_user_mobile'];
// starting encryption
$paramMap = array();
$paramMap['amount']  = $amount;
$paramMap['autoRedirect']  = $autoRedirect;
$paramMap['emailAddr']  = $emailAddr;
$paramMap['expiryDate'] = $expiryDate;
$paramMap['mobileNum'] =$mobileNum;
$paramMap['orderRefNum']  = $orderRefNum;
$paramMap['paymentMethod']  = $paymentMethod;
$paramMap['postBackURL'] = $postBackURL;
$paramMap['storeId']  = $storeId;
// Creating string to be encoded
$mapString = '';
foreach ($paramMap as $key => $val) {
    $mapString .=  $key.'='.$val.'&';
}
$mapString  = substr($mapString , 0, -1);
// Encrypting mapString
// https://stackoverflow.com/questions/32018672/encrypt-using-openssl-in-the-same-way-java-does
$cipher = "AES-128-ECB";
$ivlen = openssl_cipher_iv_length($cipher);
$iv = openssl_random_pseudo_bytes($ivlen);
$hashRequest = openssl_encrypt($mapString, $cipher, $hashKey, $options=0, $iv);
// end encryption;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Easypaysa Init</title>
    <style>
        #cc-form,
        #otc-form {
            display: none;
        }
        .payment-option {
            display: block;
            width: 100%;
            margin: 26px 0px;
            height: 30px;
        }
        .form {
            padding: 0px;
        }
        .radio-circle {
            padding-left: 10px
        }
        .t-disable {
            color: #ddd;
            font-style: italic;
        }
        .logo-easypaisa {
            width: 22%;
            height: auto;
            position: absolute;
            top: 2px;
            right: 0px;
        }
    </style>
</head>
<body>
    <img src="<?=base_url('assets/img/easy-paisa-logo.png')?>" class="logo-easypaisa"/>
    <select name="option" onchange="showOption(this.value)" class="payment-option">
        <option value="">Select Payment Option</option>
        <option value="cc">Credit Card</option>
        <option value="otcOrma">Easypaisa Shop/Easypaisa Mobile Account</option>
    </select>
    <div id='cc-form'>
        <form action="https://easypay.easypaisa.com.pk/easypay/Index.jsf" method="POST" id="easyPayStartForm">
            <input name="storeId" value="<?php echo $storeId; ?>" hidden = "true"/>
            <input name="amount" value="<?php echo $amount; ?>" hidden = "true"/>
            <input name="postBackURL" value="<?php echo $postBackURL; ?>" hidden = "true"/>
            <input name="orderRefNum" value="<?php echo $orderRefNum; ?>" hidden = "true"/>
            <input type ="hidden" name="expiryDate" value="<?php echo $expiryDate; ?>">
            <input type="hidden" name="autoRedirect" value="<?php echo $autoRedirect; ?>" >
            <input type ="hidden" name="paymentMethod" value="<?php echo $paymentMethod; ?>">
            <input type ="hidden" name="emailAddr" value="<?php echo $emailAddr; ?>">
            <input type ="hidden" name="mobileNum" value="<?php echo $mobileNum; ?>">
            <input type ="hidden" name="merchantHashedReq" value="<?php echo $hashRequest; ?>">
            <button type="submit" class="btn btn-primary btn-block">Pay With CC</button>
        </form>
    </div>
    <div id="otc-form">
        <form name="otcForm" action="<?=base_url('gateways/easypaysaController/initTxn')?>" method="POST" onsubmit="otherTxnFormEvent(event)" class="form">
            <div class="form-group">
                <input type="radio" name="txnType" id="OTC" value="OTC" checked>
                <label for="OTC"><strong class="radio-circle">Easypaisa Shop</strong></label><br/>
                <input type="radio" name="txnType" id="MA" value="MA">
                <label for="MA"><strong class="radio-circle">Easypaisa Mobile Account</strong></label>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required value="<?php echo $emailAddr; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Account #</label>
                <input type="text" id="mobile" name="mobile" required value="<?php echo $mobileNum; ?>" class="form-control">
                <span><i>Number format: 03451234567</i></span>
            </div>
            <div class="form-group">
                <input type="hidden" name="orderRefNum" value="<?php echo $orderRefNum; ?>"/>
                <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
                <button type="submit" class="btn btn-primary btn-block">Pay</button>
            </div>
        </form>
    </div>
    <div id="alertBox"></div>
    <script>
        function showOption(option) {
            var alertBox = document.getElementById('alertBox');
            var ccForm = document.getElementById('cc-form');
            var otcForm = document.getElementById('otc-form');
            alertBox.innerHTML = "";
            if(option == 'cc') {
                ccForm.style.display = "block";
                otcForm.style.display = "none";
            } else {
                otcForm.style.display = "block";
                ccForm.style.display = "none";
            }
        }
        function otherTxnFormEvent(event)
        {   
            event.preventDefault();
            var btnText = $('[name=otcForm] button').text();
            $('[name=otcForm] button').text('Processing...');
            var otcForm = $('[name=otcForm]');
            var alertBox = document.getElementById('alertBox');
            var otcFormDiv = document.getElementById('otc-form');
            var endpoint = otcForm.attr('action');
            var payload = otcForm.serialize();
            alertBox.innerHTML = "";
            $.post(endpoint, payload, function(response) {
                $('[name=otcForm] button').text(btnText);
                if(response.status == 'success') {
                    alertBox.innerHTML = '<div class="alert alert-success">'+response.message+'</div>';
                    otcFormDiv.style.display = "none";
                } else {
                    alertBox.innerHTML = '<div class="alert alert-danger">'+response.message+'</div>';
                }
            });
        }
    </script>
</body>
</html>