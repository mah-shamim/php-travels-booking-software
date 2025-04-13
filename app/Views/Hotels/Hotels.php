<!-- <script src="<?= root ?>assets/js/mixitup.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-pagination.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-multifilter.min.js"></script> -->
<script src="<?= root ?>assets/js/plugins/ion.rangeSlider.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

<div class="py-4 mb-0">
    <div class="container">
        <div class="">
            <?php require_once "./App/Views/Hotels/Search.php"; ?>
        </div>
    </div>
</div>

<?php

if (isset($meta['data'])) { $HOTELS_DATA = $meta['data']; }
if (empty($HOTELS_DATA)) { ?>

<!-- NO RESULTS PAGE -->
<?php include "App/Views/No_results.php" ?>

<?php } else { ?>

    <div class="position-relative container-fluid bg-light pt-4 pb-4">

    <div class="container">
        <div class="row g-3">
            <!-- left side  -->
            <div class="col-lg-3 d-md-none d-lg-block">
            <div class="sticky-top" style="top:100px">
                <!-- left header  -->
                <div class="position-relative rounded-3 mb-2" style="background-image: url('<?= root ?>assets/img/map.png'); background-size: cover; background-position: 0 -14px; height: 100px;">
                    <button data-bs-toggle="modal" data-bs-target="#MAP" type="button" class="position-absolute btn btn-primary rounded-1 fw-bold translate-middle" style="top: 50%; left: 50%;"><?=T::show_on_map?></button>
                </div>

                <div class="card border-0 rounded-3">

                    <!-- select price  -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center card-title">
                            <span class="fw-bold"><?=T::price?> ( <?=$_SESSION['phptravels_client_currency']?> )</span>
                        </div>

                        <div class="sidebar-price-range">
                            <div class="main-search-input-item">
                                <div class="range-sliderrr" data-filter-group>
                                    <input type="text" class="js-range-slider" data-ref="range-slider-a" value="" />
                                </div>
                         
                            </div>
                        </div>

                        <!-- <div class="d-flex mt-3">
                            <input class="form-control form-control-sm text-center" type="text" name="rangePriceIni" id="rgpri">
                            <span class="mx-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </span>
                            <input class="form-control form-control-sm text-center" type="text" name="rangePricefnl" id="rgprfni">
                        </div> -->
                    </div>

                    <hr class="mt-0 mb-0 text-muted">

                    <div class="sidebar-widget" data-filter-group>
                        <div class="card-body px-2">
                            <p class="card-title fw-bold px-2"><?=T::search_by_name?></p>
                            <input type="text" class="form-control filter--hotel-name" placeholder="Hotel Name" value="" data-search-attribute="class" />
                        </div>
                    </div>
                
                    <hr class="mt-0 mb-0 text-muted">

                    <!-- star rating  -->
                    <div class="card-body px-2 controls">
                        <p class="card-title fw-bold px-2"><?=T::star_rating?></p>

                    <ul class="list-group list remove_duplication hotels--filter-stars" data-filter-group="stars">
 
                      <!-- 1 star -->
                      <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                          <!-- <input class="filter form-check-input m-0" type="checkbox" id="stars_1" data-toggle=".stars_1" value=".stars_1"> -->
                          <input class="filter form-check-input m-0" type="checkbox" id="stars_1" value=".stars_1">
                          <label class="custom-control-label" for="stars_1">
                            <strong>1</strong> &nbsp;
                            <?= star() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                          </label>
                        </div>
                      </li>
                      <!-- 2 stars -->
                      <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                          <!-- <input class="filter form-check-input m-0" type="checkbox" id="stars_2" data-toggle=".stars_2"  value=".stars_2"> -->
                          <input class="filter form-check-input m-0" type="checkbox" id="stars_2" value=".stars_2">
                          <label class="custom-control-label" for="stars_2">
                            <strong>2</strong> &nbsp;
                            <?= star() ?>
                            <?= star() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                          </label>
                        </div>
                      </li>
                      <!-- 3 stars -->
                      <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                      <div class="custom-checkbox d-flex gap-3 align-items-center">
                          <!-- <input class="filter form-check-input m-0" type="checkbox" id="stars_3" data-toggle=".stars_3" value=".stars_3"> -->
                          <input class="filter form-check-input m-0" type="checkbox" id="stars_3" value=".stars_3">
                          <label class="custom-control-label" for="stars_3">
                            <strong>3</strong> &nbsp;
                            <?= star() ?>
                            <?= star() ?>
                            <?= star() ?>
                            <?= star_o() ?>
                            <?= star_o() ?>
                          </label>
                        </div>
                      </li>
                      <!-- 4 stars -->
                      <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                      <div class="custom-checkbox d-flex gap-3 align-items-center">
                          <!-- <input class="filter form-check-input m-0" type="checkbox" id="stars_4" data-toggle=".stars_4" value=".stars_4"> -->
                          <input class="filter form-check-input m-0" type="checkbox" id="stars_4" value=".stars_4">
                          <label class="custom-control-label" for="stars_4">
                            <strong>4</strong> &nbsp;
                            <?= star() ?>
                            <?= star() ?>
                            <?= star() ?>
                            <?= star() ?>
                            <?= star_o() ?>
                          </label>
                        </div>
                      </li>
                      <!-- 5 stars -->
                      <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                      <div class="custom-checkbox d-flex gap-3 align-items-center">
                          <!-- <input class="filter form-check-input m-0" type="checkbox" id="stars_5" data-toggle=".stars_5" value=".stars_5"> -->
                          <input class="filter form-check-input m-0" type="checkbox" id="stars_5" value=".stars_5">
                          <label class="custom-control-label" for="stars_5"><strong>5</strong> &nbsp;
                          <?= star() ?>
                          <?= star() ?>
                          <?= star() ?>
                          <?= star() ?>
                          <?= star() ?>
                          </label>
                        </div>
                      </li>
                    </ul>
           

                    </div>

                    <hr class="mt-0 mb-0 text-muted">

                    <?php
                    // include "hotels_filter.php"
                    ?>

                

                </div>

                <!-- left side end  -->
            </div>
            </div>

            <!-- right side  -->
            <div class="col-md-9">

            <div class="new-m-main-tit__content flex1 mb-4" style="background: url('<?=root?>assets/img/hotels_search.png') center left -800px / cover, rgb(50, 100, 255);">
            <div class="stacked-color"></div>
            <div class="flex tit-travel-restriction-wrapper">
                <h2 class="new-main-tit mx-2">
                    <span class="j_listABTit">
                    <?= count($HOTELS_DATA) ?> <?=T::properties_found?>                        
                    </span>
                </h2>
                <span class="title__fetched-time" style="color: rgb(255, 255, 255);">
                    <strong class="text-uppercase mx-3">
                        <?=$_SESSION['hotels_location']?>
                    </strong>
                    <?=$_SESSION['hotels_checkout']?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h13M12 5l7 7-7 7"/>
                    </svg>
                    <?=$_SESSION['hotels_checkin']?>
                </span>
            </div>
            </div>

                <!-- user hotel filter  -->
                <nav class="#sticky-top uhf" style="top:80px" id="data" data-filter-group>
                    <ul class="flex-nowrap gap-2 flex-sm-wrap gap-sm-0 nav nav-pills nav-justified bg-white rounded overflow-hidden mb-3">

                        <li class="nav-item">
                            <button data-value="price,asc" role="button" class="nav-link border-end active rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100"><?=T::lowest_to_higher?> </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button data-value="price,desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100"><?=T::highest_to_lower?> </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button data-value="popular,desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100"><?=T::most_popular?></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button data-value="star,desc" role="button" class="nav-link rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100"><?=T::star_rating?></span>
                            </button>
                        </li>
                    
                    </ul>

                </nav>
                <!-- user select nav end -->

                <!-- card secion start -->

                <div class="mixitup mt-2" id="hotels--list-js">

                <ul class="list" id="hotels--list-targets">
                
                <?php
                // dd($HOTELS_DATA);
            
                foreach ($HOTELS_DATA as $index => $item) {
                   
                    $payload = [
                        "nationality" => $meta['nationality'],
                        "supplier_name" => $item->supplier_name
                    ];

                    $hash=base64_encode(json_encode($payload));
                    $link = root.'hotel/'.$item->hotel_id.'/'.
                    strtolower(str_replace(' ', '-', $item->name)).'/'.
                    $meta['checkin'].'/'.$meta['checkout'].'/'.$meta['rooms'].'/'.$meta['adults'].'/'.$meta['childs'].'/'.$hash;
                    
                    if($item->supplier_name=="hotels"){
                        (isset($item->img))?$img = root."uploads/".$item->img:$img = root."assets/img/hotel.jpg";
                    } else {
                        $img = $item->img;
                    }
                    ?>
                        <li class="mix stars_<?= $item->stars ?> hotels_amenities_ row g-0 bg-white rounded-2 mb-2 hotel_list <?=str_replace(" ","-",strtolower($item->name)) ?>" data-star="<?= $item->stars ?>" 
                        data-popular="<?= $item->stars ?>" data-stars="stars_<?=$item->stars?>" data-price="<?=str_replace(",","",$item->markup_price)?>" data-a="<?=$item->markup_price?>"  data-name="<?=strtolower($item->name)?>">

                        <div style="width: 8px; height: 8px; position: absolute; z-index: 1; border-radius: 12px; padding: 0; background: <?=$item->color?>; margin: 15px;"></div>

                                    <!-- card left  -->
                                    <div class="col-xxl-3 col-xl-3 col-lg-4 overflow-hidden" style="max-height: 230px;">

                                        <img class=" w-100 h-100" src="<?=$img?>" style="object-fit: cover;" alt="">

                                    </div>

                                    <!-- card right  -->
                                    <div class="col-xxl-9 col-xl-9 col-lg-8 ps-3 p-3">
                                        <!-- card right top  -->

                                        <!-- name and star  -->
                                        <div class="d-flex gap-1 align-items-center">
                                            
                                            <!-- name  -->
                                            <a href="<?=$link?>">
                                            <div class="h-100 text-primary fw-bold h6 text--overflow"><?= $item->name ?></div>
                                            </a>

                                            <!-- star  -->
                                            <div class="d-flex" style="margin-top:-7px">

                                            <?php for ($i = 1; $i <= $item->stars; $i++) { ?>
                                                    <?= star() ?>
                                            <?php } ?>

                                            </div>
                                        </div>

                                        <div class="d-flex gap-1 align-items-center text-muted h6">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                                            </span>
                                            <span class="text--overflow text-capitalize"><?= $item->address ?> <?= $item->location ?></span>
                                            <!-- <a class="text-decoration-none" href="#">Show on Map</a> -->
                                        </div>
                        
                                        <!-- card right bottom  -->
                                        <div class="d-flex justify-content-between rounded-1 mt-3 align-items-center">

                                            <!-- card bottom left  -->
                                            <div>
                                                <!-- person and beds  -->
                                                <div class="d-flex gap-1 align-items-center">


                                                <!-- review in numbers and text -->
                                                <div class="d-flex gap-1 align-items-center">
                                                <span class="fw-bold fs-5"><small><?= $_SESSION['phptravels_client_currency'] ?></small>  <?= $item->markup_price ?></span>

                                                    <!-- border rounded  -->
                                    
                                                </div>
                                
                                                    <!-- <p class="fw-bold my-0">Stabdarad Room 1 Double bed no Smoking</p>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#0f294d" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                    </span>
                                                    <span style="margin-left: -4px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#0f294d" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                    </span> -->
                                   
                                                </div>

                                                <!-- last booked  -->
                                                <!-- <p class="text-muted">Last booked 5 hrs ago</p> -->
                                            </div>

                                            <!-- card bottom right  -->
                                            <div class="d-flex gap-2 align-items-center">
                            
                                            
                                                <!-- discount much  -->
                                                <div class="d-flex justify-content-end align-items-center" >

                                                <div class="btn btn-outline-dark d-inline-flex fw-bold rounded">
                                                        <span>
                                                            <?=T::rating?> <?= $item->stars ?> <span class=""> / 5 </span>
                                                        </span>
                                                    </div>

                                                </div>

                                                <!-- cta  -->
                                                <a href="<?=$link?>" class="d-flex align-items-center btn btn-primary rounded-1" type="button">
                                                    <?=T::details?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs"><path d="M9 18l6-6-6-6"/></svg>
                                                </a>
                                            </div>                                             

                                            <!-- card bottom end  -->
                                        </div>
                        
                                        <!-- card right end  -->
                                    </div>

                                    <!-- card end  -->
                                </li>
                        <?php } ?>


                    <!-- <li class="gap"></li>
                    <li class="gap"></li>
                    <li class="gap"></li> -->
                    </ul>
                    <div class="listjs--pagination-container d-flex gap-1 items-center">
                        <button class="pag--nav prev--pag" type="button" data-add="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/>
                            </svg>
                        </button>
                        <ul class="pagination--listjs"></ul>
                        <button class="pag--nav next--pag" type="button" data-add="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 17l5-5-5-5M6 17l5-5-5-5"/>
                            </svg>
                        </button>
                    </div>
                    <!-- <div class="controls-pagination">
                    <div class="mixitup-page-list"></div>
                    <div class="mixitup-page-stats"></div>
                    </div> -->
                    <p class="fail-message"> <strong><?=T::noresultsfound ?></strong></p>
                
                    <!-- card section end  -->
                </div>          

                <!-- right side end  -->
            </div>

        <!-- simple row end  -->
        </div>

        <!-- simple container end  -->
    </div>


    <!-- back to the top  -->
    <!-- <div class="position-fixed bg-primary rounded-1 top-50 translate-middle-y" style="right: 30px;">
        <a class="btn btn-primary" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M18 15l-6-6-6 6"/></svg>
        </a>
    </div> -->

    <div class="modal fade" id="MAP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel"><?=T::map_view?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div id="map" class="w-100"style="height:450px"></div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=T::close?></button>
        </div>
        </div>
    </div>
    </div>
    
    <style>
        @media only screen and (max-width: 425px) {
            .uhf > .nav { border-radius: 0 !important; padding-block: 10px !important; overflow-x: scroll !important; }
            .uhf > .nav::-webkit-scrollbar {height: 2px !important; }
            .uhf > .nav > .nav-item { border-radius: 20px !important; }
            .uhf > .nav > .nav-item > .nav-link { border: none !important; border-radius: 20px !important; width: 100% !important; padding: 0 !important; }
            /* assigning to parent  */
            .uhf > .nav > .nav-item:not(:has(.active)) { background-color: #f2f5f8 !important;  }
            .uhf > .nav > .nav-item > .nav-link > span { width: max-content !important; padding: 2px 14px !important; }
        }
    </style>

    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCZ7BPby09zybIIFcJHdiE4_-I4fiyWzjw"></script>

<script>


var icons = { parking: { icon: '<?=root?>assets/img/mark.webp' } };


// REPLACE WITH DATA FROM API
var airports = [
    <?php foreach ($HOTELS_DATA as $h){
    $payload = [
        "nationality" => $meta['nationality'],
        "supplier_name" => $h->supplier_name
    ];

    if($item->supplier_name=="hotels"){
        (isset($item->img))?$img = root."uploads/".$item->img:$img = root."assets/img/hotel.jpg";
    } else {
        $img = $item->img;
    }

    $hash=base64_encode(json_encode($payload));
    $link = root.'hotel/'.$h->hotel_id.'/'.
        strtolower(str_replace(' ', '-', $h->name)).'/'.
        $meta['checkin'].'/'.$meta['checkout'].'/'.$meta['rooms'].'/'.$meta['adults'].'/'.$meta['childs'].'/'.$hash;
        ?>
	{ 
		title: '<?=($h->name)?>', 
		position: { 
			lat: <?=($h->latitude)?>, 
			lng: <?=($h->longitude)?>}, 
		icon: 'parking',	
		// content: '<div class="map--content"><div class="content--image"><img src="http://photos.hotelbeds.com/giata/05/059251/059251a_hb_w_009.jpg"></div><div class="content--detail"><h6 id="firstHeading" class="firstHeading"><?=($h->name)?></h6><div class="content--rating-wrapepr"> <span class="content--rating">5.0</span> <div class="content--rating-txt"><span class="performance">Very Good</span> <span class="review">12 reviews</span> </div> </div><a class="btn btn-primary" href="https://www.google.co.uk">More Details</a></div></div></div>'
		content: `<div class="map--content"><div class="content--image"><img src="<?=$img?>"></div><div class="content--detail"><h6 id="firstHeading" class="firstHeading"><?=($h->name)?></h6><div class="content--rating-stars"><?php  for ($i = 1; $i <= $h->stars; $i++) { echo star();}?></div><a class="btn btn-primary" href="<?=$link?>">More Details</a></div></div></div>`
	},
    <?php } ?>

];

function initMap() {
	
 	var uk = { 
		lat: <?=($HOTELS_DATA[0]->latitude)?>, 
		lng: <?=($HOTELS_DATA[0]->longitude)?> 
	};

    
	var map = new google.maps.Map( document.getElementById('map'), {
	  zoom: 12,
	  center: uk, 
	  disableDefaultUI: true,
      zoomControl: true
	//   styles: [{"elementType":"labels","stylers":[{"visibility":"off"},{"color":"#f49f53"}]},{"featureType":"landscape","stylers":[{"color":"#f9ddc5"},{"lightness":-7}]},{"featureType":"road","stylers":[{"color":"#813033"},{"lightness":43}]},{"featureType":"poi.business","stylers":[{"color":"#645c20"},{"lightness":38}]},{"featureType":"water","stylers":[{"color":"#1994bf"},{"saturation":-69},{"gamma":0.99},{"lightness":43}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#f19f53"},{"weight":1.3},{"visibility":"on"},{"lightness":16}]},{"featureType":"poi.business"},{"featureType":"poi.park","stylers":[{"color":"#645c20"},{"lightness":39}]},{"featureType":"poi.school","stylers":[{"color":"#a95521"},{"lightness":35}]},{},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#813033"},{"lightness":38},{"visibility":"off"}]},{},{},{},{},{},{},{},{},{},{},{},{"elementType":"labels"},{"featureType":"poi.sports_complex","stylers":[{"color":"#9e5916"},{"lightness":32}]},{},{"featureType":"poi.government","stylers":[{"color":"#9e5916"},{"lightness":46}]},{"featureType":"transit.station","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","stylers":[{"color":"#813033"},{"lightness":22}]},{"featureType":"transit","stylers":[{"lightness":38}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#f19f53"},{"lightness":-10}]},{},{},{}]
	});
		  
	var InfoWindows = new google.maps.InfoWindow({});
	
	airports.forEach(function(airport) {	
		var marker = new google.maps.Marker({
		  position: { lat: airport.position.lat, lng: airport.position.lng },
		  map: map,
		  icon: icons[airport.icon].icon,
		  title: airport.title
		});
		marker.addListener('mouseover', function() {
		  InfoWindows.open(map, this);
		  InfoWindows.setContent(airport.content);
		});
	});
}

</script>

<script>
    // remove dupicate contents
    var seen = {};
    $(".remove_duplication").find("li").each(function(index, html_obj) { txt = $(this).text().toLowerCase();
    if(seen[txt]) { $(this).remove(); } else { seen[txt] = true; } });

    // price range and filteration
    var $rangeA = $('[data-ref="range-slider-a"]');

    $rangeA.ionRangeSlider({
        skin: "round",
        type: "double",
        min: <?php foreach ($HOTELS_DATA as $index => $item) { $result[$index] = $item->markup_price; } echo $min_price = stristr(min(str_replace(",","",$result)),'.',true); ?>,
        max: <?php foreach ($HOTELS_DATA as $index => $item) { $result[$index] = $item->markup_price; } echo $min_price = stristr(max(str_replace(",","",$result)),'.',true); ?>,
        from: <?php foreach ($HOTELS_DATA as $index => $item) { $result[$index] = $item->markup_price; } echo $min_price = stristr(min(str_replace(",","",$result)),'.',true); ?>,
        to: <?php foreach ($HOTELS_DATA as $index => $item) { $result[$index] = $item->markup_price; } echo $min_price = stristr(max(str_replace(",","",$result)),'.',true); ?>,

        prettify_enabled: false,
        // onChange: handleRangeInputChange
        // onFinish: handleRangeInputChange
        onFinish: function(data) {
            minPrice = data.from;
            maxPrice = data.to;
            
            $("body,html").animate({ scrollTop: $("#hotels--list-targets").offset().top - 250 }, 10);

            hotelsFilterItems();
        }
    });

    var instanceA = $rangeA.data("ionRangeSlider");

    var minPrice = instanceA.result.min;
    var maxPrice = instanceA.result.max;


    let hotelsStarsChecked = [];

    // all controls 
    const starsControls = document.querySelectorAll(".hotels--filter-stars > .list-group-item > .custom-checkbox > input[type='checkbox']");
    const orderControls = document.querySelectorAll(".uhf > .nav.nav-pills > li.nav-item > button.nav-link");

         // list js code 
    var options = {
        valueNames: [
            { data: ['stars'] },
            { data: ['price'] },
            { data: ['popular'] },
            { data: ['star'] },
            { data: ['name'] },
        ],
        page: 25,
        pagination: true,
        pagination: [{
            paginationClass: "pagination--listjs",
            outerWindow: 1
        }]
    };

    var hotelsList = new List("hotels--list-js", options);

    // on load sort by lowest price 
    hotelsList.sort("price", {
        order: 'asc'
    });

    // stars filter
    starsControls.forEach(_starChecked => {
        _starChecked.addEventListener("click", function(e) {
            e.stopPropagation();

            hotelsStarsChecked.length = 0;
            starsControls.forEach(_starCheckedItem => {
                if(_starCheckedItem.checked) { hotelsStarsChecked.push(_starCheckedItem.value.replace(".", "")) }
            })

            $("body,html").animate({ scrollTop: $("#hotels--list-targets").offset().top - 250 }, 10);

            // calling the filter function 
            hotelsFilterItems();
        });
    });
    
    // order filter 
    orderControls.forEach(_orderBtn => {
        _orderBtn.addEventListener("click", function(e) {
            e.stopPropagation();

            const _dataValue = this.getAttribute("data-value").split(",");

            hotelsList.sort(_dataValue[0], {
                order: _dataValue[1]
            });

        });
    });

    // search by name 
    document.querySelector(".filter--hotel-name").addEventListener("input", function() { 
        const _searchQuery = this.value.trim();
        
        $("body,html").animate({ scrollTop: $("#hotels--list-targets").offset().top - 250 }, 10);

        hotelsList.search(_searchQuery, ['name']); 
    });

    // when ever new filter or sort operation complete 
    hotelsList.on("updated", function(list) {
        list.visibleItems.forEach(_item => {
            _item.elm.classList.add("filter--animation")
        })

        clearTimeout(filterAnimation);
        var filterAnimation = setTimeout(() => {
            list.visibleItems.forEach(_item => {
                _item.elm.classList.remove("filter--animation")
            })
        }, 200);

        // document.querySelector("h2.new-main-tit.mx-2 > span.j_listABTit").textContent = `${list.visibleItems.length} Properties Found`;

        if(list.visibleItems.length === 0) {
            // hiding pagination 
            $(".listjs--pagination-container").attr("style", "display: none !important");

            // show error message 
            document.querySelector(".fail-message").style.display = "block";
            document.querySelector(".fail-message").classList.add("filter--animation");
            
            clearTimeout(failFilterAnimation);
            var failFilterAnimation = setTimeout(() => {
                document.querySelector(".fail-message").classList.remove("filter--animation");
            }, 200);
        } else {
            // showing pagination 
            $(".listjs--pagination-container").attr("style", "display: ");
            
            // hiding wrror message 
            document.querySelector(".fail-message").style.display = "none"; 
        }
    });

    // filter function 
    function hotelsFilterItems() {
        hotelsList.filter(function(item) {
            if(hotelsStarsChecked.length > 0) {
                return (
                    hotelsStarsChecked.indexOf(item.values().stars) > -1 &&
                    parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice + 1
                );
            } else if(hotelsStarsChecked.length == 0) {
                return (
                    parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice + 1
                );
            }
        })
    }

     // pagination navigation 
    document.querySelectorAll(".pag--nav").forEach(_pagNavBtn => {
        _pagNavBtn.addEventListener("click", function() {
           const _activePage = parseInt( document.querySelector(".listjs--pagination-container > .pagination--listjs > li.active > a").getAttribute("data-i") );
           const _toAdd = parseInt( this.getAttribute("data-add") );
           
        //    sum 
           const _pageNumber = _activePage + _toAdd;

           
           //    get the next element if exist 
           const _getNextElement = document.querySelector(`.listjs--pagination-container > .pagination--listjs > li > a[data-i="${_pageNumber}"]`);
           
           //  if exist trigger click
           if( _getNextElement ) {
            _getNextElement.click();
           }
        });
    });


</script>
    
<?php } ?>

<style>
    .map--content {
        display: flex;
        gap: 10px;
    }
    .map--content .content--image {
        border-radius: 4px;
        height: 140px; width: 120px; 
        overflow: hidden;
    }
    .map--content .content--image img {
        width: 100%; height: 100%;
    }
    .content--detail {
        width: 200px;
        display: flex;
        flex-direction: column;
        padding: 5px;
    }
    .content--detail a {
        margin-top: auto;
    }
</style>