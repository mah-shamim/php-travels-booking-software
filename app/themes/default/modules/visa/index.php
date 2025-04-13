<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-7" style="background-image: url(<?=root.theme_url?>assets/img/visa.jpg)">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list text-center my-5" style="text-transform:uppercase">
                                <strong><?=$from_country?></strong> <i class="la la-arrow-right"></i> <strong><?=$to_country?></strong>
                                <h5 data-wow-duration="0.3s" data-wow-delay="0.6s" class="text-white wow fadeIn sub-title animated animated text-center mt-3"><?=$date?></h5>
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
        <h3 class="title"><?=T::submissionform?></h3>
    </div>
    <!-- form-title-wrap -->
    <div class="form-content ">
        <div class="contact-form-action">
            <div class="panel panel-primary">
                <div class="panel-body">
                <form method="post" action="<?=root;?>submit/visa">
                        <input type="hidden" value="<?=$from_country?>" name="from_country">
                        <input type="hidden" value="<?=$to_country?>" name="to_country">
                        <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::firstname?></label>
                                <div class="form-group">
                                    <span class="la la-user form-icon"></span>
                                    <input class="form-control" type="text" name="first_name" placeholder="<?=T::firstname?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::lastname?></label>
                                <div class="form-group">
                                    <span class="la la-user form-icon"></span>
                                    <input class="form-control" type="text" name="last_name" placeholder="<?=T::lastname?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::email?></label>
                                <div class="form-group">
                                    <span class="la la-envelope form-icon"></span>
                                    <input class="form-control" type="text" name="email" placeholder="<?=T::email?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::phone?></label>
                                <div class="form-group">
                                    <span class="la la-phone form-icon"></span>
                                    <input class="form-control" type="text" name="phone" placeholder="<?=T::phone?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::date?></label>
                                <div class="form-group">
                                    <span class="la la-calendar form-icon"></span>
                                    <input class="form-control dp" type="text" name="date" placeholder="<?=T::date?>" value="<?=$date?>" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="input-box">
                                <label class="label-text"><?=T::notes?></label>
                                <div class="form-group">
                                    <textarea style="padding-left:15px" class="form-control" placeholder="<?=T::notes?>" rows="2" name="notes"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 responsive-column mt-4">
                         <div class="btn-search text-center">
                       <button type="submit" id="submit" class="effect" data-style="zoom-in"><i class="mdi mdi-search"></i> <?=T::submit?></button>
                    </div>
                     </div>
                     </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>