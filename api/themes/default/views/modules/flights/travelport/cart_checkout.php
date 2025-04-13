<?php include('themes/default/header.php') ?>

    <style>
        .nav-tabs>li>a {
            background: rgba(0, 0, 0, 0.09);
            border-radius: 0px;
            color: #000 !important;
            padding: 10px;
            font-size: 14px;
        }
        .nav-tabs>li>a{display:block}
        .nav-tabs>li{flex:1}
        .form-bg-light{background:#f9f9f9}
        .form-control{font-size:1rem!important}
        .nav-tabs>li>a.active{background:#76ce85!important;position:relative}
        .select2-container .select2-choice>.select2-chosen {
            padding-top:7px !important;
        }
        .select2-container .select2-choice {
            float:none !important;
            left: 10px;
        }
        .content-body .ion-location:before{
            float:none !important;
        }
        .select2-container.form-control{
            overflow:hidden;
        }
    </style>
    <!-- start Main Wrapper -->
    <div class="main-wrapper scrollspy-action">
            <div class="container">
                <?php if ($fakedata->sandbox_mode): ?>
                    <div class="alert alert-danger"><?php echo trans('0597');?></div>
                <?php endif; ?>
            </div>

        <div class="page-wrapper page-payment bg-light">
            <div class="container">
                <div class="row gap-30">
                    <div class="col-12 col-lg-4 order-lg-last">
                        <aside class="sticky-kit sidebar-wrapper">
                            <a data-toggle="collapse" href="#details" class="product-small-item">
                                <div class="image">

                                    <img  style="height: 100px; padding: 4px 0px 0px 4px;" src="<?php echo $dataAdapter->summary->carrier->image_path; ?>" style="width: 100%;" alt="<?php echo $dataAdapter->summary->carrier->shortname; ?>">
                                </div>
                                <div class="content">
                                    <div class="content-body">
                                        <h6 class="float-none"</h6>
                                        <?php foreach($dataAdapter->outbound->segment as $segment): ?>
                                            <span class="meta text-muted"><i class="ion-location text-info"></i> <strong><?= $segment->Origin ?></strong> AIRPORT</span>
                                            <div class="row"></div>
                                            <span class="meta text-muted"><i class="ion-location text-info"></i> <strong><?= $segment->Destination ?></strong> AIRPORT </span>
                                            <div class="row"></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </a>
                            <div id="details" class="panel-collapse collapse">
                                <div class="panel-body px-20 bg-white">
                                    <section>
                                        <div>
                                            <h5><strong class="text-primary">Outbound</strong></h5>
                                            <div class="clear"></div>
                                            <?php foreach($dataAdapter->outbound->segment as $segment): ?>
                                                <div class="row">
                                                    <div class="col-md-6 o2">
                                                        <h5 class="float-none go-text-right"><?= trans('08');?></h5>
                                                        <p><?= date('Y-m-d H:i', strtotime($segment->DepartureTime)) ?> </p>
                                                        <p><?= date('Y-m-d H:i', strtotime($segment->ArrivalTime)) ?></p>
                                                    </div>
                                                    <div class="col-md-6 o1 go-text-right">
                                                        <h5 class="float-none"><?php echo $segment->detail->carrier->shortname; ?></h5>
                                                        <p><?= $segment->Origin ?></p>
                                                        <p><?= $segment->Destination ?></p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h5 class="float-none go-text-right"><?= trans('0564');?>: <?php echo $segment->FlightNumber ?></h5>
                                                        <p><?php echo $segment->detail->carrier->fullname; ?></p>
                                                        <p><?= trans('0565');?>:<?php echo sprintf('%s:%s', $segment->detail->totalDuration->hour, $segment->detail->totalDuration->minute); ?></p>
                                                    </div>
                                                    <!--<div class="col-md-2">
                                                        <h5>Class: N/A</h5>
                                                        </div>-->
                                                </div>

                                                <!--/ .row -->
                                            <?php endforeach; ?>
                                            <hr>
                                            <?php if($dataAdapter->summary->triptype == 'round'): ?>
                                                <h5 class="float-none go-text-right"><strong class="text-primary">Inbound</strong></h5>
                                                <?php foreach($dataAdapter->inbound->segment as $segment): ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5 class="float-none go-text-right"><?= trans('08');?></h5>
                                                            <p><?= date('Y-m-d H:i', strtotime($segment->DepartureTime)) ?></p>
                                                            <p><?= date('Y-m-d H:i', strtotime($segment->ArrivalTime)) ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5 class="float-none go-text-right"><?php echo $segment->detail->carrier->shortname; ?></h5>
                                                            <p><?php echo $segment->Origin; ?></p>
                                                            <p><?php echo $segment->Destination; ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5 class='float-none go-text-right'><?= trans('0564');?>:<?php echo $segment->FlightNumber ?></h5>
                                                            <p><?php echo $segment->detail->carrier->fullname; ?></p>
                                                            <p><?= trans('0565');?>:<?php echo sprintf('%s:%s', $segment->detail->totalDuration->hour, $segment->detail->totalDuration->minute); ?></p>
                                                        </div>
                                                        <!--<div class="col-md-2">
                                                            <h5>Economy</h5>
                                                            </div>-->
                                                    </div>
                                                    <!--/ .row -->
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                        </div>
                                    </section>
                                </div>
                                <div class="panel-footer">&nbsp;</div>
                            </div>
                            <div class="clear"></div>
                            <div class="booking-selection-box">
                                <div class="content">
                                    <h5 class="font-serif font400"><?=lang('0411')?></h5>
                                    <div class="clear"></div>
                                    <ul class="booking-amount-list clearfix mb-20">
                                        <li>
                                            <?php
                                                foreach($dataAdapter->outbound->segment  as $key=>$value) {
                                                if($key == 0) { ?>
                                                    <?=lang('0472')?><?=lang('08')?><span class="font700"><?= date('Y-m-d H:i', strtotime($value->DepartureTime)) ?> </span>
                                                <?php }
                                            }
                                            ?>
                                        </li>
                                        <li class="text-right">
                                            <?php
                                            foreach($dataAdapter->outbound->segment  as $key=>$value) {
                                                if($key == 0) { ?>
                                                    <?=lang('0472')?><?=lang('08')?><span class="font700"><?= date('Y-m-d H:i', strtotime($value->ArrivalTime)) ?> </span>
                                                <?php }
                                            }
                                            ?>

                                        </li>
                                    </ul>
                                    <h5 class="font-serif font400"><?=lang('0127')?></h5>
                                    <div class="clear"></div>
                                    <div class="hotel-room-sm-item mb-30">
                                        <div class="the-room-item">
                                            <h6><?=lang('0528')?> <?=lang('0259')?></h6>
                                            <div class="clear"></div>
                                            <span class="amount go-right mr-15"><?=lang('0585')?><?=lang('0442')?></span>
                                            <div class="clear"></div>
                                            <!--<span class="price"></span>-->

                                        </div>
                                        <div class="the-room-item">
                                            <?php
                                            foreach($dataAdapter->outbound->segment as $key=>$value) {
                                                if($key == 0) { ?>
                                                    <h6><i class="ion-location text-info"></i> <?=lang('0273')?>: <?= $value->Origin; ?></h6>
                                                <?php }
                                            }
                                            ?>
                                            <div class="clear">
                                                <h6><i class="ion-location text-info"></i> <?=lang('0274')?>: <?php echo $value->Destination; ?></h6>
                                                <div class="clear"></div>
                                                <!--<span class="price"></span>-->
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="font-serif font400"><?=lang('070')?></h5>
                                    <div class="clear"></div>

                                    <ul class="summary-price-list">
                                        <li><?=lang('0562')?> <span class="absolute-right"><?php echo $dataAdapter->airPricingSolution->ApproximateBasePrice; ?></span></li>
                                        <div class="clear"></div>
                                        <li><?=lang('0563')?> <span class="absolute-right"><?php echo $dataAdapter->airPricingSolution->Taxes; ?></span></li>
                                        <div class="clear"></div>
                                        <li class="total"><?php echo trans('0124');?><span class="text-main absolute-right"><?php echo $dataAdapter->airPricingSolution->TotalPrice; ?></span></li>
                                        <div class="clear"></div>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="content-wrapper">
                            <div class="success-box">
                                <div class="icon">
                                    <span><i class="ri ri-check-square"></i></span>
                                </div>
                                <div class="content">
                                    <h4><?=lang('0566')?></h4>
                                    <div class="clear"></div>
                                    <p class="go-text-right"><?=lang('045')?></p>
                                </div>
                            </div>

                            <?php if($userAuthorization == 0){?>
                                <div class="alert alert-warning pt-10 pb-10 mb-30" role="alert"><i class="fas fa-info-circle mr-5"></i><?=lang('0473')?> <?=lang('0294')?>? <a href="<?php echo base_url(); ?>login" class="letter-spacing-0"><?=lang('0236')?></a></div>
                            <?php } ?>
                            <div class="alert alert-danger text-center font-size-h2" id="countdown">00:00</div>
                            <?php if($userAuthorization == 0){?>
                                <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                    <form action="" method="POST" id="loginform" class="booking_page">
                                        <div class=" row form-group">
                                            <div class="col-md-12 col-12">
                                                <label><?php echo trans('094');?> <span class="font12 text-danger">*</span></label>
                                                <input class="form-control form-bg-light" type="text" placeholder="Email" name="username" id="username"  value="">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12 col-12">
                                                <label><?php echo trans('095');?> <span class="font12 text-danger">*</span></label>
                                                <input class="form-control form-bg-light" type="password" placeholder="<?php echo trans('095');?>" name="password" id="password"  value="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>

                            <form class="bg-white-shadow pt-25 ph-30 pb-40 mt-30" name="ticketBookingForm" action="<?=base_url('flight/cart/placeorder')?>" method="post">
                                <h3 class="heading-title mt-30"><span><?=lang('0460')?></span></h3>
                                <div class="clear"></div>
                                <p class="post-heading go-text-right"><?=lang('045')?></p>
                                <div>
                                    <div class="row gap-20 mb-0">
                                        <div class="col-md-12">
                                            <?php $total_forms = 0; ?>
                                            <?php foreach($dataAdapter->searchPassenger as $index => $searchPassenger): ?>
                                                <section>
                                                    <h4 class="mb-0"><strong class="text-primary"></strong></h4>
                                                    <div class="clear"></div>
                                                    <hr>
                                                    <div class="row row-reverse">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="title"><?=lang('089')?></label>
                                                                <select class="form-control" id="title" name="title[]" required>
                                                                    <option value="Mr."><?php echo trans('0567');?>.</option>
                                                                    <option value="Ms."><?php echo trans('0568');?>.</option>
                                                                    <option value="Master."><?php echo trans('0569');?>.</option>
                                                                    <option value="Miss."><?php echo trans('0570');?>.</option>
                                                                    <option value="Mrs."><?php echo trans('0571');?>.</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="name"><?=lang('0350')?></label>
                                                                <input type="text" class="form-control" id="firstname" name="firstname[]" required value="<?php echo $fakedata->first_name; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="surname">Surname</label>
                                                                <input type="text" class="form-control" id="lastname" name="lastname[]" required value="<?php echo $fakedata->last_name; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email"><?=lang('094')?></label>
                                                                <input type="text" class="form-control" id="email" name="email[]" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="phone"><?=lang('092')?></label>
                                                                <input type="text" class="form-control" id="phone" name="phone[]" required value="<?php echo $fakedata->phone_number; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row row-reverse">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nationality"><?php echo trans('0572');?>:</label>
                                                                <input type="text" class="form-control" id="nationality" name="nationality[]" required value="<?php echo $fakedata->nationality; ?>">

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="hidden" readonly class="form-control" id="code" name="code[]" required value="<?php echo $searchPassenger['Code']; ?>">
                                                            <input type="hidden" readonly class="form-control" id="code" name="formsCount" required value="<?php echo $total_forms; ?>">
                                                        </div>
                                                    </div>

                                                </section>
                                                <?php $total_forms += 1; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="mb-40"></div>
                                    <h3 class="heading-title"><span><?=lang('0407')?></span></h3>
                                    <div class="clear"></div>
                                    <p class="post-heading go-text-right"><?=lang('0159')?></p>
                                    <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                        <div class="clear mb-20"></div>
                                        <h6><?=lang('0265')?></h6>
                                        <div class="clear"></div>
                                        <div class="payment-option-box">
                                            <div class="payment-option-item">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="paymentOptionCreditBar" name="paymentOption" class="custom-control-input" checked  />
                                                    <label class="custom-control-label" for="paymentOptionCreditBar"><?=lang('0609')?></label>
                                                    <div class="clear"></div>
                                                    <div class="payment-desc">
                                                        <div class="card-form">
                                                            <div class="row gap-20 mb-0 row-reverse">
                                                                <div class="col-md-6">
                                                                    <div class="form-group ">
                                                                        <label  class="required"><?php echo trans('0330');?></label>
                                                                        <div class="clear"></div>
                                                                        <select class="form-control" name="cardtype" id="cardtype" required>
                                                                            <option value=""><?php echo trans('0573');?></option>
                                                                            <option value="AX"><?php echo trans('0574');?></option>
                                                                            <option value="DS"><?php echo trans('0575');?></option>
                                                                            <option value="CA" <?=($fakedata->sandbox_mode) ? 'selected' : ''?>><?php echo trans('0576');?></option>
                                                                            <option value="VI"><?php echo trans('0577');?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group ">
                                                                        <label  class="required"><?php echo trans('0316');?></label>
                                                                        <input type="text" class="form-control" name="cardno" value="<?php echo $fakedata->card_number; ?>" required id="card-number" placeholder="Credit Card Number">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row row-reverse">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label  class="required  go-right font-size-12"><?php echo trans('0329');?></label>
                                                                        <select class="form-control" name="expMonth" id="expiry-month" required>
                                                                            <option value=""><?php echo trans('0578');?></option>
                                                                            <option value="01"><?php echo trans('0317');?> (01)</option>
                                                                            <option value="02"><?php echo trans('0318');?> (02)</option>
                                                                            <option value="03"><?php echo trans('0319');?> (03)</option>
                                                                            <option value="04"><?php echo trans('0320');?> (04)</option>
                                                                            <option value="05"><?php echo trans('0321');?> (05)</option>
                                                                            <option value="06"><?php echo trans('0322');?> (06)</option>
                                                                            <option value="07"><?php echo trans('0323');?> (07)</option>
                                                                            <option value="08"><?php echo trans('0324');?> (08)</option>
                                                                            <option value="09"><?php echo trans('0325');?> (09)</option>
                                                                            <option value="10"><?php echo trans('0326');?> (10)</option>
                                                                            <option value="11"><?php echo trans('0327');?> (11)</option>
                                                                            <option value="12" <?=($fakedata->sandbox_mode) ? 'selected' : ''?>><?php echo trans('0328');?> (12)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label  class="required go-right">&nbsp;</label>
                                                                        <select class="form-control" name="expYear" id="expiry-year" required>
                                                                            <option value=""><?php echo trans('0579');?></option>
                                                                            <?php for($y = date("Y");$y <= date("Y") + 10;$y++): ?>
                                                                                <?php
                                                                                $selected = "";
                                                                                if ($fakedata->sandbox_mode) {
                                                                                    if ($y == (date("Y") + 10)) {
                                                                                        $selected = 'selected';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo $y?>" <?=$selected?>><?php echo $y; ?></option>
                                                                            <?php endfor; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label  class="required go-right"><?php echo trans('0331');?></label>
                                                                        <input type="text" class="form-control" name="security_code" required id="cvv" placeholder="<?php echo trans('0331');?>" value="<?php echo $fakedata->cvv; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label  class="required go-right">&nbsp;</label>
                                                                    <img src="<?php echo base_url(); ?>assets/img/cc.png" class="img-responsive" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="payment-option-item">
                                        <div class="custom-control custom-radio">
                                                <input type="radio" id="paymentOptionPaypal" name="paymentOption" class="custom-control-input">
                                                <label class="custom-control-label" for="paymentOptionPaypal">Paypal</label>
                                                <div class="clear"></div>
                                                <div class="payment-desc">
                                                        <p><?=lang('0610')?></p>
                                                        <a href="#" class="btn btn-primary"><?=lang('0611')?></a>
                                                </div>
                                        </div>
                                        </div>-->
                                        </div>
                                    </div>
                                </div>
                                <!--/ ."panel panel-default: Payment Information -->
                                <div class="alert alert-danger mt-20">
                                    <strong class="RTL go-right"><?php echo trans('045');?></strong>
                                    <hr>
                                    <p class="RTL" style="font-size:12px"><?php echo trans('0461');?></p>
                                </div>
                                <div class="mb-40"></div>
                                <div class="custom-control custom-checkbox form-group acceptterm">
                                    <input type="checkbox" class="custom-control-input" id="acceptTerm" />
                                    <label class="custom-control-label" for="acceptTerm"><?=lang('0416')?></label>
                                </div>
                                <!--<input type="hidden" name="dataAdapter" value=''>
                                <input type="hidden" name="flight_id" value=''>-->
                                <button onclick="scrollWin(0, -15000)" type="submit" class="btn btn-primary btn-lg btn-block completebook upClick" id="confirmBooking"><?php echo trans('0335');?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="fullwidth-horizon-sticky border-0">&#032;</div>
                <!-- is used to stop the above stick menu -->
            </div>
        </div>
    </div>
    <!-- end Main Wrapper -->
    <!--/ .scroll up -->
    <script>
        function scrollWin(x, y) {
            window.scrollBy(x, y);
        }
    </script>
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
//            $("[name='ticketBookingForm']").on('submit', function(e) {
//                e.preventDefault();
//               alert("fff");
//            });
        });
    </script>
<?php include('themes/default/footer.php') ?>