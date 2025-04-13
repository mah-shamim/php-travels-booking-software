<!-- ================================
  START BREADCRUMB AREA
  ================================= -->
<section class="breadcrumb-area py-0" style="background-image: url(<?=$tour->img[0]?>);background-attachment: fixed;">
  <div class="breadcrumb-wrap">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb-btn">
            <div class="btn-box">
              <a class="theme-btn" data-src="<?=$tour->img[0]?>"
                data-fancybox="gallery"
                data-caption=""
                data-speed="700">
              <i class="la la-photo mr-2"></i> <?=T::more_photos?>
              </a>
            </div>
            <?php  if (!empty($tour->img)) {
              shuffle($tour->img);
              foreach ($tour->img as $index => $imgs) {
              if (empty($imgs)) {} else {
              ?>
            <a class="d-none"
              data-fancybox="gallery"
              data-src="<?=($imgs)?>"
              data-caption=""
              data-speed="700">
            </a>
            <?php } } }?>
          </div>
          <!-- end breadcrumb-btn -->
        </div>
        <!-- end col-lg-12 -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end breadcrumb-wrap -->
</section>
<!-- end breadcrumb-area -->
<!-- ================================
  END BREADCRUMB AREA
  ================================= -->
<!-- ================================
  START TOUR DETAIL AREA
  ================================= -->
<section class="tour-detail-area padding-bottom-90px">
  <div class="single-content-navbar-wrap menu section-bg" id="single-content-navbar">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="single-content-nav" id="single-content-nav">
            <ul>
              <div class="single-content-navbar-wrap menu section-bg" id="single-content-navbar">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="single-content-nav" id="single-content-nav">
                        <ul>
                          <li><a data-scroll="description" href="#description" class="scroll-link active"><?=T::tours_tour_details?></a></li>
                          <li><a data-scroll="inclusions" href="#inclusions" class="scroll-link"><?=T::tours_inclusions?></a></li>
                          <?php if (!empty($tour->policy)) { ?>
                          <li><a data-scroll="policy" href="#policy" class="scroll-link"><?=T::policy?></a></li>
                          <?php } ?>
                          <!--<li><a data-scroll="reviews" href="#reviews" class="scroll-link"><?=T::reviews?></a></li>-->
                          <?php if (!empty($tour->longitude)) { ?>
                          <li><a data-scroll="reviews" href="#map" class="scroll-link"><?=T::map?></a></li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end single-content-navbar-wrap -->
  <div class="single-content-box">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="single-content-wrap padding-top-30px tour">
            <div id="description" class="page-scroll">
              <div class="single-content-item pb-4">
                <h3 class="title font-size-26"><?=$tour->name?></h3>
                <div class="d-flex flex-wrap align-items-center pt-2">
                  <?php if (empty($tour->location)) {} else { ?>
                  <p class="mr-2"><?=$tour->location?>, <?=$tour->name?></p>
                  <?php } ?>
                </div>
                <h3 class="font-size-22">
                  <?php for ($i = 1; $i <= $tour->rating; $i++) { ?>
                  <div class="stars la la-star"></div>
                  <?php } ?>
                </h3>
              </div>
              <!-- end single-content-item -->
              <div class="section-block"></div>
              <div class="single-content-item py-4">
                <div class="row">
                  <?php if (!empty($tour->duration)){?>
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-clock-o"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::duration?></h3>
                        <span class="font-size-13"><?=$tour->duration?></span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                  <?php } ?>
                  <?php if (!empty($tour->max_travellers)){?>
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-users"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::max_travellers?></h3>
                        <span class="font-size-13"> <?=strip_tags($tour->max_travellers)?></span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                  <?php } ?>
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-globe"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::tours_tour_type?></h3>
                        <span class="font-size-13"><?php if ($tour->tour_type == ""){ echo T::general; } else { echo $tour->tour_type; }?> </span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-calendar"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::date?></h3>
                        <span class="font-size-13"><?php echo date("D d m Y", strtotime($date)); ?></span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-address-card"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::rating?></h3>
                        <span class="font-size-13"><?=$tour->rating?> / 5</span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                  <div class="col-lg-4 responsive-column">
                    <div class="single-tour-feature d-flex align-items-center mb-3">
                      <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                        <i class="la la-user"></i>
                      </div>
                      <div class="single-feature-titles">
                        <h3 class="title font-size-15 font-weight-medium"><?=T::extra_people?></h3>
                        <span class="font-size-13"><?=$currency." ".$tour->b2c_price?></span>
                      </div>
                    </div>
                    <!-- end single-tour-feature -->
                  </div>
                  <!-- end col-lg-4 -->
                </div>
                <!-- end row -->
              </div>
              <!-- end single-content-item -->
              <div class="section-block"></div>
              <div class="single-content-item padding-top-40px padding-bottom-40px">
                <h3 class="title font-size-20"><?=T::description?></h3>
                <div class="content">
                  <?php if (empty($tour->desc)) {} else { ?>
                  <p class="py-3"><?=$tour->desc?></p>
                  <?php } ?>
                </div>
                <div id="inclusions" class="page-scroll"></div>
                <a href="javascript:void(0)" class="show_hide btn btn-outline-primary mb-3" data-content="toggle-text"><?=T::read_more?></a>
                <script>
                  $(document).ready(function () {
                   $(".show_hide").on("click", function () {
                       var txt = $(".content").hasClass('visible') ? '<?=T::read_more?>' : '<?=T::read_less?>';
                       $(".show_hide").text(txt);
                       $(".content").toggleClass("visible");
                   });
                  });
                </script>
                <style>
                  .content {
                  height:190px;
                  overflow:hidden;
                  margin-bottom:10px;
                  }
                  .content.visible {
                  height:auto;
                  overflow:visible;
                  }
                </style>
                <!--<h3 class="title font-size-15 font-weight-medium pb-3">Highlights</h3>
                  <div class="row">
                      <div class="col-lg-6 responsive-column">
                          <ul class="list-items pb-3">
                              <li><i class="la la-dot-circle text-color mr-2"></i>Dolorem mediocritatem</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Mea appareat</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Prima causae</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Singulis indoctum</li>
                          </ul>
                      </div>
                      <div class="col-lg-6 responsive-column">
                          <ul class="list-items pb-3">
                              <li><i class="la la-dot-circle text-color mr-2"></i>Timeam inimicus</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Oportere democritum</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Cetero inermis</li>
                              <li><i class="la la-dot-circle text-color mr-2"></i>Pertinacia eum</li>
                          </ul>
                      </div>
                  </div>-->
                <div class="row mt-4">
                  <?php if (!empty($tour->inclusions)) { ?>
                  <div class="col-lg-6 responsive-column">
                    <h3 class="title font-size-15 font-weight-medium pb-3"><?=T::tours_tour?> <?=T::tours_inclusions?></h3>
                    <ul class="list-items">
                      <?php foreach ($tour->inclusions as $i ) { ?>
                      <li><i class="la la-check text-success mr-2"></i> <?=$i?></li>
                      <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
                  <?php if (!empty($tour->exclusions)) { ?>
                  <div class="col-lg-6 responsive-column">
                    <h3 class="title font-size-15 font-weight-medium pb-3"><?=T::tours_tour?> <?=T::tours_exclusions?></h3>
                    <ul class="list-items">
                      <?php foreach ($tour->exclusions as $e ) { ?>
                      <li><i class="la la-times text-danger mr-2"></i> <?=$e?></li>
                      <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
                </div>
                <!-- end row -->
              </div>
              <!-- end single-content-item -->
              <div class="section-block"></div>
            </div>
            <!-- end description -->
            <!--<div id="itinerary" class="page-scroll">
              <div class="single-content-item padding-top-40px padding-bottom-40px">
                  <h3 class="title font-size-20"><?=T::itinerary?></h3>

                  <div class="accordion mt-4" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Accordion Item #1
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Accordion Item #2
                        </button>
                      </h2>
                      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Accordion Item #3
                        </button>
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                  </div>

              </div>
              <div class="section-block"></div>
              </div>-->
            <?php if (!empty($tour->policy)) { ?>
            <div class="accordion" id="policy" class="page-scroll">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  <?=T::policy?>
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                  <div class="accordion-body">
                    <?php if (!empty($tour->policy)){?>
                    <p><strong><?=T::policy?></strong> <?=strip_tags($tour->policy)?></p>
                    <?php } ?>
                    <?php if (!empty($tour->departure_time)){?>
                    <p><strong><?=T::departure_time?></strong> <?=strip_tags($tour->departure_time)?></p>
                    <?php } ?>
                    <?php if (!empty($tour->departure_point)){?>
                    <p><strong><?=T::departure_point?></strong> <?=strip_tags($tour->departure_point)?></p>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if (!empty($tour->longitude)) { ?>
            <div id="map" class="page-scroll">
              <div class="single-content-item padding-top-40px padding-bottom-20px">
                <h3 class="title font-size-20"><?=T::hotels_hotelmap?></h3>
                <div class="amenities-feature-item pt-4">
                  <div class="row">
                    <iframe src="https://maps.google.com/maps?q=<?=$tour->longitude?>,<?=$tour->latitude?>&z=15&output=embed" width="100%" height="270" frameborder="0" style="border:0"></iframe>
                  </div>
                  <!-- end row -->
                </div>
              </div>
              <!-- end single-content-item -->
              <div class="section-block"></div>
            </div>
            <!-- end faq -->
            <?php } ?>
          </div>
          <!-- end single-content-wrap -->
        </div>
        <!-- end col-lg-8 -->
        <div class="col-lg-4">
          <div class="sticky-top">
            <div class="sidebar single-content-sidebar mb-0">
              <div class="sidebar-widget single-content-widget">
                <div class="sidebar-widget-item">
                  <div class="sidebar-book-title-wrap mb-3 d-flex justify-content-center">
                    <h3><?=T::price?></h3>
                    <p>
                      <span class="text-value ml-2 mr-1 me-3" style="margin: 25px;"> <?=$currency?>
                      <span class="total">
                      <?php
                        // create clean vars
                        $a_price = $tour->b2c_adult_price;
                        $c_price = $tour->b2c_child_price;
                        $i_price = $tour->b2c_infant_price;

                        // calculate prices
                        $ad = $a_price * $adults;
                        $ch = $c_price * $childs;

                        // get total price
                        $total = $ad + $ch;
                        echo $total;

                        ?>
                      </span></span>
                      <!--<span class="before-price">&nbsp; <?=$currency; $price = $tour->b2c_price + 30; echo $price ?> &nbsp;</span>-->
                    </p>
                  </div>
                </div>
                <!-- end sidebar-widget-item -->
                <form action="<?=root?>tours/booking" method="post" autocomplete="off">
                  <div class="sidebar-widget-item">
                    <div class="contact-form-action">
                      <div class="input-box">
                        <label class="label-text"><?=T::date?></label>
                        <div class="form-group">
                          <span class="la la-calendar form-icon"></span>
                          <input class="dp_tour form-control date_change" type="text" name="date" value="<?=$date?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end sidebar-widget-item -->
                  <div class="sidebar-widget-item mt-3">
                    <div class="qty-box mb-2 d-flex align-items-center justify-content-between adult">
                      <label class="font-size-16"><?=T::adults?> <span><?=T::age?> 18+</span></label>
                      <label class="font-size-16"><?=T::price?> <span><?=$currency?> <?=$tour->b2c_adult_price?></span></label>
                      <div class="d-flex align-items-center">
                        <select name="adults" id="adults" class="adults form-select">
                          <option value="1" select>1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                        </select>
                      </div>
                    </div>
                    <!-- end qty-box -->
                    <div class="qty-box mb-2 d-flex align-items-center justify-content-between child">
                      <label class="font-size-16"><?=T::child?> <span><?=T::age?> 12-</span></label>
                      <label class="font-size-16"><?=T::price?> <span><?=$currency?> <?=$tour->b2c_child_price?></span></label>
                      <div class="d-flex align-items-center">
                        <select name="childs" id="childs" class="childs form-select">
                          <option value="">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                        </select>
                      </div>
                    </div>
                    <!-- end qty-box -->
                    <div class="qty-box mb-2 d-flex align-items-center justify-content-between infant">
                      <label class="font-size-16"><?=T::infant?> <span><?=T::age?> 4-</span></label>
                      <label class="font-size-16"><?=T::price?> <span><?=$currency?> <?=$tour->b2c_infant_price?></span></label>
                      <div class="d-flex align-items-center">
                        <select name="infants" id="infants" class="infants form-select">
                          <option value="">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                        </select>
                      </div>
                    </div>
                    <!-- end qty-box -->
                  </div>
                  <!-- end sidebar-widget-item -->
                  <div class="btn-box pt-2">
                    <button type="submit" class="effect ladda effect" data-style="zoom-in">
                    <span class="ladda-label"><i class="la la-basket"></i><i class="la la-shopping-cart mr-2 font-size-18"></i> <?=T::booknow?></span>
                    </button>
                  </div>
                  <script>
                    // create clean cars
                    var adult_price = <?=$tour->b2c_adult_price?>;
                    var child_price = <?=$tour->b2c_child_price?>;
                    var infant_price = <?=$tour->b2c_infant_price?>;

                    // jquery check on change selectbox
                    $('#adults,#childs,#infants').on('change', function() {
                    var adults = $( "#adults option:selected" ).text();
                    var childs = $( "#childs option:selected" ).text();
                    var infants = $( "#infants option:selected" ).text();
                    console.log('adults '+ adults);
                    console.log('childs '+ childs);
                    console.log('infants '+ infants);

                    // create clean cars and calculate
                    a_price = adult_price * adults;
                    c_price = child_price * childs;
                    i_price = infant_price * infants;

                    // get all travelers with their pricing
                    var cost = a_price + c_price + i_price;
                    $(".total").html(cost);

                    // add price to hidden input
                    document.getElementById("price").value = cost;
                    });

                  </script>
                  <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($tour)) ?>">
                  <input type="hidden" name="price" value="" id="price" />
                </form>
              </div>
              <!-- end sidebar-widget -->
              <!--<div class="sidebar-widget single-content-widget">
                <h3 class="title stroke-shape">Enquiry Form</h3>
                <div class="enquiry-forum">
                    <div class="form-box">
                        <div class="form-content">
                            <div class="contact-form-action">
                                <form method="post">
                                    <div class="input-box">
                                        <label class="label-text">Your Name</label>
                                        <div class="form-group">
                                            <span class="la la-user form-icon"></span>
                                            <input class="form-control" type="text" name="text" placeholder="Your name">
                                        </div>
                                    </div>
                                    <div class="input-box">
                                        <label class="label-text">Your Email</label>
                                        <div class="form-group">
                                            <span class="la la-envelope-o form-icon"></span>
                                            <input class="form-control" type="email" name="email" placeholder="Email address">
                                        </div>
                                    </div>
                                    <div class="input-box">
                                        <label class="label-text">Message</label>
                                        <div class="form-group">
                                            <span class="la la-pencil form-icon"></span>
                                            <textarea class="message-control form-control" name="message" placeholder="Write message"></textarea>
                                        </div>
                                    </div>
                                     <div class="input-box">
                                         <div class="form-group">
                                             <div class="custom-checkbox mb-0">
                                                 <input type="checkbox" id="agreeChb">
                                                 <label for="agreeChb">I agree with <a href="#">Terms of Service</a> and
                                                     <a href="#">Privacy Statement</a>
                                                 </label>
                                             </div>
                                         </div>
                                    </div>
                                    <div class="btn-box">
                                        <button type="button" class="theme-btn">Submit Enquiry</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>-->
            </div>
            <!-- end sidebar -->
          </div>
          <!-- end col-lg-4 -->
        </div>
        <!-- end col-lg-4 -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end single-content-box -->
</section>
<!-- end tour-detail-area -->
<!-- ================================
  END TOUR DETAIL AREA
  ================================= -->
<div class="section-block"></div>
<?php if (empty($_SESSION['tours_data'])) { } else { ?>
<!-- ================================
  related AREA
  ================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading text-center">
          <h2 class="sec__title line-height-55 bottom-line"><?=T::youmightalsolike?></h2>
        </div>
      </div>
    </div>
    <div class="row padding-top-50px">
      <div class="col-lg-12">
        <div class="hotel-card-wrap">
          <div class="hotel-card-carousel carousel-action">
            <?php
              shuffle($_SESSION['tours_data']);
              foreach ($_SESSION['tours_data'] as $index => $related) { if ($index < 15) {
              $link =  root.$session_lang.'/'.strtolower($currency).'/tour/'.strtolower(str_replace(' ', '-', $city)).'/'.strtolower(str_replace(" ", "-", $related->name)).'/'.$related->tour_id.'/'.$date.'/'.$adults.'/'.$childs.'/'.$related->supplier; ?>
            <div class="card-item mb-0">
              <div class="card-img">
                <a href="<?=$link?>" class="d-block">
                <img data-src="<?=$related->img?>" class="lazyload" alt="hotel-img" style="height:200px">
                </a>
                <?php if(!empty($tours->discount)){ ?>
                <span class="badge"> <?= $tours->discount ?> % <?=T::discount?> </span>
                <?php } ?>
              </div>
              <div class="card-body">
                <h3 class="card-title"><a href="<?=$link?>"><?=str_replace('-', ' ', $related->name);?></a></h3>
                <p class="card-meta"><?=$related->location?></p>
                <div class="card-rating" style="height:60px">
                  <?php if (empty($related->rating)) {} else { ?>
                  <span class="badge text-white"><?=$related->rating?></span>
                  <span class="review__text">
                    <?php for ($i = 1; $i <= $related->rating; $i++) { ?>
                    <div class="stars la la-star"></div>
                    <?php } ?>
                  </span>
                  <?php } ?>
                </div>
                <div class="card-price d-flex align-items-center justify-content-between">
                  <p>
                    <span class="price__num"><?=$currency?> <?=$related->b2c_price?></span>
                    <span class="price__text"><?=T::price?> </span>
                  </p>
                  <a href="<?=$link?>" class="btn-text"><?=T::details?> <i class="la la-angle-right"></i></a>
                </div>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<script src="<?=root.theme_url?>assets/js/navbar-sticky.js"></script>
<script>
$('.adults option[value=<?php if(isset($adults)){ echo $adults; } else { echo "0"; } ?>]').attr('selected','selected');
$('.childs option[value=<?php if(isset($childs)){ echo $childs; } else { echo "0"; } ?>]').attr('selected','selected');
</script>