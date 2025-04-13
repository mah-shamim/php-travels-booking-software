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
$router->post('payment/stripe', function() {

    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
    }

    $rand =date('Ymdhis').rand();
    $_SESSION['bookingkey'] = $rand;
    // SUCCESS URL
    $success_url = (root).'payment/success/?token='.$_POST['payload'];
    $gateway = array_column(base()->payment_gateways, null, 'name')['Stripe'];

        \Stripe\Stripe::setApiKey(($gateway->c2));
        
        $amount = ($payload->price) * 100;
        $session = \Stripe\Checkout\Session::create([

        'customer_email' => ($payload->client_email),
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'line_items' => [[
            // 'name' => 'T-shirt',
            // 'description' => 'Comfortable cotton t-shirt',
            // 'images' => ['https://example.com/t-shirt.png'],
            // 'amount' => 2000,
            // 'currency' => 'usd',
            'price_data' => [
            'currency' => ($payload->currency),
            'unit_amount' => $amount,
            'product_data' => [
                'name' => 'Travel Booking',
                'description' => 'Booking for Invoice ' . ($payload->booking_ref_no),
                // 'images' => ['https://example.com/t-shirt.png'],
            ],
            ],
            'quantity' => 1,
        ]],
       
        'success_url' => ($success_url)."&trx_id=000&gateway=stripe&key=".$rand."&type=0",
        'cancel_url' => ($payload->invoice_url),
        ]);

        // SHOW IF THERE IS ERROR 
        if (!isset($session->id)) { echo " STRIPE SETTING ERROR"; die; }

        $session_id = $session->id; ?>

        <script src='https://js.stripe.com/v3/'></script>

        <script>
        function checkout(session_id) {

        var stripe = Stripe('<?=($gateway->c1)?>');
        stripe.redirectToCheckout({
        sessionId: '<?= $session_id; ?>'
        }).then(function (result) {

        });
        }
        </script>

        <style>
            .card-body{display: inline !important;}
        </style>
    
    <?php 

    if($gateway->dev_mode==1){
        $creds = 
            '<p><strong>Payment Test Credentials</strong></p>'.
            '<hr />'.
            '<p><strong>Email</strong> '.$gateway->c3.'</p>'.
            '<p><strong>Password</strong> '.$gateway->c4.'</p>'.
            '<hr />'.
            '<a href="#" type="button" onclick="checkout()" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.($payload->currency).' </small>'.($payload->price).'</a>';
    } else {
        $creds = '<a href="#" type="button" onclick="checkout()" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.($payload->currency).' </small>'.($payload->price).'</a>';
    }

    $body = $creds;
    include "App/Views/Pay_view.php";
    
    });

?>