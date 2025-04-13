<?php

// includec curl for balance call
use Curl\Curl;

// page route with post method
$router->post('payment/wallet-balance', function() {

// included invoice params to se for wallet
include "app/core/pay_params.php";

// curl call to get user balance based on his ID
$req = new Curl();
$req->get(api_url.'api/login/dashboard?appKey='.api_key.'&user_id='.$_SESSION['user_id']);
$res = json_decode($req->response);
$resp = $res->response;
$balance = $resp->balance;
$user_curr = $resp->currency;

// user currency based on his ID
$user_currency = $user_curr;

// user currency error alert to show on checkout page
if ($currency == $user_currency ){ $currency_error = ""; } else { $currency_error = '<div class="alert"> '.T::your_account_currency_is_different.' </div>'; }

// calculation between balance and price for wallet checkout
$update_balance = $balance - $price;

// if balance is less then hide checkout form and button alert balance low error
if ($balance < $price ) { $form = 0; } else { $form = 1; };

// if balance is low then show alert message to add funds in wallet
if ($balance < $price ) { $balance_alert = '<div class="alert"> '.T::your_account_balance_is_low.' </div>
<p style="text-align:center;"><span style="background: #f1f7fc; border: 1px solid #cde2ee; padding: 5px 14px; border-radius: 15px;">'.T::amount_to_pay.' <strong><small>'.$currency.' </small>' .$price.'<strong></span></p>'; };

// show alert
if (isset($balance_alert)){ $alert = $balance_alert; } else { $alert =""; }

// checkout form and button for wallet
if ($form == 1 ){ $forms = '
<form id="form" action="'.root.'account/balance" method="post">
<input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'" />
<input type="hidden" name="balance" value="'.$update_balance.'" />
<input type="hidden" name="success_url" value="'.$success_url.'" />
<input type="hidden" name="currency" value="'.$user_currency.'" />
<button href="'.$balance.'" style="background: #00BD3F" class="pay"/>'.T::paynow.' <small> '.$currency.' </small>'.$price.'</button>
</form>
'; }

else { $forms = ''; }

// page body for payment view page
$body = '
<style>.card-body{display:block !important}</style>
<p style="text-align:center">'.T::available_balance.' <strong><small>'.$user_curr.'</small> '.$balance.'</strong> </p>
<hr>

'.$currency_error.' '.$alert.' '.$forms.'';

// include payment view page
include "app/core/pay_view.php";
});