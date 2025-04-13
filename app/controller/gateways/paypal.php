<?php

// gateway name
$router->post('payment/paypal', function() {
include "app/core/pay_params.php";
?>
<script src="<?=$url?>?client-id=<?=$c1?>&disable-funding=credit,card&currency=<?=$currency?>"></script>
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
                        value: <?=$price?>
                    }
                }]
            });
        },
         onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                // alert('Transaction completed by ' + details.payer.name.given_name + '!');
                window.location.href = '<?=$success_url?>';
            });
        }

        }).render('#paypal-button');
    </script>
    <?php
    $body = "<div style='width:100%' id='paypal-button'></div>";
    include "app/core/pay_view.php";
    ?>
    <hr>
    <p><?=T::oncepaymentcompletedmsg?></p>
<?php });