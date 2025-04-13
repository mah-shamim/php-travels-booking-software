<!-- slick  -->
<?php $featured_hotels=(app()->featured_hotels) ?>

<!-- ================================
    START HOTEL AREA
================================= -->
<section data-aos="fade-up" class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px pb-5">
    <div class="container">
        <div style="right 24px top 4px" class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h4 class="mb-4"><strong><?=T::hotels_featured_hotels?></strong></h4>
                    </div>
                </div>
            </div>
            <div class="row padding-top-10px">
                <div class="col-lg-9">
                    <div class="hotel-card-wrap">
                        <div class="row featured--hotels-slick">
                        <?php
                        foreach ($featured_hotels as $hotels){ 
                            
                            (isset($_SESSION['hotels_nationality']))?$nationality=$_SESSION['hotels_nationality']:$nationality="US";
                            (isset($_SESSION['supplier_name']))?$supplier_name=$_SESSION['supplier_name']:$supplier_name="hotels";

                            $payload = [
                                "nationality" => $nationality,
                                "supplier_name" => "hotels"
                            ];
        
                            $hash=base64_encode(json_encode($payload));

                            $link = root.'hotel/'.$hotels->id.'/'.
                            clean_var($hotels->name).'/'.
                            date('d-m-Y',strtotime('+3 day')).'/'.date('d-m-Y',strtotime('+4 day')).'/1/2/0/'.$hash;

                        {
                        ?>
                        <div class="col-md-3 mb-3 px-1">
                        <div class="rounded border p-2">
                                <div class="card-img">
                                    <a href="<?=$link?>" class="d-block">
                                    <img src="./uploads/<?=$hotels->img?>" class="w-100 rounded-2" alt="hotel-img" style="height:200px">
                                    </a>
                                </div>
                                <div class="p-3">

                                <div class="mb-0">
                                        <span class="d-flex mt-1">
                                        <?php for ($i = 1; $i <= $hotels->stars; $i++) { ?>
                                        <?=star()?>
                                        <?php } ?>
                                        </span>
                                    </div>

                                    <h6 class="mb-0 mt-2 lenght-cover"><a href="<?=$link?>"><strong><?=$hotels->name?></strong></a></h6>
                                    <p class="card-meta mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="10" r="3"></circle>
                                    <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                                    </svg>
                                    <strong><?=$hotels->city?></strong> <small><?=$hotels->country?></small></p>
                                    <hr>
                                    <div class="card-price d-flex align-items-center justify-content-between">
                                        <p class="mb-0">
                                            <span class="price__num"><?=currency?> <strong> <?=$hotels->price?> </strong></span>
                                            <!-- <span class="price__text"><?=T::price?></span> -->
                                        </p>
                                        <a href="<?=$link?>" class="btn btn-outline-dark"><?=T::details?>  
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                                    </a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 col-md-12">
                <div class="shadow-sm rounded card-item p-2">
                        <div class="card-img">
                            <a href="<?=root?>hotels" class="d-block" tabindex="0">
                            <img src="<?=root?>assets/img/featured_hotels.png" class="w-100" alt="hotel-img" style="min-height:374px">
                            <div class="pt-5" style="border-bottom-right-radius: 6px; border-bottom-left-radius: 6px; position: absolute; width: 100%; z-index: 9; display: block; padding: 25px 20px 5px; color: #fff; left: 0; bottom: 0; height: 164px; background: transparent; background: linear-gradient(to bottom,transparent,#005cff); box-sizing: border-box;">
                            <h6 class="strong text-center"><strong><?=T::discover_great_deals?></strong></h6>
                            <span class="btn btn-block btn-outline-light w-100">
                                <?=T::view_more?>
                            </span>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media screen and (max-width: 425px) {
        .hotel-area > .container > :first-child { padding: 20px !important }
    }
</style>

<script>
    $(".featured--hotels-slick").slick({
       infinite: true,
       speed: 300,
       slidesToShow: 3,
       slidesToScroll: 1,
       responsive: [
           {
            breakpoint: 1000,
            settings: {
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 2,
            },
           },
        //    {
        //     breakpoint: 600,
        //     settings: {
        //         arrows: false,
        //         slidesToShow: 2,
        //         slidesToScroll: 2,
        //     }
        // },
        {
            breakpoint: 500,
            settings: {
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1,
            },
        }
       ],
   });

</script>
<!-- ================================
    END HOTEL AREA
================================= -->