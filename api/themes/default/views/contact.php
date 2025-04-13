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
                            <h2 class="sec__titles" style="color:#fff"><?php echo trans('0270');?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <!--<ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Pages</li>
                            <li>Contact us</li>
                        </ul>-->
                    </div><!-- end breadcrumb-list -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg>
    </div><!-- end bread-svg -->
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
                        <h3 class="title"><?php echo trans('0270');?></h3>
                        <p class="font-size-15"><?php echo trans('0260');?></p>
                    </div><!-- form-title-wrap -->
                    <div class="form-content ">
                        <div class="contact-form-action">
                            <form  method="post" action="">

                            <?php if(isset($successmsg)){ ?>
                            <div style="margin-bottom: 0px;" class="alert alert-success">
                            <i class="fa fa-check-square-o"></i>
                            <?php echo @$successmsg; ?>
                            </div>
                            <?php } if(!empty($validationerrors)){ ?>
                            <div style="margin-bottom: 0px;" class="alert alert-danger">
                            <i class="fa fa-times-circle"></i>
                            <?php echo $validationerrors; ?>
                            </div>
                            <?php } ?>


                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text"><?php echo trans('0350');?></label>
                                        <div class="form-group">
                                            <span class="la la-user form-icon"></span>
                                            <input id="form_name" type="text" name="contact_name" class="form-control" placeholder="<?php echo trans('0350');?>" required="required" data-error="Name is required.">
                                        </div>
                                    </div>
                                </div><!-- end col-lg-6 -->


                                <div class="col-lg-6 responsive-column">
                                    <div class="input-box">
                                        <label class="label-text"><?php echo trans('094');?></label>
                                        <div class="form-group">
                                            <span class="la la-envelope-o form-icon"></span>
                                            <input id="form_email" type="email" name="contact_email" class="form-control" placeholder="<?php echo trans('094');?>" required="required" data-error="Valid email is required.">
                                        </div>
                                    </div>
                                </div><!-- end col-lg-6 -->

                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text"><?php echo trans('0262');?></label>
                                        <div class="form-group">
                                            <span class="la la-pencil form-icon"></span>
                                          <textarea id="form_message" name="contact_message" placeholder="<?php echo trans('0262');?>" class="message-control form-control"  rows="6" required="required" data-error="Please,leave us a message."></textarea>
                                        </div>
                                    </div>
                                </div><!-- end col-lg-12 -->
                                <div class="col-lg-12">
                                   <div class="g-recaptcha go-right" data-sitekey="6LdX3JoUAAAAAFCG5tm0MFJaCF3LKxUN4pVusJIF"></div>
                                   <br>
                                </div><!-- end col-lg-12 -->
                                <div class="col-lg-12">
                                    <div class="btn-box">
                                       <input type="submit" name="submit_contact"  value="<?php echo trans('086');?>" class="theme-btn" />
                                    </div>
                                </div><!-- end col-lg-12 -->
                            </form>
                        </div><!-- end contact-form-action -->
                    </div><!-- end form-content -->
                </div><!-- end form-box -->
            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
                <div class="form-box">
                    <div class="form-title-wrap">
                        <h3 class="title"><?php echo trans('0548');?></h3>
                    </div><!-- form-title-wrap -->
                    <div class="form-content">
                        <div class="address-book">
                            <ul class="list-items contact-address">

                                <?php if(!empty($res2[0]->contact_address)){ ?>
                                <li>
                                    <i class="la la-map-marker icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?php echo trans('0255');?></h5>
                                    <p class="map__desc">
                                      <?php echo $res2[0]->contact_address; ?>
                                    </p>
                                </li>
                                <?php } ?>

                                <?php if(!empty($res2[0]->contact_phone)){ ?>
                                <li>
                                    <i class="la la-phone icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?php echo trans('061');?></h5>
                                    <p class="map__desc"><?php echo $res2[0]->contact_phone;?></p>
                                </li>
                                <?php } ?>

                                 <?php if(!empty($res2[0]->contact_email)){ ?>

                                <li>
                                    <i class="la la-envelope-o icon-element"></i>
                                    <h5 class="title font-size-16 pb-1"><?php echo trans('094');?></h5>
                                    <p class="map__desc"><a href="mailto:<?php echo $res2[0]->contact_email;?>" class="green2"><?php echo $res2[0]->contact_email;?></a></p>
                                </li>
                                <?php } ?>
                            </ul>
                            <!--<ul class="social-profile text-center">
                                <li><a href="#"><i class="lab la-facebook-f"></i></a></li>
                                <li><a href="#"><i class="lab la-twitter"></i></a></li>
                                <li><a href="#"><i class="lab la-instagram"></i></a></li>
                                <li><a href="#"><i class="lab la-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="lab la-youtube"></i></a></li>
                            </ul>-->
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

<!-- end Main Wrapper -->
<div class="clearfix"></div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--
  <?php if(!empty($res2[0]->contact_address)){ ?>
  <address>
  <?php echo $res2[0]->contact_address; ?>
  </address>
  <?php } ?>

  <script>
      $(document).ready(function(){
      $("address").each(function(){
      var embed ="<iframe width='100%' height='315' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0'   src='//maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
      $(this).html(embed);
      }); });
  </script>-->