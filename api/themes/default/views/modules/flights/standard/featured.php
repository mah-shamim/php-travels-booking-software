<?php if(isModuleActive( 'flights')){ ?>
<!-- ================================
    START ROUND-TRIP AREA
================================= -->
<section class="round-trip-flight section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55"><?php echo trans('013');?> <?php echo trans('0564');?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">
            <div class="col-lg-12">

                <div class="popular-round-trip-wrap padding-top-40px">
                    <div class="tab-content" id="myTabContent4">
                        <div class="tab-pane fade show active" id="new-york" role="tabpanel" aria-labelledby="new-york-tab">
                            <div class="row">

                                <?php foreach($featuredFlights as $item){ ?>
                                <div class="col-lg-4 responsive-column">
                                    <div class="deal-card">
                                    <div class="row">
                                        <div class="col-4">
                                        <div class="deal-title d-flex align-items-center">
                                        <div class="clear"></div>
                                        <img src="<?php echo $item->thumbnail; ?>" alt="air-line-img" class="img-fluid" style="width:100%">
                                        </div>
                                        </div>
                                        <div class="col-8">
                                        <h3 class="deal__title"><?php echo $item->from;?> <i class="la la-arrow-right mx-2"></i> <?php echo $item->to;?></h3>
                                        <div class="deal-action-box d-flex align-items-center justify-content-between pt-1">
                                        <div class="price-box d-flex align-items-center"><span class="price__from mr-1"><?=trans('0273');?></span><span class="price__num"><?php echo $item->currCode;?> <?php echo $item->price; ?></span></div>
                                        <!--<a href="flight-single.html" class="btn-text">See details<i class="la la-angle-right"></i></a>-->
                                        </div>
                                        </div>
                                        <!--<p class="deal__meta"><?php echo $item->title; ?></p>-->
                                        <!--<p class="deal__meta">Tue, Jul 14-Fri, Jul 24</p>-->
                                    </div><!-- end deal-card -->
                                    </div><!-- end deal-card -->
                                </div><!-- end col-lg-4 -->
                                <?php } ?>
                            </div>
                        </div><!-- end tab-pane -->
                    </div><!-- end tab-content -->
                    <div class="tab-content-info d-flex justify-content-between align-items-center">
                        <p class="font-size-15"><i class="la la-question-circle mr-1"></i><?=trans('0653');?></p>
                        <!--<a href="<?php echo base_url(); ?>flights" class="btn-text font-size-15"><?=trans('0452')?> <i class="la la-angle-right"></i></a>-->
                    </div><!-- end tab-content-info -->
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end round-trip-flight -->
<!-- ================================
    END ROUND-TRIP AREA
================================= -->
<?php } ?>