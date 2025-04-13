<body onload=display_ct();>
<!-- ================================
       START DASHBOARD NAV
================================= -->
<?php require "Sidebar.php"?>

<!-- ================================
    START DASHBOARD AREA
================================= -->
<section class="dashboard-area">
    <div class="dashboard-content-wrap">
        <?php require "Headbar.php"?>
        <div class="dashboard-main-content">

        <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-box">
                            <div class="form-title-wrap">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-block">
                                        <h3 class="title"><?=T::add_funds?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="form-content">

                                <?php

                                $payload = [
                                'booking_id' => '',
                                'booking_no' => '',
                                'status' => '',
                                'amount_paid' => '',
                                'remaining_amount' => '',
                                'payment_date' => date("d-m-Y"),
                                'txn_id' => '',
                                'token' => '',
                                'logs' => '',
                                'payment_status' => 'paid',
                                'currency' => $currency,
                                'price' => '',
                                'desc' => "Wallet Balance",
                                'invoice_url' => root.'account/add_funds',
                                'success_url' => '',
                                'client_email' => $_SESSION['user_email'],
                                'balance'=>$dashboard_details->balance,
                                'type'=>'wallet'
                                ];
                                
                                ?>

                                <form method="post" action="<?=root?>payment">
                                <input type="hidden" name="payload" value="<?php echo base64_encode(json_encode($payload)) ?>" />

                                <div class="row">

                                <div class="col-md-9">
                                <?php include views."partcials/payment_methods.php"; ?>
                                </div>

                                <div class="col-md-3 contact-form-action">
                                <div class="col-md-12">
                                <span class="input-label"><strong><?=T::amount?> <?=T::in?> <?=$default_currency?></strong></span>
                                <div class="form-group">
                                <span class="form-icon" style="font-size: 14px; font-weight: bold; top: 14px;"><?=$default_currency?></span>
                                <input name="price" class="form-control form-control-lg" type="number" placeholder="" value="50" min="1" style="padding: 12px 20px 10px 48px; font-size: 16px;">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block btn-lg my-3"><?=T::paynow?> <i class="la la-arrow-right"></i></button>
                                <hr>

                                <ul style="font-size: 13px; line-height: 2;">
                                <li><i class="la la-check text-success"></i> <?=T::select_your_payment_method?></li>
                                <li><i class="la la-check text-success"></i> <?=T::add_your_amount?></li>
                                <li><i class="la la-check text-success"></i> <?=T::click_on_paynow?></li>
                                <li><i class="la la-check text-success"></i> <?=T::proceed_to_complete_your_payment?></li>
                                </ul>

                                </div>
                                </div>

                                </div>
                                </form>
                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
                <div class="border-top mt-5"></div>
            </div>
        </div>
    </div>
</section>
<style>
.cta-area,.gateway_pay-later,.gateway_wallet-balance{display:none}
</style>