<?php 
   if (!empty(base()->featured_flights)){?>
<div data-aos="fade-up" class="featured py-5">
<div class="container">
   <section class="round-trip-flight mb-4">
      <div class="row">
         <div class="col-lg-12">
            <div class="section-heading text-end">
               <h4><strong><?=T::flights_featured_flights?></strong></h4>
               <small><?=T::these_alluring_destinations_are_picked_just_for_you?></small>
               <div class="mb-4"></div>
            </div>
            <!-- end section-heading -->
         </div>
         <!-- end col-lg-12 -->
      </div>
      <!-- end row -->
      <div class="row padding-top-0px">
         <div class="col-lg-12">
            <div class="popular-round-trip-wrap padding-top-10px">
               <div class="tab-content" id="myTabContent4">
                  <div class="tab-pane fade show active" id="" role="" aria-labelledby="">
                     <div class="row g-3">
                        <div class="col-md-3">
                           <div class="shadow-sm rounded card-item p-2">
                              <div class="card-img">
                                 <a href="<?=root?>flights" class="d-block" tabindex="0">
                                    <img src="<?=root?>assets/img/featured_flights.png" class="w-100" alt="hotel-img">
                                    <div class="pt-5" style="border-bottom-right-radius: 6px; border-bottom-left-radius: 6px; position: absolute; width: 100%; z-index: 9; display: block; padding: 25px 20px 5px; color: #fff; left: 0; bottom: 0; height: 164px; background: transparent; background: linear-gradient(to bottom,transparent,#005cff); box-sizing: border-box;">
                                       <h6 class="strong text-center"><strong><?=T::find_the_next_flight_for_your_trip?></strong></h6>
                                       <span class="btn btn-block btn-outline-light w-100">
                                       <?=T::view_more?>
                                       </span>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="row g-3 mb-1">
                              <?php 
                                 foreach (base()->featured_flights as $flights){
                                 
                                 // $from = explode(" ", $flights->from);
                                 // $froms = end($from);
                                 
                                 // $to = explode(" ", $flights->to);
                                 // $tos = end($to);
                                 
                                 // // get flights codes
                                 // $from_code = explode(' ',trim($flights->from));
                                 // $to_code = explode(' ',trim($flights->to));
                                 
                                 ?>
                              <!-- <script>
                                 $.ajax({
                                 type: "GET",
                                 url: "https://www.kayak.com/mvm/smartyv2/search?f=j&s=airportonly&where=<?=strtolower($flights->origin)?>",
                                 cache: false,
                                 success: function(data){
                                 if (typeof data[0].destination_images !== 'undefined') {
                                 var flight_bg = data[0].destination_images.image_jpeg;
                                 } else { 
                                     var flight_bg = "./uploads/none.jpg";
                                 }
                                     $('.featured_flight_<?=$flights->id?>').append('<img style="object-fit: cover;" class="w-100 h-100" src='+flight_bg+' />').hide().fadeIn(500);
                                 }
                                 });
                                 
                              </script> -->
                              <div class="col-lg-6 responsive-column">
                                 <a href="<?=root?>flights/<?=strtolower($flights->origin_code)?>/<?=strtolower($flights->destination_code)?>/oneway/economy/<?php $d=strtotime("+5 Days"); echo date("d-m-Y", $d);?>/1/0/0">
                                    <div class="deal-card">
                                       <div class="row g-0" style="display: flex; justify-content: center; align-items: center; width: 100%;">
                                          <!-- img -->
                                          <!-- <div class="col-5 h-100" style="background: #ffff; border-radius: 3px;">
                                             <div class="deal-title d-flex align-items-center h-100">
                                                <div class="featured_flight clear featured_flight_<?=$flights->id?> h-100" style="width: 135px;overflow: hidden;position: relative;">
                                                <img style="object-fit: cover;" class="w-100 h-100" src="https://content.r9cdn.net/rimg/dimg/f9/6e/f77fed51-city-28248-17333c86727.jpg?width=128&amp;height=128&amp;xhint=3580&amp;yhint=2412&amp;outputtype=JPEG&amp;crop=true">
                                              </div>
                                             </div>
                                          </div> -->
                                          <!-- detail  -->
                                          <div class="col-10 h-100 bg-white position-relative" style="z-index:99">
                                             <div class="py-4 px-1">
                                                <h6 class="text--overflow"><strong><?=$flights->airline_name?></strong></h6>
                                                <h3 class="deal__title d-flex align-items-center gap-2 mb-0">
                                                   <?=$flights->origin?>
                                                   <div>
                                                      <svg fill="#000000" width="26" height="26" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                         <rect id="Icons" x="-192" y="-192" width="1280" height="800" style="fill:none;"/>
                                                         <g id="Icons1" serif:id="Icons">
                                                            <g id="Strike"> </g>
                                                            <g id="H1"> </g>
                                                            <g id="H2"> </g>
                                                            <g id="H3"> </g>
                                                            <g id="list-ul"> </g>
                                                            <g id="hamburger-1"> </g>
                                                            <g id="hamburger-2"> </g>
                                                            <g id="list-ol"> </g>
                                                            <g id="list-task"> </g>
                                                            <g id="trash"> </g>
                                                            <g id="vertical-menu"> </g>
                                                            <g id="horizontal-menu"> </g>
                                                            <g id="sidebar-2"> </g>
                                                            <g id="Pen"> </g>
                                                            <g id="Pen1" serif:id="Pen"> </g>
                                                            <g id="clock"> </g>
                                                            <g id="external-link"> </g>
                                                            <g id="hr"> </g>
                                                            <g id="info"> </g>
                                                            <g id="warning"> </g>
                                                            <g id="plus-circle"> </g>
                                                            <g id="minus-circle"> </g>
                                                            <g id="vue"> </g>
                                                            <g id="cog"> </g>
                                                            <g id="logo"> </g>
                                                            <path id="arrow-right" d="M48.337,29.881l-7.414,-7.414l2.832,-2.832l12.247,12.247l-0.001,0.001l0.001,0.001l-12.247,12.246l-2.832,-2.832l7.412,-7.412l-40.335,0l0,-4.005l40.337,0Z"/>
                                                            <g id="radio-check"> </g>
                                                            <g id="eye-slash"> </g>
                                                            <g id="eye"> </g>
                                                            <g id="toggle-off"> </g>
                                                            <g id="shredder"> </g>
                                                            <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                            <g id="react"> </g>
                                                            <g id="check-selected"> </g>
                                                            <g id="turn-off"> </g>
                                                            <g id="code-block"> </g>
                                                            <g id="user"> </g>
                                                            <g id="coffee-bean"> </g>
                                                            <g id="coffee-beans">
                                                               <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                            </g>
                                                            <g id="coffee-bean-filled"> </g>
                                                            <g id="coffee-beans-filled">
                                                               <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                            </g>
                                                            <g id="clipboard"> </g>
                                                            <g id="clipboard-paste"> </g>
                                                            <g id="clipboard-copy"> </g>
                                                            <g id="Layer1"> </g>
                                                         </g>
                                                      </svg>
                                                   </div>
                                                   <?=$flights->destination?>
                                                </h3>
                                                <div class="deal-action-box d-flex align-items-center justify-content-between pt-1" style="line-height:15px">
                                                   <div class="price-box flex-grow-1 flex-column align-items-start flex-sm-row align-items-sm-center">
                                                      <span class="price__from mr-1 flex-grow-1 text-center text-sm-start">
                                                         <?=T::from?> 
                                                         <div class="d-block"></div>
                                                      </span>
                                                      <span class="price__num flex-grow-1"> <?=currency?> <?=$flights->price?> </span>
                                                   </div>
                                                   <img src="<?=airline_logo($flights->airline)?>" alt="air-line-img" class="lazyload px-3" style="max-width: 60px;">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </a>
                                 <div class="clear"></div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end tab-pane -->
               </div>
               <!-- end tab-content -->
               <div class="tab-content-info d-flex justify-content-between align-items-center">
               </div>
               <!-- end tab-content-info -->
            </div>
         </div>
         <!-- end col-lg-12 -->
      </div>
      <!-- end row -->
   </section>
</div>
</div>
<!-- end container -->
<?php } ?>