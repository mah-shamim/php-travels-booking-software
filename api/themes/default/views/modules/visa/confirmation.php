<section class="payment-area section-bg section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-box payment-received-wrap mb-0">
                    <div class="form-title-wrap">
                        <div class="step-bar-wrap text-center">
                            <ul class="step-bar-list d-flex align-items-center justify-content-around">
                                <li class="step-bar flex-grow-1 step-bar-active">
                                    <span class="icon-element"></span>
                                    <p class="pt-2 color-text-2"><?=lang('0619')?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-content">
                        <div class="payment-received-list">
                            <div class="d-flex align-items-center">
                                <i class="la la-check icon-element flex-shrink-0 mr-3 ml-0"></i>
                                <div>
                                    <h3 class="title pb-1"><?=trans('0654')?></h3>
                                    <h3 class="title"><?=lang('0620')?></h3>
                                </div>
                            </div>
                            <ul class="list-items py-4">
                                <li><i class="la la-check text-success mr-2"></i><strong class="text-black"><?=lang('0621')?></strong></li>
                                <li><i class="la la-check text-success mr-2"></i><?=lang('0622')?> : <strong><?php echo $res_cod;?></strong></li>
                            </ul>
                            <div class="btn-box pb-4">
                            <a class="theme-btn mb-2 mr-2" href="<?php echo base_url()?>visa/invoice/<?php echo $res_cod;?>"><?=lang('0348')?></a>
                            <a href="<?php echo base_url(); ?>" class="theme-btn mb-2 theme-btn-transparent"><?=lang('062')?></a>
                            </div>
                            <!--<h3 class="title"><a href="#" class="text-black">EnVision Hotel Boston</a></h3>
                            <p>New York City, NY, USA</p>
                            <p class="py-1"><a href="#" class="text-color">Click for directions on Google maps <i class="la la-arrow-right"></i></a></p>
                            <p><strong class="text-black mr-1">Phone:</strong>+ 00 222 44 5678</p>
                            <ul class="list-items list-items-3 list-items-4 py-4">
                                <li><span class="text-black font-weight-bold">Your reservation</span>2 Nights, 1 Room</li>
                                <li><span class="text-black font-weight-bold">Check-in</span>Thu 30 Mar, 2020</li>
                                <li><span class="text-black font-weight-bold">Check-out</span>Sat 01 Jun, 2020</li>
                                <li><span class="text-black font-weight-bold">Prepayment</span>You will be charged a prepayment of the total price at any time.</li>
                                <li><span class="text-black font-weight-bold">Cancellation cost</span>From now on: USD 34</li>
                            </ul>
                            <div class="btn-box">
                                <a href="#" class="theme-btn border-0 text-white bg-7">Cancel your booking</a>
                            </div>-->
                        </div><!-- end card-item -->
                    </div>
                </div><!-- end payment-card -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>