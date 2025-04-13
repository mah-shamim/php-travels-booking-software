<?php if(isModuleActive( 'offers') && $offersCount> 0){ ?>

<!-- ================================
    START CTA AREA
================================= -->
<?php if($offersCount> 0){ ?>
<section class="cta-area padding-top-100px padding-bottom-180px text-center">
    <div class="video-bg">
        <video autoplay loop>
            <source src="<?=$theme_url;?>assets/video/video-bg.mp4" type="video/mp4">
            <!--<source src="<?php echo $specialoffers[0]->thumbnail;?>" type="video/mp4">-->
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2 class="sec__title text-white line-height-55"><?=lang('013')?> <?=lang('Offers')?> <br> <?php echo character_limiter($specialoffers[0]->title,30);?></h2>
                    <p style="color:#fff"><?php echo character_limiter($specialoffers[0]->desc,380);?></p>
                    <br><br>
                    <?php if($specialoffers[0]->price > 0){ ?>
                    <div class="price" style="color:#fff">
                    <?php echo trans('0536');?> <?php echo trans('0388');?>
                    <span class="text-secondary" style="color:#fff !important">
                    <!--<?php echo $specialoffers[0]->currCode;?> --><?php echo $specialoffers[0]->currSymbol; ?><?php echo $specialoffers[0]->price;?>
                    </span>
                    </div>
                    <?php } ?>
                    <!--
                    <?php echo trans('0536');?> <?php echo trans('0388');?>
                    <?=lang('031')?>
                    -->

                </div><!-- end section-heading -->
                <div class="btn-box padding-top-35px">
                    <a href="<?php echo base_url(); ?>offers" class="theme-btn border-0"><?=lang('0185')?></a>
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
    <svg class="cta-svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M-31.31,170.22 C164.50,33.05 334.36,-32.06 547.11,196.88 L500.00,150.00 L0.00,150.00 Z"></path></svg>
</section><!-- end cta-area -->
<!-- ================================
    END CTA AREA
================================= -->
<?php // } ?>
<?php } ?>
<?php } ?>