<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-action">
    <!--<div class="page-title breadcrumb-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Desinations</a></li>
                    <li class="breadcrumb-item"><a href="#">City</a></li>
                    <li class="breadcrumb-item"><a href="#">Result</a></li>
                    <li class="breadcrumb-item"><a href="#">Detail</a></li>
                    <li class="breadcrumb-item"><a href="#">Payment</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
                </ol>
            </nav>
        </div>
    </div>-->
    <div class="page-wrapper page-confirmation bg-light">
        <div class="container">
            <div class="success-box">
                <div class="icon">
                    <span><i class="ri ri-check-square"></i></span>
                </div>
                <div class="content">
                    <h4><?=lang('0335')?></h4>
                    <p><?=lang('0336')?></p>
                    <a href="javascript:void(0)" class="btn btn-dark btn-wide"><?=lang('0145')?> <?=lang('080')?> : <?=$bookingstatus?></a>
                </div>
            </div>
            <div class="row gap-30 equal-height">
                <div class="col-12 col-lg-4 order-lg-last">
                    <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
                        <div class="row product-small-item" style="-webkit-box-shadow: none !important">
                        <div class="col-4">
                        <br>
                        <img class="panel-body" src="<?=$taxi_image;?>" alt="image">
                        </div>
                        <div class="col-8">
                        <h6><?=$taxi_name;?></h6>
                        <span class="meta text-muted"><i class="ion-location text-info"></i> <?=$flight_form;?></span>
                        <div class="clear"></div>
                        <span class="meta text-muted"><i class="ion-location text-info"></i> <?=$loaction;?></span>
                        <!--<div class="price">from <span class="text-secondary font700">$895</span> /night</div>-->
                        </div>
                        </div>
                        <hr>
                        <h3 class="heading-title"><span><?=lang('039')?></span></h3>
                        <hr class="mb-30 mt-30" />
                        <ul class="confirmation-list">
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0564')?> <?=lang('0273')?>:</span>
                                <span><?=$flight_form;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0564')?> <?=lang('0434')?>:</span>
                                <span><?=$flight_no;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0211')?> <?=lang('08')?>:</span>
                                <span><?=$date?></span>
                            </li>

                        </ul>
                        <div class="mb-40"></div>
                        <ul class="confirmation-list">
                            <!--<li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0560')?>:</span>
                                <span>2 Nights</span>
                            </li>-->
                            <!--<li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0601')?>:</span>
                                <span>Included</span>
                            </li>-->
                            <li class="clearfix total">
                                <span class="font-weight-bold"><?=lang('0124')?></span>
                                <span class="text-main text-secondary"><?=$currency?> <?=$amount;?></span>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="content-wrapper pt-30 pb-30 bg-white-shadow col-12">
                        <h3 class="heading-title"><span><?=lang('0127')?></span></h3>
                        <ul class="confirmation-list">
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0398')?>:</span>
                                <span>#<?=$id;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0594')?>:</span>
                                <span><?=$bookingToken;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('090')?>:</span>
                                <span><?=$first_name;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('091')?>:</span>
                                <span><?=$last_name;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('092')?>:</span>
                                <span><?=$phone;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('094')?>:</span>
                                <span><?=$email;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0564')?> <?=lang('0434')?>:</span>
                                <span><?=$flight_no;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0564')?> <?=lang('0273')?>:</span>
                                <span><?=$flight_form;?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('0583')?> <?=lang('0259')?>:</span>
                                <span><?=$date?></span>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('032')?>:</span>
                                <span><?=$loaction;?></span>
                            </li>

                            
                            <li class="clearfix">
                                <span class="font-weight-bold"><?=lang('080')?>:</span>
                                <span><?=$status?></span>
                            </li>

                        </ul>
                        <div class="mb-40"></div>
                        <hr>
                        <textarea name="" id="" rows="10" class="form-control text-left" disabled><?=$taxi_msg;?></textarea>
                        <!--<h3 class="heading-title"><span>Payment</span></h3>
                        <div class="clear"></div>-->
                        <!--<p class="text-uppercase text-secondary font600">Payment is made by credit card via Paypal</p> -->
                     </div>
                </div>
            </div>
            <div class="row mt-25">
                <div class="col-md-6 float-left">
                    <h6 class="text-uppercase letter-spacing-2 line-1 font500"><span><?=lang('0293')?></span></h6>
                    <ul class="list-icon-data-attr font-ionicons">
                        <li data-content="&#xf383"><?=lang('0295')?></li>
                        <li data-content="&#xf383"><?=lang('0308')?></li>
                        <li data-content="&#xf383"><?=lang('0352')?></li>
                    </ul>
                </div>
                <div class="col-md-6 float-right text-right">
                    <div class="featured-contact-01">
                    <h6>
                    <strong>
                    <?php if( ! empty($phone) ) { ?>
                    <span class="phone-number">
                    <i class="material-icons">phone</i><!--<?php echo trans('0438');?>--> <?php echo $phone; ?>
                    </span>
                    <?php } ?>
                    </strong>
                    <small>
                    <?php if( ! empty($contactemail) ) { ?>
                    <a href="mailto:<?php echo $contactemail; ?>"><?php echo $contactemail; ?></a>
                    <?php } ?>
                    </small>
                    </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Main Wrapper -->