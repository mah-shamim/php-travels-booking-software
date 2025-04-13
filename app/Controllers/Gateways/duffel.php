<?php
$router->post('payment/duffel', function() {

    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
        $payload->price = $_POST['price'];
    }

    $rand =date('Ymdhis').rand();
    $_SESSION['bookingkey'] = $rand;
    // SUCCESS URL
    $success_url = (root).'payment/success/?token='.$_POST['payload']."&key=".$rand."&type=0";
    $gateway = array_column(base()->payment_gateways, null, 'name')['duffel'];

    $payload_pay = json_encode(array(
        'data' => array(
            "amount" => $payload->price,
            "currency" => $payload->currency,
        )
    ));

    $order_url = "https://api.duffel.com/payments/payment_intents";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $order_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_pay);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept-Encoding: gzip';
    $headers[] = 'Duffel-Version: beta';
    $headers[] = 'Authorization: Bearer '.$gateway->c1;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
   // echo $result;
    $d = json_decode( $result);
//   print_r($d->data->id);

    $creds = ' <div id="target"></div>';
    $body = $creds;
    include "App/Views/Pay_view.php";
    ?>

   <link rel="stylesheet" href="https://unpkg.com/@duffel/components@2.7.20/dist/CardPayment.min.css" />
    <script type="text/javascript" src="https://unpkg.com/@duffel/components@2.7.20/dist/CardPayment.umd.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        DuffelComponents.renderCardPaymentComponent('target', {
            duffelPaymentIntentClientToken: '<?=$d->data->client_token?>',
            successfulPaymentHandler: successfulPaymentHandlerFn, // Show 'successful payment' page and confirm Duffel PaymentIntent
            errorPaymentHandler:errorPaymentHandlerFn // Show error page
        })

        function successfulPaymentHandlerFn(){
            $.ajax({
                type: "POST",
                url: 'https://api.phptravels.com/flights/duffel/api/v1/checkpayment',
                data: {id: '<?=$d->data->id?>',c1:'<?=$gateway->c1?>'},
                success: function(data){
                    //console.log(data.data.data);
                     //const obj = JSON.parse(data.data.data);
                    //console.log(obj);
                    if(data.data.data.status == "succeeded"){
                        window.location.href = "<?=$success_url?>"+"&pit_id="+data.data.data.status.id+"&gateway="+"duffel";
                    }else{
                        console.log(obj.data.status);
                        //window.location.href = "http://localhost/v9/";
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr);
                }
            });
        }

        function errorPaymentHandlerFn(){
            // alert(1);
            window.location.href = "<?=root?>";
        }

    </script>

    <?php

});