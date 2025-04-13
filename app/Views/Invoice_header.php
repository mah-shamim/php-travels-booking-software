
<div class="bg-light">
    <div class="container pt-5 pb-5" style="max-width: 800px;">
    <div class="card p-3 mx-auto" id="invoice" >
            <div class="border p-3 mb-3">
            <div class="row">
                <div class="col-sm-4 d-flex align-items-center justify-content-center ">
                    <img src="<?=root?>/uploads/global/logo.png" style="max-width: 140px" class="logo px-1 rounded">
                </div>
                <div class="col-sm-8 text-right invoice_contact d-flex justify-content-end gap-3">
                   <div> 
                    <p class="mb-0 text-start"><strong><?=T::payment?> <?=T::status?></strong> <span class="text-danger"><?=$data->payment_status?></span></p>
                    <p class="mb-0 text-start"><strong><?=T::booking?> <?=T::status?></strong> <span class="text-success"><?=$data->booking_status?></span></p>

                    <?php if (!empty(app()->app->contact_phone)){?>
                    <p class="mb-0 text-start"><strong><?=T::phone?> </strong> <?=app()->app->contact_phone?></p>
                    <?php } ?>

                    <?php if (!empty(app()->app->contact_phone)){?>
                    <p class="mb-0 text-start"><strong><?=T::email?> :</strong> <?=app()->app->contact_email?></p>
                    <?php } ?>

                </div>

                <script>
                let theQuery = window.location.href;
                if(theQuery.length>0) {
                $.ajax({
                type: "POST",
                url: "<?=root?>qr",
                cache: false,
                data: { get_qr: theQuery },
                error: function(msg) {
                alert(msg);
                },
                success: function(text) {
                $("#InvoiceQR").html(text);
                }})
                } else { alert('Error generating QR'); }
                </script>

                <div id="InvoiceQR" style="width:80px;height:80px;">
                <img src="<?=root?>assets/img/qr.png" style="max-width: 80px;">
                </div>

                </div>
            </div>
            </div>

            <?php

            // HIDE WALLET BALANCE OPTION IF USER IS NO LOGGED IN
            if(!isset($_SESSION['phptravels_client']->user_id)) { echo "<style>.wallet_balance{display:none}</style>"; }
            if ($data->cancellation_request==1){}else{
            if($data->payment_status=="unpaid"){?>

            <form  id="form_gateway" action="" method="post" class="border p-3 rounded mb-3 bg-light no_print">
            <div class="row g-2">
            <div class="col-md-2 pt-1 d-flex align-items-center justify-content-center"><strong><?=T::pay_with?></strong></div>
            <div class="col-md-4">

            <select <?php if($data->payment_gateway=="pay_later"){echo "disabled";} ?> id="gateway" onchange="changeFormAction()" class="selectpicker payment_gateway w-100 rounded-0" name="payment_gateway" data-live-search="true" required>
                <?php foreach(base()->payment_gateways as $p) { ?>
                <option class="<?=strtolower(str_replace(' ', '_', $p->name))?>" value="<?=strtolower(str_replace(' ', '_', $p->name))?>" data-content="<img class='' src='<?=root?>assets/img/gateways/<?=strtolower(str_replace(' ', '_', $p->name))?>.png' style='max-height: 30px; margin-right: 14px; border-radius: 8px; color: #fff;'><span class='text-dark'> <?=$p->name?> </span>"> </option>
                <?php } ?>
            </select>

            <?php 
            // SHOW SELECTED GATEWAY IF USER IS LOGGED IN ONLY 
            if(isset($_SESSION['phptravels_client']->user_id)) {?>
            <script>
            $('.payment_gateway option[value=<?=$data->payment_gateway?>]').attr('selected','selected');
            </script>
            <?php } else { 
            
            if ($data->payment_gateway != "wallet_balance"){
            ?>
            
            <script>
            $('.payment_gateway option[value=<?=$data->payment_gateway?>]').attr('selected','selected');
            </script>

            <?php
            } } ?>

            <div id="response"></div>
            </div>
            <div class="col-md-3">
            <input type="hidden" name="payload" value="">
            <?php if($data->payment_gateway=="pay_later"){}else{ ?>
            <input id="form" type="submit" class="btn btn-success w-100" value="Proceed" style="height: 58px;">
            <?php } ?>
            </div>
            <div class="col-md-3 text-center d-flex align-items-center justify-content-center mt-3"><strong class=""><h5><small style="font-weight:300;font-size:16px"><?=$data->currency_markup?></small> <strong><?=$data->price_markup?></strong></h5></strong></div>
            </div>

            <?php
                // CURRENT URL
                $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                // GET URL
                $url = explode('/', $_GET['url']);
                        
                if(!empty(json_decode($data->user_data)->user_id)){
                    $user_id = (json_decode($data->user_data)->user_id);
                } else {
                    $user_id = "";
                }

                $payload = [
                'booking_ref_no' => $data->booking_ref_no,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_date' => date("d-m-Y"),
                'currency' => $data->currency_markup,
                'price' => $data->price_markup,
                'desc' => 'Invoice ID'. $data->booking_ref_no,
                'client_email' => (json_decode($data->user_data)->email),
                'invoice_url' => $link,
                'type' => 'invoice',
                'user_id' => $user_id,
                'module_type' => $data->module_type,
                ];

            ?>
                
            <input type="hidden" name="payload" value="<?php echo base64_encode(json_encode($payload)) ?>" />

            </form>

            <script>
            function changeFormAction() {
            var selectValue = document.getElementById("gateway").value;
            document.getElementById("form_gateway").action = "<?=root?>payment/"+selectValue.replace(/\s/g, '_').toLowerCase();;
            }

            $(document).ready(function(){
            var selectValue = document.getElementById("gateway").value;
            document.getElementById("form_gateway").action = "<?=root?>payment/"+selectValue.replace(/\s/g, '_').toLowerCase();;
            });
            </script>
            
            <?php } }?>

            <?php if(!empty($data->error_response)){ ?>
            <div class="alert alert-danger">
            <p><strong>Error</strong></p>
            <?=pre($data->error_response)?>
            </div>
            <?php } ?>

            <?php if($data->cancellation_request==1){ ?>
            <div class="alert alert-danger">
            <p class="m-0"><?=T::cancellation_request_msg?></p>
            </div>
            <?php } ?>

            <style>
                .pay_later{display:none}
                @media screen and (max-width: 767px) {
                    .invoice_contact p {
                        font-size: 10px;
                    }
                    
                }
            </style>