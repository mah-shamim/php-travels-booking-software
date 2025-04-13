<div class="form-box">
<div class="form-title-wrap">
    <h3 class="title"><?=T::payment_methods?></h3>
</div> 
<div class="form-content">
    <div class="section-tab check-mark-tab text-center pb-4">

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

        <div class="row g-2 w-100">

        <?php
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $segments = explode('/', $actual_link);
        $filteredKeys = array_keys(array_filter($segments, function ($element) {
            return $element === "flights";
        }));
        $gateways = (base()->payment_gateways);
        if(!empty($filteredKeys)){
        if($segments[$filteredKeys[0]] == 'flights'){
            if($booking_data[0]->supplier == "duffel") {
                $output = $gateways;
            }else{
                $output = array_filter($gateways, function ($element) {
                    return $element->name !== 'duffel';
                });
                $output = array_values($output);
            }
        }
        }else {
            $output = array_filter($gateways, function ($element) {
                return $element->name !== 'duffel';
            });
            $output = array_values($output);
        }
        // LOOP FOR AVAILABLE PAYMENT GATEWAYS
        foreach ($output as $i => $item){

        // ACTIVE CLASS FOR COLUMN OF GATEWAY
        if ($i==0){
            $checked ="checked";
        } else {
            $checked ="";
        }

        // hide wallet balance payment option if user is not logged in
        if(!isset($_SESSION['phptravels_client']->user_id)) { echo "<style>.gateway_wallet_balance{display:none}</style>"; }

       ?>

        <label class="nav-item col-md-6 form-check-label nav-item gateway_<?=strtolower(str_replace(' ', '_', $item->name))?>" for="gateway_<?=strtolower(str_replace(' ', '_', $item->name))?>">
            <div class="col-md-12 mb-1 gateway_<?=strtolower(str_replace(' ', '_', $item->name))?>">
                <div id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" class="<?php if ($i==0){echo"active";}?> nav-link ripple form-check nav-link p-2 px-3 m-1 d-flex border" style="justify-content: space-between;border-radius: 4px !important;">
                <div class="d-flex mb-2 input justify-content-start gap-3 align-items-center">
                    <input <?=$checked?> class="form-check-input mx-auto" type="radio" name="payment_gateway" id="gateway_<?=strtolower(str_replace(' ', '_', $item->name))?>" value="<?=strtolower(str_replace(' ', '_', $item->name))?>" required>
                    <span class="d-block pt-2">
                        
                    <?php 
                    $name = strtolower(str_replace('_', ' ', $item->name));
                    if ($name == "pay later") { } else { ?><?=T::pay_with?> <?php } ?>
                    <strong><?=strtolower(str_replace('_', ' ', $item->name))?></strong></span>
                    
                </div>
                <div class="d-block">
                    <img src="<?=root?>assets/img/gateways/<?=strtolower(str_replace(' ', '_', $item->name))?>.png" style="max-height:40px;background:transparent" alt="<?=str_replace('-', ' ', $item->name)?>">
                </div>
                </div>
            </div>
        </label>
       
            <?php }

            // IF USER IS NOT LOGIN REMOVE WALLET OPTION
            if(!isset($_SESSION['phptravels_client']->user_id) == true) { ?>

            <script>
            $('.gateway_wallet-balance').remove();
            </script>

            <?php } ?>

            </div>
        </ul>
    </div>
    
    
    <!-- end section-tab -->
    <!--<div class="tab-content">
        <div class="tab-pane fade show active" id="credit-card" role="tabpanel" aria-labelledby="credit-card-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Card Holder Name</label>
                                <div class="form-group">
                                    <span class="la la-credit-card form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Card holder name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Card Number</label>
                                <div class="form-group">
                                    <span class="la la-credit-card form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Card number">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text">Expiry Month</label>
                                        <div class="form-group">
                                            <span class="la la-credit-card form-icon"></span>
                                            <input class="form-control" type="text" name="text" placeholder="MM">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text">Expiry Year</label>
                                        <div class="form-group">
                                            <span class="la la-credit-card form-icon"></span>
                                            <input class="form-control" type="text" name="text" placeholder="YY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-box">
                                <label class="label-text">CVV</label>
                                <div class="form-group">
                                    <span class="la la-pencil form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="CVV">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Email Address</label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="email" name="email" placeholder="Enter email address">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Password</label>
                                <div class="form-group">
                                    <span class="la la-lock form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-box">
                                <button class="theme-btn" type="submit">Login Account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="payoneer" role="tabpanel" aria-labelledby="payoneer-tab">
            <div class="contact-form-action">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Email Address</label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="email" name="email" placeholder="Enter email address">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text">Password</label>
                                <div class="form-group">
                                    <span class="la la-lock form-icon"></span>
                                    <input class="form-control" type="text" name="text" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-box">
                                <button class="theme-btn" type="submit">Login Account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>-->

    <style>
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
            background:#fff;
            color: var(--theme-bg) !important;
            border: 1px solid var(--theme-bg) !important
        }
    </style>
</div>
</div><!-- end form-box -->