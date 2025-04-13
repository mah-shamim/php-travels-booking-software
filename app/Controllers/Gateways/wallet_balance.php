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
$router->post('payment/wallet_balance', function() {

    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
    }

    // SUCCESS URL
    $success_url = (root).'payment/success/?token='.$_POST['payload'];
    $gateway = array_column(base()->payment_gateways, null, 'name')['Wallet Balance'];

    $params = array(
        "api_key" => api_key,
        "user_id" => $_SESSION['phptravels_client']->user_id,
    );
    $user = POST(api_url.'profile', $params)->data[0];

    // REDIRECT USER IF THERE IS NO USER SESSION ID 
    if (!isset($_SESSION['phptravels_client']->user_id)){
        REDIRECT($payload->invoice_url);
    }
    
 ?>

    <style>
    .paynow { 
    background: #0064ff;
    width: 100%;
    padding: 14px;
    text-align: center;
    color: #fff;
    border-radius: 5px;
    cursor: pointer; 
    border: transparent
    }
    .card-body { 
        display: block !important
    }
    </style>

<script>
    function pay(){
        document.getElementById("loading").style.display = "flex";
        window.location.href = "<?php echo root.'payment/wallet_balance_pay?payload='.$_POST['payload'].'&user_id='.$_SESSION['phptravels_client']->user_id ?>"
    }
</script>

    <?php 

    if ($payload->currency == $user->currency_id){

        if ($user->balance < $payload->price ){
            $body = '<p>Your '.T::your_balance_is.' <strong>'.($user->currency_id).' '.($user->balance).'</strong> '.T::add_more_balance.'</p>';
        } else {;

        $body = '
        <p> '.T::your_available_balance.' <strong>'.($user->currency_id).' '.($user->balance).'</strong></p>
        <hr />
        <button onclick="pay()" class="paynow">'.T::paynow.'</button>';
        };
        

    } else {
        $body = '<p>'.T::your_wallet_currency_is_different.'</p>';
    };

    include "App/Views/Pay_view.php";
    
    });

    $router->get('payment/wallet_balance_pay', function() {

        $payload = json_decode(base64_decode($_GET['payload']));

        // CALL API GET DATA
        $params = array(
        "api_key" => api_key,
        "price" => ($payload->price),
        "currency" => ($payload->currency),
        "user_id" => $_SESSION['phptravels_client']->user_id,
        );
        $data = POST(api_url.'wallet_booking', $params);

        $success_url = (root).'payment/success/?token='.$_GET['payload'];

        if(isset($data->status)){
            if ($data->status == true){
                REDIRECT($success_url);
            }
        };
    });

?>