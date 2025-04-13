<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-5">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title text-white"><?=T::contactus?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START CONTACT AREA
================================= -->
<section class="contact-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-box">
                    <div class="form-title-wrap">
                        <h3 class="title"><?=T::wedlovetohearfromyou?></h3>
                        <p class="font-size-15"><?=T::sendusamessage?></p>
                    </div><!-- form-title-wrap -->
                    <div class="form-content ">
                        <div class="alert alert-success d-none">
                           <?=T::messagesendsuccessfully?>
                        </div>
                        <div class="contact-form-action">
                            <form method="post" action="<?=root?>contact" class="row">
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text"><?=T::yourname?></label>
                                        <div class="form-group">
                                            <span class="la la-user form-icon"></span>
                                            <input class="form-control" type="text" name="name" placeholder="<?=T::yourname?>">
                                        </div>
                                    </div>
                                </div><!-- end col-lg-6 -->
                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text"><?=T::youremail?></label>
                                        <div class="form-group">
                                            <span class="la la-envelope-o form-icon"></span>
                                            <input class="form-control" type="email" name="email" placeholder="<?=T::youremail?>">
                                        </div>
                                    </div>
                                </div><!-- end col-lg-6 -->
                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text"><?=T::message?></label>
                                        <div class="form-group">
                                            <span class="la la-pencil form-icon"></span>
                                            <textarea class="message-control form-control" name="message" placeholder="<?=T::message?>"></textarea>
                                        </div>
                                    </div>
                                </div><!-- end col-lg-12 -->
                                <div class="row mt-2 g-2">
                                <div class="col-lg-6">
                                    <div class="input-box mx-2">
                                        <div class="recapcha-box pb-4 d-flex align-items-center">
                                            <!--<label class="label-text flex-shrink-0 mr-3 mb-0"><?=T::whatis?> 3 + 5 = &nbsp;</label>
                                            <input class="form-control text-center" id="input" type="text" name="" placeholder="<?=T::answer?>">-->
                                            <div class="g-recaptcha" data-sitekey="6LdX3JoUAAAAAFCG5tm0MFJaCF3LKxUN4pVusJIF" data-callback="correctCaptcha"></div>
                                        </div>
                                    </div>
                                </div><!-- end col-lg-12 -->
                                <div class="col-lg-6">
                                    <div class="btn-box">
                                        <button type="submit" class="btn-block ladda effect" id="button" data-style="zoom-in" disabled><?=T::send?></button>
                                    </div>
                                </div><!-- end col-lg-12 -->
                                </div><!-- end col-lg-12 -->
                            </form>
                        </div><!-- end contact-form-action -->
                    </div><!-- end form-content -->
                </div><!-- end form-box -->
            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
                <div class="form-box">
                    <div class="form-title-wrap">
                        <h3 class="title">Contact Us</h3>
                    </div><!-- form-title-wrap -->
                    <div class="form-content">
                        <div class="address-book">
                            <ul class="list-items contact-address" style="line-height: 6px">
                                <li>
                                    <i class="la la-map-marker icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?=T::address?></h5>
                                    <p class="map__desc" style="white-space: pre-line; line-height: 10px;">
                                       <?=$app->app->address?>
                                    </p>
                                </li>
                                <li>
                                    <i class="la la-phone icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?=T::phone?></h5>
                                    <p class="map__desc"><?=$app->app->phone?></p>
                                </li>
                                <li>
                                    <i class="la la-envelope-o icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?=T::email?></h5>
                                    <p class="map__desc"><?=$app->app->email?></p>
                                </li>
                            </ul>
                        </div>
                    </div><!-- end form-content -->
                </div><!-- end form-box -->
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end contact-area -->
<!-- ================================
    END CONTACT AREA
================================= -->

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
if (location.pathname.substring(1) == 'contact/success'){ $(".alert-success").removeClass("d-none"); };
var correctCaptcha = function(response) { // alert(response);
$('#button').prop('disabled', false); };
</script>