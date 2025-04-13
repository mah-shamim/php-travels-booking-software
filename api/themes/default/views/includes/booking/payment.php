<div class="form-box">
<div class="form-title-wrap">
    <h3 class="title">Your Card Information</h3>
</div>
<div class="form-content">
    <div class="section-tab check-mark-tab text-center pb-4">
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="credit-card-tab" data-toggle="tab" href="#credit-card" role="tab" aria-controls="credit-card" aria-selected="false">
                    <i class="la la-check icon-element"></i>
                    <img src="<?=base_url();?><?=$themeurl;?>assets/images/payment-img.png" alt="">
                    <span class="d-block pt-2">Payment with credit card</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true">
                    <i class="la la-check icon-element"></i>
                    <img src="<?=base_url();?><?=$themeurl;?>assets/images/paypal.png" alt="">
                    <span class="d-block pt-2">Payment with PayPal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payoneer-tab" data-toggle="tab" href="#payoneer" role="tab" aria-controls="payoneer" aria-selected="true">
                    <i class="la la-check icon-element"></i>
                    <img src="<?=base_url();?><?=$themeurl;?>assets/images/payoneer.png" alt="">
                    <span class="d-block pt-2">Payment with payoneer</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>