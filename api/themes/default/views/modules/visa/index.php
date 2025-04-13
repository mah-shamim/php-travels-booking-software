<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-7" style="background-image: url(<?php echo $theme_url; ?>assets/img/visa.jpg)">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list">
                                <strong><?=$filteredCountires['nationality_country']['short_name']; ?></strong> <i class="la la-arrow-right"></i> <strong><?=$filteredCountires['destination_country']['short_name']; ?></strong>
                                <h5 data-wow-duration="0.3s" data-wow-delay="0.6s" class="text-white wow fadeIn sub-title animated animated float-none"><?php echo trans('0590');?></h5>
                            </h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <!--<ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Hotel Booking</li>
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
    START BOOKING AREA
================================= -->
<div class="container">
<div class="form-box">
    <div class="form-title-wrap">
        <h3 class="title"><?=lang('0577')?> <?=lang('0145')?></h3>
    </div>
    <!-- form-title-wrap -->
    <div class="form-content ">
        <div class="contact-form-action">
            <div class="panel panel-primary">
                <div class="panel-body">
                <form method="post" action="<?php echo base_url();?>visa/booking">
                        <input type="hidden" value="<?php echo $fr?>" name="from_country">
                        <input type="hidden" value="<?php echo $ft?>" name="to_country">
                        <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('0171');?></label>
                                <div class="form-group">
                                    <span class="la la-user form-icon"></span>
                                    <input class="form-control" type="text" name="first_name" placeholder="<?php echo trans('0171');?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('0172');?></label>
                                <div class="form-group">
                                    <span class="la la-user form-icon"></span>
                                    <input class="form-control" type="text" name="last_name" placeholder="<?php echo trans('0172');?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('094');?></label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="text" name="email" placeholder="<?php echo trans('094');?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('0175');?> <?php echo trans('094');?></label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="text" name="confirmemail" placeholder="<?php echo trans('0175');?> <?php echo trans('094');?>">
                                    <?php if(!empty($form_errors)){ ?> <p class="text-danger"><?php echo $form_errors?></p> <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('0414');?></label>
                                <div class="form-group">
                                    <span class="la la-phone form-icon"></span>
                                    <input class="form-control" type="text" name="phone" placeholder="<?php echo trans('0414');?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('08');?></label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control datevisa" type="text" name="date" placeholder="<?php echo trans('08');?>" value="<?php echo $date?>" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?php echo trans('0178');?></label>
                                <div class="form-group">
                                    <textarea style="padding-left:15px" class="form-control" placeholder="<?php echo trans('0415');?>" rows="2" name="notes"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 responsive-column">
                       <button type="submit" value="submit" id="sub" class="theme-btn btn-block completebook"><?=lang('086')?></button>
                     </div>
                     </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>