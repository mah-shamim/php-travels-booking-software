<?php $ci = get_instance();
$location = $ci->session->userdata('Viator_location');
$start_date = $ci->session->userdata('Viator_startdate');
$end_date = $ci->session->userdata('Viator_endDate');
?>
<style>
    @media(min-width:992px){.header-waypoint-sticky.header-main{position:fixed;top:0;left:0;right:0;z-index:99999}
    }.amint-text{display:inline-block;transform:translateY(-10px)}
    .form-icon-left{display:flex}
    .form-icon-left>label{flex:2}
    .form-icon-left>select{flex:2}
    .collapse .card-body{margin-bottom:10px}
    .table-condensed>tbody>tr>td{padding:5px}
    .section-title h3{font-family:inherit!important}
    .header-main .header-nav{box-shadow:none!important}
    .panel-heading{padding:11px 18px;background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;font-size:14px;color:#000;border-top-right-radius:3px;border-top-left-radius:3px;text-transform:uppercase;letter-spacing:2px}
    .tchkin{height:calc(2.7em+.75rem+2px);margin-top:20px!important}
    ul.booking-amount-list:before{content:''}
    ul.booking-amount-list li{width:100%;float:none}
    .tour-child h6,.tour-child select,.tour-child .childPrice{flex:0 0 33%;margin-right:0!important;letter-spacing:0!important;width:33%!important}
    .tour-child select,.tour-infant select,.adult-Price select{transform:translateX(10px)}
    .tour-child .childPrice{display:flex!important;justify-content:flex-end}
    .tour-infant h6,.tour-infant select,.tour-infant .infantPrice{flex:0 0 33%;margin-right:1px!important;letter-spacing:0!important;width:33%!important}
    .tour-infant .infantPrice{display:flex!important;justify-content:flex-end}
    .adult-Price h6,.adult-Price select,.adult-Price .adultPrice{flex:0 0 33%;margin-right:1px!important;letter-spacing:0!important;width:33%!important}

    .barContainer {
        width: 100%;
        margin-top: 3em;
        background-color: #EFEFEF;
        padding: 4px;
    }

    .inner {
        padding: 1em;
        background-color: white;
        overflow: hidden;
        position: relative;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .ratings {
        float: left;
        width: 45%;
        text-align: center;
    }

    .rating-num {
        color: #333333;
        font-size: 72px;
        font-weight: 200;
        line-height: 1em;
    }

    .rating-stars {
        font-size: 20px;
        color: grey;
        margin-bottom: .5em;
    }
    .rating-stars .active {
        color: yellow;
    }

    .rating-users {
        font-size: 14px;
    }

    .histo {
        float: left;
        width: 50%;
        font-size: 13px;
    }

    .histo-star {
        float: left;
        padding: 3px;
    }

    .histo-rate {
        width: 100%;
        display: block;
        clear: both;
    }

    .bar-block {
        margin-left: 5px;
        color: black;
        display: block;
        float: left;
        width: 75%;
        position: relative;
    }

    .bar {
        padding: 4px;
        display: block;
    }

    #bar-five {
        width: 0;
        background-color: #9FC05A;
    }

    #bar-four {
        width: 0;
        background-color: #ADD633;
    }

    #bar-three {
        width: 0;
        background-color: #FFD834;
    }

    #bar-two {
        width: 0;
        background-color: #FFB234;
    }

    #bar-one {
        width: 0;
        background-color: #FF8B5A;
    }

    .booking-selection-box .form-spin-group .form-icon-left .icon-font {
    min-height: 3.6rem;
    margin-left: 11px;
    }

    .form-spin-group label {
    width: 100%;
    text-align: left;
    }

</style>
<!--Starting of main wrapper-->
<?php $detail = $details->data;
$jsRating = json_encode($detail->ratingCounts);
//dd($detail->thumbnailURL);
?>
<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-detail bg-light">
        <div class="detail-header">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row sb">
                    <?php if($appModule != "offers"){ ?>
                        <div class="o2">
                            <h2 id="detail-content-sticky-nav-00" class="name"><?php echo character_limiter($detail->title, 50);?></h2>
                            <div class="star-rating-wrapper">
                                <div class="rating-item rating-inline">
                                    <div class="rating-icons">
                                        <?php $stars_count = $detail->rating;
                                        for ($i=4; $i >= 0 ; $i--) {
                                            if ($stars_count > 0){
                                                $stars_count--;
                                                ?>
                                                <i class="rating-icon fa fa-star"></i>
                                            <?php }
                                            else {?>
                                                <i class="rating-symbol-background rating-icon far fa-star "></i>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <p class="location">
                                <i class="material-icons text-info small">place</i>
                                <?php echo character_limiter($detail->primaryDestinationName, 28);?>
                            </p>
                        </div>
                    <?php } ?>
                    <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
                        <a href="#detail-content-sticky-nav-01" class="anchor btn btn-primary btn-wide mt-5">
                            <?php echo trans('046');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <span id="detail-content-sticky-nav-00" class="d-block"></span>
        <div class="fullwidth-horizon-sticky d-none d-lg-block">
            <div class="fullwidth-horizon-sticky-inner">
                <div class="container">
                    <div class="fullwidth-horizon-sticky-item clearfix">
                        <ul id="horizon-sticky-nav" class="horizon-sticky-nav clearfix">
                            <li>
                                <a href="#detail-content-sticky-nav-00"><?php echo trans('044');?></a>
                            </li>
                            <li>
                                <a href="#detail-content-sticky-nav-01"><?php echo trans('0248');?></a>
                            </li>
                            <li>
                                <a href="#detail-content-sticky-nav-05"><?php echo trans('040');?></a>
                            </li>
                            <li>
                                <a href="#detail-content-sticky-nav-06"><?php echo trans('0396');?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="change-search" class="collapse mt-30">
                <div class="change-search-wrapper">
                    <div class="row gap-10 gap-xl-20 align-items-end">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <?php echo searchForm($appModule, $data); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="row gap-30">
                <div  class="col-12 col-lg-4 col-xl-3 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <div class="booking-selection-box">
                            <div class="heading clearfix">
                                <div class="d-flex align-items-end fe">
                                    <div>
                                        <h5 class="text-white font-serif font400"><?php echo trans('0463'); ?></h5>
                                    </div>
                                </div>
                            </div>
                                <div class="content">
                                    <!--This form need to be test again at end-->
                                    <form  action="<?php ?>" method="GET" role="search" id="checkAvailablityForm" style="width: 100%">
                                        <div class="hotel-room-sm-item">
                                            <input type="hidden" id="title" value="<?php echo $detail->title; ?>" />
                                            <input type="hidden" id="picture" value="<?php echo $detail->thumbnailURL;?>" />
                                            <input type="hidden" id="rating" value="<?php echo $detail->rating; ?>"/>
                                            <input type="hidden" id="location" value="<?php echo $detail->location; ?>"/>
                                            <input type="hidden" id="duration" value="<?php echo $detail->duration; ?>"/>
                                            <input type="hidden" id="code" value="<?php echo $detail->code; ?>"/>
                                            <div class="the-hotel-item">
                                                <div class="form-group form-spin-group">
                                                    <label for="room-amount"><?php echo trans('08');?></label>
                                                    <div class="clear"></div>
                                                    <div class="form-icon-left">
                                                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                                        <input type="text" id="startDate" class="DateTours form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=!empty($start_date)?$start_date: '' ?> " name="startDate" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-spin-group">
                                                    <label for="room-amount"><?php echo trans('08');?></label>
                                                    <div class="clear"></div>
                                                    <div class="form-icon-left">
                                                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                                        <input type="text" id="endDate" class="DateTours form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=!empty($end_date) ? $end_date : '' ?>" name="endDate" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="date" value="<?php echo $detail->dateStamp;?>">
                                        <?php if(!empty($details->error)){ ?>
                                            <div class="alert alert-danger go-text-right">
                                                <?php echo trans($details->errorCode); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="hotel-room-sm-item">
                                            <?php $i=1;
                                            foreach($detail->ageBands as $item) { ?>
                                                    <div class="the-room-item">
                                                        <div class="d-flex align-items-center adult-Price">
                                                            <h6><?php echo $item->description; ?> <?php echo $detail->priceFormatted; ?></h6>
                                                            <select style="min-width:50px;height: 35px !important;min-height: 35px !important;"
                                                                    name="<?php echo $item->description ?>" class="changeInfo input-sm form-control" id="select<?php echo $i;?>">
                                                                <?php $maxTravellers = $detail->maxTravellerCount;
                                                                for ($adults = 0; $adults <= $detail->maxTravellerCount; $adults++) { ?>
                                                                    <option value="<?php echo $adults;?>" data-price="<?php echo $adults ?>" <?php echo makeSelected($selectedAdults, $adults); ?>><?php echo $adults; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            &nbsp;&nbsp;
                                                            <div id="currencyCode" style="flex: 0 0 16%;text-align: right;"><?php echo $detail->currencyCode;?></div> &nbsp;&nbsp; <span class="price adultPrice" id="span<?php echo $i++; ?>"> &nbsp;0</span>
                                                        </div>
                                                    </div>
                                                <?php
                                            }?>
                                              <div class="text-center">
                                                <h4 class="well well-sm text-center strong" style="margin-top: 4px; line-height: 20px;"> <?php echo trans('0334'); ?>

                                                 <span style="color:#333333;" class="totalCost">
                                                        <strong id="totalCost">0</strong><strong>$</strong>
                                                    </span>
                                                    </h4>
                                            </div>
                                            <div class="text-center">

                                                    <small style="font-size: 12px;"> <?php echo trans('0144');?>
                                                        <span class="totaldeposit"><?php echo $detail->maxTravellerCount; ?></span>
                                                    </small>

                                            </div>

                                        </div>
                                        <button id="submit" disabled style="height: 59px; margin: 3px;" type="submit" class="btn btn-secondary btn-block mt-20 btn-action btn-lg loader"><?php echo trans('027');?></button>


                                      <script>
                                            $("select").on('change',function(){
                                            if($(this).find('option:selected').text()=="0")
                                            $("#submit").attr('disabled',true)
                                            else
                                            $("#submit").attr('disabled',false)
                                            });

                                            $(window).load(function(){
                                                priceCounter();
                                            });
                                            $(".changeInfo").on("change", function () {
                                                priceCounter();
                                            });
                                            function priceCounter() {
                                                let limit = <?php echo $detail->maxTravellerCount; ?>;
                                                var total=0;
                                                let selected=0;
                                                let selectedPrice=0;
                                                let singlePrice = <?php echo $detail->price; ?>;
                                                let price = 0;
                                                let totalPrice = 0;
                                                <?php $i=1;
                                                foreach($detail->ageBands as $item) {
                                                ?>
                                                selected = document.getElementById('select'+<?php echo $i; ?>).selectedIndex;
                                                total = +total + +selected;
                                                price = (singlePrice * selected);
                                                selectedPrice = document.getElementById('span'+<?php echo $i; ?>);
                                                selectedPrice.innerText= price;
                                                totalPrice = +totalPrice + +price;
                                                <?php $i++;
                                                } ?>
                                                document.getElementById("totalCost").innerText = totalPrice;
                                                if (total <= limit)
                                                {
                                                    // alert(total);
                                                }
                                                else
                                                {
                                                    alert("You are not able to reserve more than "+limit+" seats \n" + "Please decrease your seats ");
                                                }
                                            }
                                            function Reset() {
                                                var dropDown = document.getElementById('select'+<?php echo $i++; ?>);
                                                dropDown.selectedIndex = 0;
                                            }
                                        </script>
                                    </form>
                                </div>
                        </div>
                        </form>
                    </aside>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="content-wrapper">
                        <div class="slick-gallery-slideshow detail-gallery">
                            <div class="slider gallery-slideshow">

                                    <div>
                                        <div class="image"><img src="<?=$image_thumb ?>" alt="<?php echo $image_thumb; ?>" /></div>
                                    </div>
                            </div>
                        </div>
                        <?php require $themeurl.'views/socialshare.php';?>
                        <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section tour-over">
                            <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
                            <div class="clear"></div>
                            <?php echo $detail->description;?>
                            <hr>
                        </div>
                        <div class="clear"></div>
                        <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
                            <!-- End SpecialcheckInInstructions -->
                            <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
                                <h3 class="heading-title"><span><?php echo trans('057');?></span></h3>
                                <div class="clear"></div>
                                <div class="feature-box-2 mb-0 bg-white">
                                    <div class="feature-row">
                                        <div class="row gap-10 gap-md-30">
                                            <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                                <h6><?php echo trans('0149'); ?></h6>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                                <p><?php if(!empty($detail->termsAndConditions)){ ?><?php echo $detail->termsAndConditions; } ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!empty($detail->departurePoint)){ ?>
                                        <div class="feature-row">
                                            <div class="row gap-10 gap-md-30">
                                                <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                                    <h6><?php echo trans('0210');?></h6>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                                    <p>
                                                        <?php echo character_limiter($detail->departurePoint,200);?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($detail->departureTime)){ ?>
                                        <div class="feature-row">
                                            <div class="row gap-10 gap-md-30">
                                                <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                                    <h6><?php echo trans('0472');?></h6>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                                    <p>
                                                        <?php echo $detail->departureTime;?>
                                                    </p>
                                                    <?php if(!empty($detail->departureTimeComment)){ ?>
                                                        <p>Note: <?php $detail->departureTimeComment ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="feature-row">
                                            <div class="row gap-10 gap-md-30">
                                                <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                                    <h6><?php echo trans('0560');?></h6>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                                    <p>
                                                      <?php echo $detail->duration;?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="">
                                    <div class="clearfix"></div>
                                    <!-- Start checkInInstructions -->
                                    <?php if(!empty($checkInInstructions)){ ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading go-text-right panel-green">
                                            <?php echo trans('0550'); ?>
                                        </div>
                                        <?php }  if(!empty($checkInInstructions)){ ?>
                                        <div class="panel-body">
                                          <span class="RTL">
                                            <p>
                                              <?php echo $checkInInstructions; ?>
                                            </p>
                                          </span>
                                        </div>
                                    </div>
                                <?php } ?>
                                    <!-- End checkInInstructions -->
                                    <!-- Start SpecialcheckInInstructions -->
                                    <?php if(!empty($specialCheckInInstructions)){ ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading go-text-right panel-green">
                                            <?php echo trans('0551'); ?>
                                        </div>
                                        <?php }  if(!empty($specialCheckInInstructions)){ ?>
                                        <div class="panel-body">
                                          <span class="RTL">
                                            <p>
                                              <?php echo $specialCheckInInstructions; ?>
                                            </p>
                                          </span>
                                        </div>
                                    </div>
                                <?php } ?>
                                    <!-- End  SpecialcheckInInstructions -->
                                    <!-- Start Tours Inclusions / Exclusions -->
                                    <div class="row">
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="col-md-6" id="INCLUSIONS">
                                            <h4 class="main-title float-none"><?php echo trans('0280');?></h4>
                                            <i class="tiltle-line"></i>
                                            <div class="clearfix"></div>
                                            <br>
                                            <?php foreach($detail->inclusions as $inclusion){ if(!empty($inclusion)){  ?>
                                                <ul class="list_ok col-md-12" style="margin: 0 0 5px 0;">
                                                    <li class=""><i class="fas fa-check-circle text-primary"></i>  &nbsp;&nbsp;&nbsp; <?php echo $inclusion; ?></li>
                                                </ul>
                                            <?php } } ?>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-6" id="EXCLUSIONS">
                                            <h4 class="main-title float-none"><?php echo trans('0281');?></h4>
                                            <div class="clear"></div>
                                            <i class="tiltle-line"></i>

                                            <br>
                                            <?php foreach($detail->exclusions as $exclusion){ if(!empty($exclusion)){  ?>
                                                <ul class="col-md-12" style="margin: 0 0 5px 0;list-style:none;">
                                                    <li class=""><i class="fas fa-times-circle text-primary"></i> &nbsp;&nbsp;&nbsp; <?php echo $exclusion; ?> &nbsp;&nbsp;&nbsp;</li>
                                                </ul>
                                            <?php } } ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </section>

                        <!------------------------  Reviews   ------------------------------>
                        <div id="detail-content-sticky-nav-06" class="fullwidth-horizon-sticky-section">
                            <div class="container hidden-xs">

                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <!--Start Reviews -->
                                <?php if(!empty($detail->reviewCount) > 0){ ?>

                                    <!--Start Reviews status bar -->
                                    <div class="barContainer">
                                        <div class="inner">
                                            <div class="ratings">
                                                <span class="rating-num"><i class="fa fa-user"></i></span>
                                                <div class="rating-stars">
                                                    <?php $stars_count = $detail->rating;
                                                    if(!empty($stars_count)) {
                                                        for ($i = $stars_count; $i >= 0; $i--) {
                                                            if ($i > 0) {
                                                                ?>
                                                                <i class="rating-stars active fa fa-star"></i>
                                                            <?php } else { ?>
                                                                <i class="rating-stars far fa-star "></i>
                                                            <?php }
                                                        }
                                                    }?>
                                                </div>
                                                <div class="rating-users">
                                                    <span class="icon-user" id="reviews"><?php echo $detail->reviewCount ?></span> Total Reviews
                                                </div>
                                            </div>

                                            <div class="histo">
                                                <div class="five histo-rate">
                                                    <span class="histo-star">
                                                        <i class="rating-stars active fa fa-star"></i> 5
                                                    </span>
                                                    <span class="bar-block">
                                                        <span id="bar-five" class="bar">
                                                            <span></span>&nbsp;
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="four histo-rate">
                                                    <span class="histo-star">
                                                        <i class="rating-stars active fa fa-star"></i> 4
                                                    </span>
                                                    <span class="bar-block">
                                                      <span id="bar-four" class="bar">
                                                        <span></span>&nbsp;
                                                      </span>
                                                    </span>
                                                </div>

                                                <div class="three histo-rate">
                                                    <span class="histo-star">
                                                        <i class="rating-stars active fa fa-star"></i> 3
                                                    </span>
                                                    <span class="bar-block">
                                                        <span id="bar-three" class="bar">
                                                            <span></span>&nbsp;
                                                        </span>
                                                    </span>
                                                </div>

                                                <div class="two histo-rate">
                                                    <span class="histo-star">
                                                        <i class="rating-stars active fa fa-star"></i> 2
                                                    </span>
                                                    <span class="bar-block">
                                                        <span id="bar-two" class="bar">
                                                            <span></span>&nbsp;
                                                        </span>
                                                    </span>
                                                </div>

                                                <div class="one histo-rate">
                                                    <span class="histo-star">
                                                        <i class="rating-stars active fa fa-star"></i> 1
                                                    </span>
                                                    <span class="bar-block">
                                                      <span id="bar-one" class="bar">
                                                        <span></span>&nbsp;
                                                      </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Reviews status bar -->

                                    <div id="REVIEWS">
                                        <div class="panel panel-default">
                                            <div class="panel-heading go-text-right panel-yellow"><?php echo trans('0396');?></div>
                                            <div class="panel-body">
                                                <div class="tab-pane active" id="tab-newtopic">
                                                    <div class="table-responsive">
                                                        <div class="fixedtopic">
                                                            <table class="table-hover table table-striped">
                                                                <?php if(!empty($detail->reviews)){ foreach($detail->reviews as $rev){ ?>
                                                                    <tr class="RTL">
                                                                        <td style="width: 100px;">
                                                                            <img class="go-right" src="<?php echo base_url(); ?>assets/img/user_blank.jpg" alt="<?php echo $rev->reviewId;?>"/>
                                                                        </td>
                                                                        <td>
                                                                            <span class="dark"><strong class="go-right"><?php echo $rev->ownerName;?> &nbsp;</strong></span> <span class="text-muted"><small><?php echo pt_show_date_php($rev->submissionDate);?></small>   <span class="badge badge-warning pull-right go-left"> <?php echo round(5,1);?> / <?php if(!empty($rev->rating)){ echo $rev->rating; }else{ echo "10"; }?></span></span> <br/>
                                                                            <?php if(!empty($rev->reviewUrl)){ ?>
                                                                                <a target="_blank" href="<?php echo $rev->reviewUrl;?>"> <?php echo character_limiter($rev->review_comment,1000);?> </a>
                                                                            <?php }else{ ?>
                                                                                <?php echo character_limiter($rev->review,1000);?>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                            <div class="line3"></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--End Reviews-->
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- End Hotel Reviews bars -->
                        <!-- End Add/Remove Wish list Review Section -->
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="col-md-12 form-group">
                                <?php if($appModule != "cars" && $appModule != "ean" && $appModule != "offers" ){ ?>
                                    <button  data-toggle="collapse"  type="button" class="writeReview btn btn-primary btn-block mb-10" sdata-target="#ADDREVIEW" href="#ADDREVIEW" aria-controls="#ADDREVIEW"><i class="icon_set_1_icon-68"></i> <?php echo trans('083');?></button>
                                    <div class="collapse mt-20" id="ADDREVIEW">
                                        <div class="card card-body row">
                                            <form class="form-horizontal row" method="POST" id="reviews-form-<?php echo $module->id;?>" action="" onsubmit="return false;">
                                                <div id="review_result<?php echo $module->id;?>" style="width:100%" >
                                                </div>
                                                <div class="alert resp row" style="display:none"></div>
                                                <?php $mdCol = 12; if($appModule == "hotels"){ $mdCol = 8; ?>
                                                    <div class="col-md-4 go-right">
                                                        <div class="card card-body card-light">
                                                            <h3 class="text-center"><strong><?php echo trans('0389');?></strong>&nbsp;<span id="avgall_<?php echo $module->id; ?>"> 1</span> / 10</h3>
                                                            <div class="row">
                                                                <div class="col-md-6 form-horizontal">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo trans('030');?></label>
                                                                        <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_clean">
                                                                            <option value="1"> 1 </option>
                                                                            <option value="2"> 2 </option>
                                                                            <option value="3"> 3 </option>
                                                                            <option value="4"> 4 </option>
                                                                            <option value="5"> 5 </option>
                                                                            <option value="6"> 6 </option>
                                                                            <option value="7"> 7 </option>
                                                                            <option value="8"> 8 </option>
                                                                            <option value="9"> 9 </option>
                                                                            <option value="10"> 10 </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo trans('031');?></label>
                                                                        <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_comfort">
                                                                            <option value="1"> 1 </option>
                                                                            <option value="2"> 2 </option>
                                                                            <option value="3"> 3 </option>
                                                                            <option value="4"> 4 </option>
                                                                            <option value="5"> 5 </option>
                                                                            <option value="6"> 6 </option>
                                                                            <option value="7"> 7 </option>
                                                                            <option value="8"> 8 </option>
                                                                            <option value="9"> 9 </option>
                                                                            <option value="10"> 10 </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo trans('032');?></label>
                                                                        <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_location">
                                                                            <option value="1"> 1 </option>
                                                                            <option value="2"> 2 </option>
                                                                            <option value="3"> 3 </option>
                                                                            <option value="4"> 4 </option>
                                                                            <option value="5"> 5 </option>
                                                                            <option value="6"> 6 </option>
                                                                            <option value="7"> 7 </option>
                                                                            <option value="8"> 8 </option>
                                                                            <option value="9"> 9 </option>
                                                                            <option value="10"> 10 </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo trans('033');?></label>
                                                                        <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_facilities">
                                                                            <option value="1"> 1 </option>
                                                                            <option value="2"> 2 </option>
                                                                            <option value="3"> 3 </option>
                                                                            <option value="4"> 4 </option>
                                                                            <option value="5"> 5 </option>
                                                                            <option value="6"> 6 </option>
                                                                            <option value="7"> 7 </option>
                                                                            <option value="8"> 8 </option>
                                                                            <option value="9"> 9 </option>
                                                                            <option value="10"> 10 </option>
                                                                        </select>
                                                                    </div>
                                                                    <input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
                                                                    <input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
                                                                    <input type="hidden" id="module" value="<?php echo $appModule;?>" />
                                                                    <input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
                                                                    <input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />
                                                                    <div class="form-group">

                                                                        <label class="control-label"><?php echo trans('034');?></label>
                                                                        <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_staff">
                                                                            <option value="1"> 1 </option>
                                                                            <option value="2"> 2 </option>
                                                                            <option value="3"> 3 </option>
                                                                            <option value="4"> 4 </option>
                                                                            <option value="5"> 5 </option>
                                                                            <option value="6"> 6 </option>
                                                                            <option value="7"> 7 </option>
                                                                            <option value="8"> 8 </option>
                                                                            <option value="9"> 9 </option>
                                                                            <option value="10"> 10 </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-<?php echo $mdCol;?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="text" name="fullname" placeholder="<?php echo trans('0390');?> <?php echo trans('0350');?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="text" name="email" placeholder="<?php echo trans('0390');?> <?php echo trans('094');?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group"></div>
                                                    <textarea class="form-control" type="text" placeholder="<?php echo trans('0391');?>" name="reviews_comments" id="" cols="30" rows="10"></textarea>
                                                    <div class="form-group"></div>
                                                    <p class="text-danger"><strong><?php echo trans('0371');?></strong> : <?php echo trans('085');?></p>
                                                    <input type="hidden" name="addreview" value="1" />
                                                    <input type="hidden" name="overall" id="overall_<?php echo $module->id; ?>" value="1" />
                                                    <input type="hidden" name="reviewmodule" value="<?php echo $appModule; ?>" />
                                                    <input type="hidden" name="reviewfor" value="<?php echo $module->id; ?>" />
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label class="control-label">&nbsp;</label>
                                                            <button type="submit" class="btn btn-primary btn-block btn-lg addreview" id="<?php echo $module->id; ?>" ><?php echo trans('086');?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($appModule != "offers" && $appModule != "ean"){ ?>
                                    <?php $currenturl = current_url(); $wishlist = pt_check_wishlist($customerloggedin,$module->id);
                                    if($allowreg){
                                        if($wishlist){ ?>
                                            <span class="btn wish btn-danger btn-outline removewishlist btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('028');?></span></span>
                                        <?php }else{ ?>
                                            <span class="btn wish addwishlist btn-danger btn-outline btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('029');?></span></span>

                                        <?php } } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fullwidth-horizon-sticky border-0">&#032;</div>
    <!-- is used to stop the above stick menu -->
</div>
</div>
<?php if(!empty($module->relatedItems)){ ?>
    <section class="bg-white section-sm">
        <div class="container">
            <div class="section-title mb-25">
                <h3><?php if($appModule == "hotels" || $appModule == "ean"){ echo trans('0290'); }else if($appModule == "tours"){ echo trans('0453'); }else if($appModule == "cars"){ echo trans('0493'); } ?></h3>
                <div class="clear"></div>
            </div>
            <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
                <?php foreach($module->relatedItems as $item){ ?>
                    <div class="col">
                        <div class="product-grid-item">
                            <a href="<?php echo $item->slug;?>">
                                <div class="image">
                                    <img src="<?php echo $item->thumbnail;?>" alt="Image">
                                </div>
                                <div class="content clearfix">
                                    <div class="rating-item rating-sm go-text-right">
                                        <div class="rating-icons">
                                            <?php echo $item->stars;?>
                                        </div>
                                        <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
                                    </div>
                                    <div class="short-info">
                                        <h5 class="RTL"><?php echo character_limiter($item->title,25);?></h5>
                                        <div class="clear"></div>
                                        <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo character_limiter($item->location,20);?></p>
                                    </div>
                                    <?php if($item->price > 0){ ?>
                                        <div class="price">
                                            <div>
                                                <?php echo trans( '0299');?>
                                                <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
</div>

<input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
<input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
<input type="hidden" id="module" value="<?php echo $appModule;?>" />
<input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
<input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />


<script>
    $("form").submit(function ( event ) {
        event.preventDefault();
        var startDate = $("#startDate").val().trim().split('-').reverse().join('-');
        var endDate = $("#endDate").val().trim().split('-').reverse().join('-');
        var Adult = 0;
        var Senior = 0;
        var Youth = 0;
        var Child = 0;
        var Infant = 0;
        var selected;
        let currencyCode = document.getElementById('currencyCode').innerText;
        let singleCost=<?php echo $detail->price;?>;
        let rating = $('#rating').val();
        let title = $("#title").val();
        let location = $('#location').val();
        let duration = $('#duration').val();
        let code = $('#code').val();
        let picture = $('#picture').val().split('/').join('_');
        let totalCost = document.getElementById("totalCost").innerText;
        <?php $i=1;
        foreach($detail->ageBands as $item) {
        ?>
        selected = document.getElementById('select'+<?php echo $i; ?>);
        if (selected.name == 'Adult') {
            selected = document.getElementById('select'+<?php echo $i; ?>);
            Adult = selected.selectedIndex;
        }
        else if (selected.name == 'Senior') {
            selected = document.getElementById('select'+<?php echo $i; ?>);
            Senior = selected.selectedIndex;
        }if (selected.name == 'Youth') {
            selected = document.getElementById('select'+<?php echo $i; ?>);
            Youth = selected.selectedIndex;
        }if (selected.name == 'Child') {
            selected = document.getElementById('select'+<?php echo $i; ?>);
            Child = selected.selectedIndex;
        }if (selected.name == 'Infant') {
            selected = document.getElementById('select'+<?php echo $i; ?>);
            Infant = selected.selectedIndex;
        }
        <?php $i++;
        } ?>
        let arr = ['startDate',startDate,'endDate',endDate,'adults',Adult,'seniors',Senior,'youth',Youth,'child',Child,'infant',Infant,
            'singleCost',singleCost,'totalCost',totalCost,'currencyCode',currencyCode,'picture', picture,'rating', rating,
            'title', title,'location',location,'duration',duration,'code',code,'total_price'];

        window.location.href = base_url + 'packages/checkAvailability/' + arr.join("/");
    });
</script>
<!-- aside -->
<script>
    //------------------------------
    // Write Reviews
    //------------------------------

    $('.reviewscore').change(function(){
        var sum = 0;
        var avg = 0;
        var id = $(this).attr("id");
        $('.reviewscore_'+id+' :selected').each(function() {
            sum += Number($(this).val());
        });
        avg = sum/5;
        $("#avgall_"+id).html(avg);
        $("#overall_"+id).val(avg);
    });

    //submit review
    $(".addreview").on("click",function(){
        var id = $(this).prop("id");
        $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-"+id).serialize(), function(resp){
            var response = $.parseJSON(resp);
            // alert(response.msg);
            $("#review_result"+id).html("<div class='alert "+response.divclass+"'>"+response.msg+"</div>").fadeIn("slow");
            if(response.divclass == "alert-success"){
                setTimeout(function(){
                    $("#ADDREVIEW").removeClass('in');
                    $("#ADDREVIEW").slideUp();
                }, 5000);
            }
        });
        setTimeout(function(){
            $("#review_result"+id).fadeOut("slow");
        }, 3000);
    });


    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
    //------------------------------
    // Add to Wishlist
    //------------------------------
    $(function(){
        // Add/remove wishlist
        $(".wish").on('click',function(){
            var loggedin = $("#loggedin").val();
            var removelisttxt = $("#removetxt").val();
            var addlisttxt = $("#addtxt").val();
            var title = $("#itemid").val();
            var module = $("#module").val();
            if(loggedin > 0){ if($(this).hasClass('addwishlist')){
                var confirm1 = confirm("<?php echo trans('0437');?>");
                if(confirm1){
                    $(".wish").removeClass('addwishlist btn-primary');
                    $(".wish").addClass('removewishlist btn-warning');
                    $(".wishtext").html(removelisttxt);
                    $.post("<?php echo base_url();?>account/wishlist/add", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){ });
                }
                return false;
            }else if($(this).hasClass('removewishlist')){
                var confirm2 = confirm("<?php echo trans('0436');?>");
                if(confirm2){
                    $(".wish").addClass('addwishlist btn-primary'); $(".wish").removeClass('removewishlist btn-warning');
                    $(".wishtext").html(addlisttxt);
                    $.post("<?php echo base_url();?>account/wishlist/remove", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){
                    });
                }
                return false;
            } }else{ alert("<?php echo trans('0482');?>"); } });
        // End Add/remove wishlist
    })
</script>
<!--Reviews Status bar-->
<?php  ?>
<script>
    $(document).ready(function() {
        var five = "<?php echo $jsRating[5]; ?>";
        var four = "<?php echo $jsRating[11]; ?>";
        var three = "<?php echo $jsRating[17]; ?>";
        var two = "<?php echo $jsRating[23]; ?>";
        var one = "<?php echo $jsRating[29]; ?>";
        var total = $('#reviews').text();
        // rev = parseInt(rev);
        total = parseInt(total);
        var avg = Math.round(five/total*100);
        // avg = Math.round(five/total*100);
        $('.bar span').hide();
        $('#bar-five').animate({
            width: avg+'%'}, 1000);
        $('#bar-five span').text(avg+'%');
        avg = Math.round(four/total*100);
        $('#bar-four').animate({
            width: avg+'%'}, 1000);
        $('#bar-four span').text(avg+'%');
        avg = Math.round(three/total*100);
        $('#bar-three').animate({
            width: avg+'%'}, 1000);
        $('#bar-three span').text(avg+'%');
        avg = Math.round(two/total*100);
        $('#bar-two').animate({
            width: avg+'%'}, 1000);
        $('#bar-two span').text(avg+'%');
        avg = Math.round(one/total*100);
        $('#bar-one').animate({
            width: avg+'%'}, 1000);
        $('#bar-one span').text(avg+'%');
        setTimeout(function() {
            $('.bar span').fadeIn('slow');
        }, 1000);

    });
</script>
