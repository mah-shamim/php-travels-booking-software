<?php

// PARAMS TO USE FOR GATEWAY
// ===================================>
// Booking REF  -> ($payload->booking_ref_no)
// Invoice URL  -> ($payload->invoice_url)
// Client Email -> ($payload->client_email)
// Price        -> ($payload->price);
// Currency     -> ($payload->currency)
// ===================================>

// GATEWAY NAME CONTROLLER ( IF SPACES IN NAME FOLLOW BY UNDERSCOPE INSTEAD DASH )
$router->post('payment/paypal', function() {

    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
    }
    $rand =date('Ymdhis').rand();
    $_SESSION['bookingkey'] = $rand;
    // SUCCESS URL
    $success_url = (root).'payment/success/?token='.$_POST['payload']."&key=".$rand."&type=0";
    $gateway = array_column(base()->payment_gateways, null, 'name')['PayPal'];
    
 ?>

<style>
    .card-body{display: inline !important;}
</style>

<script src="https://www.paypal.com/sdk/js?client-id=<?=$gateway->c1?>&disable-funding=credit,card&currency=<?=strtoupper($payload->currency)?>"></script>

    <script>
        paypal.Buttons({
        style: {
        layout:  'vertical',
        color:   'blue',
        shape:   'rect',
        label:   'paypal'
        },
         createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?=($payload->price)?>
                    }
                }]
            });
        },
         onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {

                // alert('Transaction completed by ' + details.payer.name.given_name + '!');
                // alert('Transaction completed by ' + details.payer.name + '!');
                // alert('Transaction completed by ' + details.payer + '!');
                // alert('Transaction completed by ' + details + '!');
                // console.log(details.id);
                
                // LOADING ANIMATION
                document.getElementById("loading").style.display = "flex";
                window.location.href = "<?=$success_url?>"+"&trx_id="+details.id+"&gateway="+"paypal";
            });
        }

        }).render('#paypal-button');
    </script>
    
    <?php 

    if($gateway->dev_mode==1){
        $creds = 
             '<p><strong>Payment Test Credentials</strong></p>'.
             '<hr />'.
             '<p><strong>Email</strong> '.$gateway->c3.'</p>'.
             '<p><strong>Password</strong> '.$gateway->c4.'</p>'.
             '<hr />'.
             "<div style='width:100%' id='paypal-button'></div>";
    } else {
        $creds = "<div style='width:100%' id='paypal-button'></div>";
    }

    $body = $creds;
    include "App/Views/Pay_view.php";
    
    });

?>