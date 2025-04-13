<!-- slick  -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script src="<?=root?>assets/js/plugins/slick.js"></script>

<!-- fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<?php 
   (isset($meta['data']))?$hotel=$meta['data']:$hotel="";
   ?>
<div class="bg-light pt-4">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb d-none d-lg-flex d-md-flex">
            <li class="breadcrumb-item"><a href="<?=root?>"><?=T::home?></a></li>
            <li class="breadcrumb-item"><a href="<?=root?>hotels"><?=T::hotels?></a></li>
            <li class="breadcrumb-item"><a href="#"><?=$hotel->city?></a></li>
            <li class="breadcrumb-item active"><?=$hotel->name?></li>
         </ol>
      </nav>
      <div class="rounded-2 overflow-hidden bg-white mt-2 px-3 py-4">
         <div class="row">
            <!-- left  -->
            <div class="col-xl-8 col-md-8 col-sm-12 mb-3">
               <div class="d-md-flex d-sm-block gap-1 align-items-center justify-content-lg-start justify-content-md-center">
                  <div class="h4 fw-bold mb-0"><?=$hotel->name?></div>
                  <!-- star and thumb  -->
                  <div class="d-flex gap-1 align-items-center mb-1">
                     <div style="margin-top:5px;" class="d-flex">
                        <?php for ($i = 1; $i <= $hotel->stars; $i++) { ?>
                        <?= star() ?>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <!-- location and map  -->
               <div class="d-flex gap-1 align-items-center">
                  <span class="mb-1">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="10" r="3" />
                        <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z" />
                     </svg>
                  </span>
                  <span class="text--overflow">
                  <?=$hotel->address?>, <?=$hotel->city?>, <?=$hotel->country?> 
                  </span>
               </div>
            </div>
            <div class="col-xl-4 col-md-4">
               <div class="d-flex justify-content-end align-items-start h-100">
                  <div class="d-flex gap-1 align-items-center">
                     <span class="h3 fw-bold"></span>
                  </div>
                  <a class="d-none d-lg-flex d-md-flex w-50 btn btn-primary rounded-2 py-3 fw-bold d-flex align-items-center justify-content-center gap-2" href="#rooms">
                     <?=T::select_room?>
                     <svg class="" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9l6 6 6-6"></path>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <!-- carasoul -->
         <div class="col-md-12">
            <ul class="carasoul px-0 m-0">
               <?php foreach ($hotel->img as $img){ ?>
               <li data-src="<?=root?>uploads/<?=$img?>" data-fancybox="gallery"
                  class="carasoul--img">
                  <?php 
                  $root = root;
                  if (@getimagesize("$root/uploads/$img")) {
                     echo "<img src=$root/uploads/$img alt=''"; 
                  }else{
                     echo "<img src=$img alt=''";
                  }
                  ?>
               </li>
               <?php } ?>
               <!-- <li data-src="<?=root?>assets/img/data/hero_images/slider/hero_small_6.webp" data-fancybox="gallery"
                  class="carasoul--last carasoul--img overflow-hidden border">
                  <img src="<?=root?>assets/img/data/hero_images/slider/hero_small_6.webp" alt="">
                  
                  <div class="overlay d-flex flex-column justify-content-center align-items-center overflow-hidden rounded-2 text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                          fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round">
                          <g transform="translate(2 3)">
                              <path
                                  d="M20 16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3l2-3h6l2 3h3a2 2 0 0 1 2 2v11z" />
                              <circle cx="10" cy="10" r="4" />
                          </g>
                      </svg>
                      <div class="fw-bold">
                          <span>See All</span>
                          <span>249</span>
                          <span>Photos</span>
                      </div>
                  </div>
                  </li> -->
               <!-- <div class="carasoul--icon love">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                      fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round">
                      <path
                          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                      </path>
                  </svg>
                  </div> -->
               <div class="carasoul--icon imgvalue py-1 text-white">
                  <span class="current"></span>
                  <span class="actual"></span>
               </div>
               <button class="carasoul--btn btn--left" type="button" onclick="showImage(-1)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                     <path d="M15 18l-6-6 6-6" />
                  </svg>
               </button>
               <button class="carasoul--btn btn--right" type="button" onclick="showImage(1)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                     <path d="M9 18l6-6-6-6" />
                  </svg>
               </button>
            </ul>
         </div>
         <div class="col-md-12">
            <div class="row mt-3 g-0">
               <div class="col-md-12 bg-light rounded-2 overflow-hidden p-3 shadow-sm" style="background: url(<?=root?>assets/img/map.png) no-repeat right; background-size: 100%;">
                  <div class="d-block gap-2 align-items-center">
                     <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                           fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                           stroke-linejoin="round">
                           <circle cx="12" cy="10" r="3" />
                           <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z" />
                        </svg>
                     </span>
                     <span class=""><?=$hotel->address?>, <?=$hotel->city?>, <?=$hotel->country?> </span>
                     <a class="text-decoration-none fw-bold px-2" href="#map">
                        <?=T::show_on_map?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 24 24"
                           fill="none" stroke="#3264ff" stroke-width="2" stroke-linecap="round"
                           stroke-linejoin="round">
                           <path d="M9 18l6-6-6-6" />
                        </svg>
                     </a>
                  </div>
               </div>
               <!-- 
                  <div class="col-md-6 bg-light rounded-2 overflow-hidden p-3 shadow-sm">
                      <div class="row">
                          <div class="col-lg-4 col-md-12">
                              <div class="d-flex gap-2 flex-lg-column flex-md-row flex-column justify-content-lg-start justify-content-md-between align-items-md-start">
                  
                                  <div class="d-flex gap-3 align-items-end">
                                      <span class="d-flex bg-primary rounded-pill px-2 text-white fw-bold">
                                          <span>4.2</span>
                                          <span>/5</span>
                                      </span>
                                      <a class="d-flex align-items-center text-decoration-none" type="button">
                                          <span>266 Reviews</span>
                                          <span>
                                              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                  viewBox="0 0 24 24" fill="none" stroke="#3264ff" stroke-width="1"
                                                  stroke-linecap="round" stroke-linejoin="round">
                                                  <path d="M9 18l6-6-6-6" />
                                              </svg>
                                          </span>
                                      </a>
                                  </div>
                  
                                  <div class="d-flex flex-column align-items-sm-start align-items-center">
                                      <q>Great stay!</q>
                                      <span>96% Recommended</span>
                                  </div>
                              </div>
                          </div>
                  
                          <div class="detail--bar col-lg-8 col-12 d-flex justify-content-between flex-wrap gap-3 gap-md-3 gap-lg-0">
                              <div>
                                  <div class="d-flex justify-content-between text-primary">
                                      <span>Cleanliness</span>
                                      <span>4.1</span>
                                  </div>
                                  <div class="progress h-25">
                                      <span class="w-75 progress-bar bg-primary"></span>
                                  </div>
                              </div>
                  
                              <div>
                                  <div class="d-flex justify-content-between text-primary">
                                      <span>Amenities</span>
                                      <span>4.0</span>
                                  </div>
                                  <div class="progress h-25">
                                      <span class="w-50 progress-bar bg-primary"></span>
                                  </div>
                              </div>
                  
                              <div>
                                  <div class="d-flex justify-content-between text-primary">
                                      <span>Location</span>
                                      <span>4.5</span>
                                  </div>
                                  <div class="progress h-25">
                                      <span class="w-75 progress-bar bg-primary"></span>
                                  </div>
                              </div>
                  
                              <div>
                                  <div class="d-flex justify-content-between text-primary">
                                      <span>Service</span>
                                      <span>4.1</span>
                                  </div>
                                  <div class="progress h-25">
                                      <span class="w-50 progress-bar bg-primary"></span>
                                  </div>
                              </div>
                          </div>
                      </div> 
                  </div>
                  -->
            </div>
         </div>
      </div>
      <!-- rooms  -->
      <div id="rooms"></div>
      <h4 class="mt-4"><strong><?=T::hotel?> <?=T::rooms?></strong></h4>
    <?php foreach ($hotel->rooms as $room) { 
   
    // CONDITION TO CHECK IF IMAGE EXIST
    (@getimagesize(root."uploads/".$room->img))?$img = root."uploads/".$room->img:$img = root."assets/img/hotel.jpg";
    ?>
      <div class="row gx-0 gy-3 bg-white rounded-2 overflow-hidden mt-3 px-3 pb-3">
         <div class="text-lg-start text-md-center h5 fw-bold"><?=$room->name?></div>
         <!-- left  -->
         <div class="col-xl-2 col-md-12">
            <div class="row g-0">
               <!-- images  -->
               <div class="col-12 col-sm-12">
                  <!-- classic room images  -->
                  <div class="position-relative rounded-2 h-100 overflow-hidden">
                     <div class="row g-0 h-100" id="cltrm">
                        <!-- big iamge  -->
                        <div class="col-md-12">
                           <div class="rounded overflow-hidden h-100">
                              <img data-fancybox="gallery"
                                 data-src="<?=$img?>"
                                 class="w-100 h-100"
                                 src="<?=$img?>" alt="room"
                                 style="object-fit: cover;">
                           </div>
                        </div>
                        <!-- small images  -->
                        <div class="d-none d-sm-flex row g-0 mt-1">
                           <!-- <div class="col">
                              <div class="rounded overflow-hidden">
                                  <img data-fancybox="gallery"
                                      data-src="<?=root?>assets/img/data/rooms type/classic_twin/classic_twin_1.webp"
                                      class="w-100 h-100"
                                      src="<?=root?>assets/img/data/rooms type/classic_twin/classic_twin_1.webp" alt=""
                                      style="object-fit: cover;">
                              </div>
                              </div>
                              
                              <div class="col ms-1">
                              <div class="rounded overflow-hidden">
                                  <img data-fancybox="gallery"
                                      data-src="<?=root?>assets/img/data/rooms type/classic_twin/classic_twin_2.webp"
                                      class="w-100 h-100"
                                      src="<?=root?>assets/img/data/rooms type/classic_twin/classic_twin_2.webp" alt=""
                                      style="object-fit: cover;">
                              </div>
                              </div> -->
                        </div>
                     </div>
                     <!-- images counter  -->
                     <!-- <div class="d-sm-none d-lg-block position-absolute end-0 bottom-0 bg-dark px-2 text-white fw-bold">3</div> -->
                  </div>
               </div>
               <!-- other description  -->
               <div class="col-6 col-sm-12">
                  <div class="row g-0 ps-2 ps-sm-1">
                     <div class="col-xl-12 col-md-6">
                        <div class="d-md-flex flex-md-column justify-content-md-center align-items-md-center d-xl-block">
                           <div class="mt-2">
                              <?php foreach($room->amenities as $i) {?>
                              <div class="d-flex align-items-center">
                                 <span class="fw-bold"><?=$i?></span>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <hr class="d-xl-block d-none mt-3 mb-1">
                     <div class="col-xl-12 col-md-6">
                        <div class="h-100 d-md-flex flex-md-column justify-content-md-center align-items-md-center d-xl-block">
                           <div class="d-flex gap-1 gap-sm-2 align-items-center">
                           </div>
                           <!-- <div class="mt-1 text-primary fw-bold">All Amenities</div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- left end  -->
         <!-- right  -->
         <div class="col-xl-10 col-md-12 col-12 px-xl-4 px-lg-0" style="font-size: 14px;">
            <!-- table heading  -->
            <div class="d-none d-md-flex row g-0 bg-light border border-bottom-0 rounded-1 px-3 py-1 overflow-hidden">
               <div class="col-xl-5 col-lg-5 col-md-5">
                  <span class="fw-bold"><?=T::options?></span>
               </div>
               <div class="col-xl-2   col-lg-1 col-md-1 text-center">
                  <span class="fw-bold"><?=T::travellers?></span>
               </div>
               <div class="col-xl-5 col-lg-6 col-md-6 text-center">
                  <span class="fw-bold"><?=T::price?></span>
               </div>
            </div>
            <!-- table data  -->
            <div class="mt-sm-3 mt-md-0">
               <?php foreach($room->options as $i => $options){ ?>
               <form action="<?=root?>hotels/booking" method="POST">
               <!-- 1  -->
               <div class="row g-0">
                  <div class="d-flex d-sm-none bg-light border border-bottom-0 w-100 fw-bold">
                     <span class="w-100 text-center"><?=T::your_choice?></span>
                     <span class="w-100 text-center"><?=T::today_s_price?></span>
                  </div>
                  <div class="col-6 order-1 order-sm-1 col-6 col-xl-5 col-lg-5 col-md-5 border border-top-0 border-bottom p-3">
                     <span class="d-inline-block bg-primary rounded-1 text-white fw-bold mb-2 px-3"><?=T::option?> <?=$i+1?></span>
                     <?php if ($options->breakfast==1){?>
                     <div class="text-success">
                        <span class="text-decoration-underline fw-bold gap-2 d-flex align-items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                              <polyline points="22 4 12 14.01 9 11.01"></polyline>
                           </svg>
                           <?=T::free_breakfast?>
                        </span>
                     </div>
                     <?php } ?>
                     <?php if ($options->cancellation==1){?>
                     <div class="text-danger">
                        <span class="text-decoration-underline fw-bold gap-2 d-flex align-items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                              <polyline points="22 4 12 14.01 9 11.01"></polyline>
                           </svg>
                           <?=T::free_cancellation?>
                        </span>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="order-3 order-sm-2 col-12 col-xl-2 col-lg-1 col-md-1 border border-top-0 text-center p-sm-3 mb-3 mb-sm-0 d-flex align-items-center justify-content-center">
                     <div class="mx-1">
                        <!-- ADULTS -->
                        <?php for ($i = 1; $i <= $options->adults; $i++) { ?>
                        <svg style="margin-left:-6px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                           <text transform="matrix(1 0 0 1 168.7834 543.8093)">
                              <tspan x="0" y="0" fill="#FFFF00" font-family="'Verdana-Bold'" font-size="20">simpleicon.com</tspan>
                              <tspan x="-159.59" y="24" fill="#FFFF00" font-family="'Verdana'" font-size="20"><?=T::Collection_of_flat_icon_symbols_and_glyph_icons?></tspan>
                           </text>
                           <path fill="#020201" d="M454.426,392.582c-5.439-16.32-15.298-32.782-29.839-42.362c-27.979-18.572-60.578-28.479-92.099-39.085 c-7.604-2.664-15.33-5.568-22.279-9.7c-6.204-3.686-8.533-11.246-9.974-17.886c-0.636-3.512-1.026-7.116-1.228-10.661 c22.857-31.267,38.019-82.295,38.019-124.136c0-65.298-36.896-83.495-82.402-83.495c-45.515,0-82.403,18.17-82.403,83.468 c0,43.338,16.255,96.5,40.489,127.383c-0.221,2.438-0.511,4.876-0.95,7.303c-1.444,6.639-3.77,14.058-9.97,17.743 c-6.957,4.133-14.682,6.756-22.287,9.42c-31.521,10.605-64.119,19.957-92.091,38.529c-14.549,9.58-24.403,27.159-29.838,43.479 c-5.597,16.938-7.886,37.917-7.541,54.917h205.958h205.974C462.313,430.5,460.019,409.521,454.426,392.582z"/>
                        </svg>
                        <?php } ?>
                     </div>
                     <!-- <hr class="m-1 mt-2" /> -->
                     <!-- CHILDS -->
                     <?php for ($i = 1; $i <= $options->child; $i++) { ?>
                     <svg style="margin-left:-2px;margin-top:3px" width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="16" height="16" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 8C6 4.68629 8.68629 2 12 2C15.3137 2 18 4.68629 18 8C18 11.3137 15.3137 14 12 14C8.68629 14 6 11.3137 6 8Z" fill="#000"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.43094 16.9025C7.05587 16.2213 9.2233 16 12 16C14.771 16 16.9351 16.2204 18.5586 16.8981C20.3012 17.6255 21.3708 18.8613 21.941 20.6587C22.1528 21.3267 21.6518 22 20.9592 22H3.03459C2.34482 22 1.84679 21.3297 2.0569 20.6654C2.62537 18.8681 3.69119 17.6318 5.43094 16.9025Z" fill="#000"/>
                     </svg>
                     <?php } ?>
                  </div>
                  <div class="col-6 order-2 order-sm-3 col-xl-5 col-lg-6 col-md-6 border border-top-0 p-3">
                     <div class="d-lg-flex d-md-flex justify-content-center align-items-center h-100">
                        <select name="room_quantity" class="form-select px-4" style="height:52px">
                           <?php 

                             (isset($options->quantity))?$quantity=$options->quantity:$quantity=1;

                              for (
                              $i = 1; 
                              $i <= $quantity; 
                              $i++){ ?>
                           <option class="" value="<?=$i?>"><?=$i?> - <?=currency?> <?=$i * $options->price ?></option>
                           <?php } ?>
                        </select>
                        <div class="col-xl-5 col-lg-5 col-md-12 col-12 ps-sm-3 mb-2 mb-md-0 text-center">
                           <div>
                              <button type="submit" class="btn btn-primary fw-bold w-100 mt-3 mt-lg-0 mt-md-0" type="button"><?=currency?> <?=$options->price?> <small class="d-block"><?=T::booknow?></small></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php

                $payload = [
                "supplier_name" => $hotel->supplier_name,
                "hotel_id" => $hotel->id,
                "hotel_name" => $hotel->name,
                "hotel_img" => $hotel->img[0],
                "hotel_address" => $hotel->city . "&nbsp;" . $hotel->address,
                "hotel_stars" => $hotel->stars,
                "room_id" => $room->id,
                "room_type" => $room->name,
                "currency" => currency,
                "room_price" => $options->price,
                "real_price" => $options->price,
                "checkin" => $meta['checkin'],
                "checkout" => $meta['checkout'],
                "adults" => $meta['adults'],
                "childs" => $meta['childs'],
                "supplier" => $hotel->supplier_name,
                "nationality" => $meta['nationality'],
                "city_name" => $hotel->city,
                "latitude" => $hotel->latitude,
                "longitude" => $hotel->longitude,
                "booking_data" => $options,
                "adult_travellers" => $hotel->hotel_phone,
                "child_travellers" => $hotel->hotel_phone,
                "hotel_phone" => $hotel->hotel_phone,
                "hotel_email" => $hotel->hotel_email,
                "hotel_website" => $hotel->hotel_website,
                "children_ages" => "",
                "cancellation_policy" => $hotel->cancellation,
                "room_data" => $room->options[0],
                ];

                ?>

               <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($payload)) ?>">
               </form>
               <?php } ?>
            </div>
            <!-- show more  -->
         </div>
      </div>
      <?php } ?>
      <!-- Fine Print -->
      <div class="row gx-0 gy-3 bg-white rounded-2 overflow-hidden mt-3 px-3 pb-3">
         <div class="h5 fw-bold mb-0 mb-sm-1"><?=T::hotel_policy?></div>
         <div class="fw-bold col-md-3 text-sm-start"><?=T::Check_in_and_check_out?></div>
         <div class="col-md-3">
            <span class=""><?=T::from?> <strong><?=$hotel->checkin?></strong> <?=T::to?> <strong><?=$hotel->checkout?></strong> </span>
          </div>
         <hr />
         <div class="col-md-3 fw-bold"><?=T::age_requirements?></div>

         <?php 
         if (empty($hotel->booking_age_requirement)) {
            $age = 12;
         } else {
            $age = $hotel->booking_age_requirement;
         }
         ?>
         <div class="col-md-9">The guest checking in must be at least <strong><?=$age?></strong> years old.</div>
         <hr />

         <?php 
         if (empty($hotel->policy)) {
            $policy_ = "Our hotel is dedicated to ensuring a comfortable and enjoyable experience for all guests. We maintain a strict no-smoking policy throughout the premises, and pets are not permitted. We value the safety of our guests and have 24/7 security and surveillance in place. To promote a serene environment, we request all guests to keep noise levels to a minimum, especially during nighttime hours. We appreciate your cooperation in adhering to these policies and look forward to providing you with a pleasant stay";
         } else {
            $policy_ = $hotel->policy;
         }
         ?>

         <div class="col-md-3 fw-bold"><?=T::policy?></div>
         <div class="col-md-9 mt-0 mt-sm-1">
            <?=$policy_?>
         </div>
         <hr />

         <?php 
         if (empty($hotel->cancellation)) {
            $cancellation_ = "Our hotel cancellation policy aims to provide flexibility and convenience to our valued guests. Reservations can be canceled up to 2 days prior to the check-in date without incurring any charges. For cancellations made within 2 days of the check-in date or in case of a no-show, a fee equivalent to 5% of the total reservation amount will be charged. We understand that plans can change, and we strive to accommodate your needs while maintaining the quality of our services. Thank you for considering for your stay.";
         } else {
            $cancellation_ = $hotel->cancellation;
         }
         ?>

         <div class="col-md-3 fw-bold"><?=T::cancellation?></div>
         <div class="col-md-9 mt-0 mt-sm-1">
            <?=$cancellation_?>
         </div>
      </div>
      <!-- property Description  -->
      <div class="row gx-0 gy-3 bg-white rounded-2 overflow-hidden mt-3 px-3 pb-3">
         <div class="col-xl-12 h5 fw-bold"><?=T::property_description?></div>
         <div>
            <?=$hotel->desc?>
         </div>
      </div>
      <!-- Services & Amenities  -->
      <div class="row gx-0 gy-3 bg-white rounded-2 overflow-hidden mt-3 px-3 pb-3">
         <div class="h5 fw-bold"><?=T::services_amenities?></div>
         <?php 
            // AMENITIES
            foreach($hotel->amenities as $i) {
                if(!empty($i)){
            ?>
         <div class="col-xl-3">
            <div class="d-flex gap-2 align-items-center">
               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
               </svg>
               <span><?=$i?></span>
            </div>
         </div>
         <?php } } ?>
      </div>
      <!-- properities nearby  -->
      <?php  if (isset($_SESSION['related_hotels'])){ ?>
      <div class="bg-white rounded-2 overflow-hidden mt-3 px-4 pb-3">
         <div class="pt-3 ps-2 h5 fw-bold"><?=T::properties_nearby?></div>
         <ul class="touch_car row g-0 gy-4 list-group list-group-horizontal mt-3">
            <?php 
               foreach ($_SESSION['related_hotels']->data as $item) { 
                   (isset($_SESSION['hotels_nationality']))?$nationality=$_SESSION['hotels_nationality']:$nationality="US";
                   $link = root.'hotel/'.$item->hotel_id.'/'.
                   clean_var($item->name).'/'.
                   $meta['checkin'].'/'.$meta['checkout'].'/'.$meta['rooms'].'/'.$meta['adults'].'/'.$meta['childs'].'/'.$nationality;
//                   (isset($item->img))?$img = root."uploads/".$item->img:$img = root."assets/img/hotel.jpg";
                   ?>
            <li class="col-lg-3 col-md-6 col-12 list-group-item border-0 px-2 py-0">
               <div class="border rounded-2 overflow-hidden">
                  <a class="d-inline-block w-100 text-decoration-none" href="<?=$link?>" >
                     <div>
                        <!-- img  -->
                        <div class="w-100 rounded-top overflow-hidden" style="height: 186px;">
                            <?php
                            if($item->supplier_name=="hotels"){
                                (isset($item->img))?$img = root."uploads/".$item->img:$img = root."assets/img/hotel.jpg";
                            } else {
                                $img = $item->img;
                            }
                            ?>
                           <img class="w-100 h-100" src="<?=$img?>" alt=""
                              style="object-fit: cover;">
                        </div>
                        <div class="position-relative px-3">
                           <!-- review  -->
                           <!-- <div class="position-absolute bg-white border border-primary rounded-pill overflow-hidden pe-2"
                              style="top: -14px; left: 8px;">
                              <span
                                  class="d-inline-block bg-primary rounded-pill px-2 h-100 text-white fw-bold">3.6<span
                                      class="text-muted">/5</span></span>
                              <span class="text-primary">23 reviews</span>
                              </div> -->
                           <div class="pt-3">
                              <span class="h6 overflow-hidden" style="white-space: nowrap; text-overflow: ellipsis;"><strong><?=$item->name?></strong></span>
                              <div class="d-block"></div>
                              <div class="text-muted">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="10" r="3"/>
                                    <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
                                 </svg>
                                 <span><?=$item->location?></span>
                              </div>
                           </div>
                           <?php for ($i = 1; $i <= $item->stars; $i++) { ?>
                           <?= star() ?>
                           <?php } ?>
                           <div class="d-flex flex-column align-items-start mt-3 mb-2">
                              <span class="h5 fw-bold m-0 text-dark">
                              <small>
                              <?=$_SESSION['phptravels_client_currency']?>
                              </small>
                              <?=$item->markup_price?>
                              </span>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            </li>
            <?php }?>
         </ul>
      </div>
      <?php } ?>
      <!-- Recently Viewed -->
      <div class="row gx-1 gy-0 bg-white rounded-2 overflow-hidden mt-3 px-3 pb-3">
         <div class="h5 fw-bold mt-4 mb-3"><?=T::recently_viewed?></div>
         <?php  
            $max = 12;
            $max_print = count(array_unique($_SESSION['HOTEL_DETAILS'], SORT_REGULAR));
            krsort($_SESSION['HOTEL_DETAILS']); 
            $data=(array_unique($_SESSION['HOTEL_DETAILS'], SORT_REGULAR)); 
            foreach($data as $d){
            (isset($_SESSION['hotels_nationality']))?$nationality=$_SESSION['hotels_nationality']:$nationality="US";
            ?> 
         <div class="col-md-4 mb-1">
            <div class="bg-light p-3 rounded-2 overflow-hidden">
               <div class="d-flex gap-2">
                  <div class="rounded-2 overflow-hidden" style="height: 70px; width: 104px;">
                      <?php
                      if($d->supplier_name=="hotels"){
                          (isset($d->img[0]))?$img = root."uploads/".$d->img[0]:$img = root."assets/img/hotel.jpg";
                      } else {
                          $img = $d->img[0];
                      }
                      ?>
                     <img class="w-100" style="height:100%" src="<?=$img?>" alt="" style="object-fit: cover;">
                  </div>
                  <a class="w-100" href="<?=root?>hotel/<?=$d->id?>/<?=clean_var($d->name)?>/<?=date('d-m-Y',strtotime('+3 day')).'/'.date('d-m-Y',strtotime('+4 day')).'/1/2/0/'.$nationality;?>">
                     <div class="h6 mb-1 text--overflow"><strong><?=$d->name?></strong></div>
                     <div class="h6 mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <circle cx="12" cy="10" r="3"></circle>
                           <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                        </svg>
                        <?=$d->city?>, <?=$d->country?>
                     </div>
                     <?php for ($i = 1; $i <= $d->stars; $i++) { ?>
                     <?= star() ?>
                     <?php } ?>
                  </a>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>

      <div class="row gx-1 gy-0 bg-white rounded-2 overflow-hidden mt-3 px-3 pt-3 p-5">

      <div class="h5 fw-bold mt-0 mb-3"><?=T::adress_on_map?></div>
      <div id='map'></div>
      </div>

      <?php 
      $cords = explode (",", $hotel->longitude);
      ?>

      <script>

function initMap() {
    var mapOpts = {
        center: {
         lat: <?=$cords[0]?>,
         lng: <?=$cords[1]?>
        },
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        styles: [{
            "featureType": "road.local",
            "stylers": [{
                "weight": 4.5
            }]
        }]
    };
    var map = new google.maps.Map(document.getElementById('map'), mapOpts);
    var bicyclayer = new google.maps.BicyclingLayer();
    bicyclayer.setMap(map);
    var infowincontent = '<div style="width:200px">CONTENT</div>';
    var marker0 = new google.maps.Marker({
        position: {
         lat: <?=$cords[0]?>,
         lng: <?=$cords[1]?>
        },
        map: map,
        title: 'Old Highway 80 Overpass',
        animation: google.maps.Animation.DROP
    });
    var infowindow0 = new google.maps.InfoWindow({
        content: infowincontent.replace('CONTENT', 'Be careful of traffic on 80. Visibility is poor around the bends, but there are good shoulders further on. Clinton has gas stations, restaurants, and hotels. Loads of people commute on the Trace from Clinton to Ridgeland, so don\'t bike this during rush hour.')
    });
    marker0.addListener('click', function() {
        infowindow0.open(map, marker0)
    });
    
}

   </script>
      
      <style>
         #map{height:400px !important;width:100%}
      </style>

      <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCZ7BPby09zybIIFcJHdiE4_-I4fiyWzjw"></script>

      <!-- Haven't found the right property -->
      <div class="row gx-0 gy-3 bg-white rounded-2 overflow-hidden mt-3 px-3 py-5 text-center">
         <svg class="text-center" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
         </svg>
         <div class="col-xl-12 h4 fw-bold"><?=T::haven_t_found_the_right_property_yet?></div>
         <div class="col-xl-12 mt-3">
         <a href="<?=root?>page/contact" class="btn btn-primary rounded-1"><?=T::contact_us_now?></a>
         </div>
      </div>
      <!-- simple container end   -->

      <div class="pb-5"></div>
   </div>
</div>

<script>
   const totalImages = document.querySelectorAll(".carasoul > .carasoul--img");
   const imagesLength = totalImages.length;
   let index = 0;
   
   let imgCountAct = document.querySelector(".imgvalue > .actual");
   let imgCountCurr = document.querySelector(".imgvalue > .current");
   
   imgCountCurr.textContent = "1";
   imgCountAct.textContent = `/${imagesLength}`;
   
   function showImage(imgVal) {
   totalImages.forEach((li) => {
       li.style.display = "none";
   });
   
   index += imgVal;
   
   if (index === imagesLength) {
       index = 0;
   }
   if (index === -1) {
       index += imagesLength;
   }
   
   totalImages[index].style.display = "block";
   imgCountCurr.textContent = `${index + 1} `;
   }
   
   // top slider
   Fancybox.bind(document.querySelector('.carasoul'), '[data-fancybox="gallery"]', {
   Toolbar: {
       display: {
       left: ["infobar"],
       middle: [
           "zoomIn",
           "zoomOut",
           "toggle1to1",
       ],
       right: ["close"],
       },
   }
   });
   
   // rooms images slider
   
   // classic twin 
   Fancybox.bind(document.getElementById('cltrm') ,'[data-fancybox="gallery"]', {
   Toolbar: {
       display: {
       left: ["infobar"],
       middle: [
           "zoomIn",
           "zoomOut",
           "toggle1to1",
       ],
       right: ["close"],
       },
   }
   });
   
   // classic king room 
   Fancybox.bind(document.getElementById('clkr') ,'[data-fancybox="gallery"]', {
   Toolbar: {
       display: {
       left: ["infobar"],
       middle: [
           "zoomIn",
           "zoomOut",
           "toggle1to1",
       ],
       right: ["close"],
       },
   }
   });
   
   // twin club room 
   Fancybox.bind(document.getElementById('tcr') ,'[data-fancybox="gallery"]', {
   Toolbar: {
       display: {
       left: ["infobar"],
       middle: [
           "zoomIn",
           "zoomOut",
           "toggle1to1",
       ],
       right: ["close"],
       },
   }
   });
   
   // premium room 
   
   Fancybox.bind(document.getElementById('prmumr') ,'[data-fancybox="gallery"]', {
   Toolbar: {
       display: {
       left: ["infobar"],
       middle: [
           "zoomIn",
           "zoomOut",
           "toggle1to1",
       ],
       right: ["close"],
       },
   }
   });
   
   // near by propertity 
   $(".touch_car").slick({
       infinite: true,
       speed: 300,
       slidesToShow: 4,
       slidesToScroll: 1,
       responsive: [
           {
           breakpoint: 1025,
           settings: {
               autoplay: false,
               slidesToShow: 4,
               slidesToScroll: 1,
           },
           },
           {
           breakpoint: 769,
           settings: {
               autoplay: false,
               arrows: false,
               slidesToShow: 2,
               slidesToScroll: 1,
           },
           },
           {
           breakpoint: 480,
           settings: {
               arrows: false,
               slidesToShow: 1,
               slidesToScroll: 1,
           },
           },
       ],
   });
   
</script>