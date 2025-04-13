<?php if(isModuleActive( 'flights')){ ?>
<div class="flightsbox">
    <div class="flightshead">
        <div class="container">
            <h2 class="destination-title go-text-right ttu">
                <i class="ti-Line-Airplane"></i> <?php echo trans('013');?> <strong><?php echo trans('0564');?></strong>
            </h2>
        </div>
    </div>
    <section class="flights-home">
        <div class="container">
            <div class="main_slider">
                <div class="set2 fa-left hidden-xs">
                    <i class="glyphicon-chevron-right icon-angle-left flight-left"></i>
                </div>
                <div class="flights" class="get">
                    <?php foreach($featuredFlights as $item){ ?>
                    <div class="owl-item">
                        <div class="item">
                            <div class="flight-box-styling">
                                <div class="col-md-12">
                                <div class="col-md-7 col-xs-7">
                                <img class="img-respinsive center-block" src="<?php echo $item->thumbnail; ?>">
                                 <hr>
                                 <p class="text-center"><?php echo $item->title; ?></p>
                                </div>
                                <div class="col-md-5 col-xs-5">
                                <div class="row">
                                <div class="text-right">
                                <h3><small><?php echo $item->currCode;?></small> <strong><?php echo $item->price; ?></strong></h3>
                                </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="set2 fa-right hidden-xs">
                    <i class="glyphicon-chevron-right icon-angle-right flight-right"></i>
                </div>
            </div>
        </div>
    </section>
</div>
<?php } ?>