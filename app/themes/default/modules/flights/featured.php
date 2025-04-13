<section class="round-trip-flight section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55 bottom-line"><?=T::flights_featured_flights?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">
            <div class="col-lg-12">

                <div class="popular-round-trip-wrap padding-top-40px">
                    <div class="tab-content" id="myTabContent4">
                        <div class="tab-pane fade show active" id="new-york" role="tabpanel" aria-labelledby="new-york-tab">
                            <div class="row">

                            <?php foreach ($app->featured_flights as $flights){ {

                            $from = explode(" ", $flights->from);
                            $froms = end($from);

                            $to = explode(" ", $flights->to);
                            $tos = end($to);

                            // get flights codes
                            $from_code = explode(' ',trim($flights->from));
                            $to_code = explode(' ',trim($flights->to));

                            ?>

                            <div class="col-lg-4 responsive-column">
                            <a href="<?=root?>en/<?=strtolower($currency)?>/flights/<?=strtolower($from_code[0])?>/<?=strtolower($to_code[0])?>/oneway/economy/<?php $d=strtotime("+5 Days"); echo date("d-m-Y", $d);?>/1/0/0">
                                    <div class="deal-card">
                                    <div class="row" style="display: flex; justify-content: center; align-items: center;    width: 100%;">
                                        <div class="col-5" style="background: #e4e8ef; height: 100%; align-items: center; justify-content: center; display: flex; border-radius: 6px;">
                                        <div class="deal-title d-flex align-items-center">
                                        <div class="clear"></div>
                                        <img data-src="<?=$flights->thumbnail?>" alt="air-line-img" class="img-fluid lazyload" style="width: 80%; max-height: 50px; margin: 0 auto;">
                                        </div>
                                        </div>
                                        <div class="col-7">
                                        <h6><?=$flights->title?></h6>
                                        <hr>
                                        <h3 class="deal__title"><?=$froms?> <i class="la la-arrow-right mx-2"></i> <?=$tos?></h3>
                                        <div class="deal-action-box d-flex align-items-center justify-content-between pt-1">
                                        <div class="price-box d-flex align-items-center"><span class="price__from mr-1"><?=T::from?></span><span class="price__num"><?=$session_currency?> <?=$flights->price?></span></div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                   </a>
                                </div>
                                <?php } } ?>

                            </div>
                        </div><!-- end tab-pane -->
                    </div><!-- end tab-content -->
                    <div class="tab-content-info d-flex justify-content-between align-items-center">
                        <p class="font-size-15"><i class="la la-question-circle mr-1"></i>Average round-trip price per person, taxes and fees included.</p>
                        <!--<a href="http://localhost/v8/flights" class="btn-text font-size-15">Top Rated Tours <i class="la la-angle-right"></i></a>-->
                    </div><!-- end tab-content-info -->
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>