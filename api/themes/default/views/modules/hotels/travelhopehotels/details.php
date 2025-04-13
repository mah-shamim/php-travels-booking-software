<style>
  ul.main-facility-list li{
  margin-right:0 !important;
  width:49%;
  }
  .form-control{
    overflow:hidden;
  }
  @media screen and (max-width:500px){
    .slick-track{
      height:300px;
    }
    .slider-thumbnail{
      height:60px;
    }
    .followWrap{
      display:none;
    }
  }
  .form-search-main-01 label{position:static}
  .bootstrap-touchspin .input-group-btn-vertical > .btn{top:7px !important}
  .form-spin-group .form-icon-left .icon-font i{top:-11px}
  
</style>
<div class="main-wrapper scrollspy-action thhotel-detail">
  <div class="page-wrapper page-detail bg-light">
    <div class="detail-header">
      <div class="container">
        <div class="d-flex flex-column flex-lg-row">
          <div class="o2 rtl-ml-auto">
            <h2 id="detail-content-sticky-nav-00" class="name float-none"><?=$hotel->company_name?></h2>
            <div class="star-rating-wrapper">
              <div class="rating-item rating-inline">
                <div class="rating-icons">
                  <?php for($star = 1; $star <= 5; $star++): ?>
                  <?php if($hotel->rating < $star): ?>
                  <i class="rating-symbol-background rating-icon far fa-star"></i>
                  <?php else: ?>
                  <i class="rating-icon fas fa-star rating-rated"></i>
                  <?php endif; ?>
                  <?php endfor; ?>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <p class="location"><i class="material-icons text-info small">place</i> <?=$hotel->address?> <a href="#detail-content-sticky-nav-03" class="anchor"><?php echo trans('0143');?></a></p>
          </div>
          <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
            <!-- <div class="price"><span><?= $hotel->currencies ?> <?= $hotel->price ?></span></span></div> -->
            <a href="#detail-content-sticky-nav-02" class="anchor btn btn-primary btn-wide mt-5"><?php echo trans('0138');?></a>
          </div>
        </div>
      </div>
    </div>
    <span  id="detail-content-sticky-nav-00" class="d-block"></span>
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
                <a href="#detail-content-sticky-nav-02"><?php echo trans('0252');?> <?php echo trans('016');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-03"><?php echo trans('032');?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row gap-30">
        <div class="col-12 col-lg-8 col-xl-9">
          <div class="content-wrapper">
            <?php if(isset($hotel->images) && !empty($hotel->images)): ?>
            <div class="slick-gallery-slideshow detail-gallery">
              <div class="slider gallery-slideshow">
                <?php foreach($hotel->images as $image): ?>
                <div>
                  <div class="image">
                   <img style="width:100%;max-height: 600px; !important" src="<?=$image?>" alt="Images">
                   </div>
                </div>
                <?php endforeach; ?>
              </div>
              <div class="slider gallery-nav slider-thumbnail">
                <?php foreach($hotel->images as $image): ?>
                <div>
                  <div class="image">
                  <img style="max-height:65px; !important" src="<?=$image?>" alt="Images">
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
              <img style="width:100%;max-height: 600px; !important" src="<?=$hotel->slider_image?>">
              <?php endif; ?>
            </div>
             <p>
               <?=$hotel->description?>
              </p>
            <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('0248');?></span></h3>
              <div class="clear"></div>
              <?php if(!empty($hotel->amenities)): ?>
              <ul class="main-facility-list clearfix">
                <?php foreach($hotel->amenities as $amenity): ?>
                <li>
                  <span class="icon-font"><i class="ion-checkmark text-primary"></i></span> <?=$amenity->title?>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>
            <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('0252');?> <?php echo trans('016');?></span></h3>
              <div class="clear"></div>
              <div class="room-item-wrapper">
                <div class="room-item heading d-none d-md-block">
                  <div class="row gap-20">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <div class="row gap-20">
                        <div class="col-xss-6 col-xs-3 col-sm-4 col-md-4">
                        </div>
                        <div class="col-xss-12 col-xs-9 col-sm-8 col-md-8">
                          <span><?php echo trans('0246');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-0">
                      <div class="row gap-20">
                        <div class="col-xs-12 col-sm-8 col-md-8">
                          <!-- <span><?php echo trans('0435');?> <?php echo trans('0559');?></span> -->
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                          <span><?php echo trans('0435');?> <?php echo trans('070');?> </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(! empty($hotel->rooms) ): ?>
                <?php foreach($hotel->rooms as $index => $room): ?>
                <div class="room-item">
                  <div class="row gap-20">
                    <div class="col-6 col-md-6">
                      <div class="row gap-20">
                        <div class="col-6 col-sm-4 col-md-4">
                          <div class="image">
                            <?php $image = (!empty($room->image[0])) ? $room->image[0] : $theme_url.'assets/img/data/hotel.jpg'?>
                            <img src="<?=$image?>" alt="image" />
                          </div>
                        </div>
                        <div class="col-12  col-sm-8 col-md-8">
                          <div class="content">
                            <h5 class="float-none"><a href="#"><?=str_replace(',', '<br>', $room->room_descriptions)?></a></h5>
                            <p class="mb-0 mt-20"><span class="font700">Total price including taxes and fees</span>  </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-md-6 align-self-center">
                      <div class="row gap-20 justify-content-between">
                        <div class="col-7 col-sm-8 col-md-8 d-none d-md-block">
                          <!-- <p class="line13 mt-5 mb-15"><span class="block text-success font600 text-uppercase">Special Condition</span></p>
                            <ul class="list-icon-data-attr font-awesome list-block-md">
                            	<li data-content="&#xf00c">Breakfast Included</li>
                            	<li data-content="&#xf00c">Free Internet in Room</li>
                            	<li data-content="&#xf00c">Free Parking</li>
                            	<li data-content="&#xf00c">No Booking Fee</li>
                            </ul> -->
                        </div>
                        <div class="col-5 col-sm-4 col-md-4 ml-auto">
                          <p class="price text-center"> <span class="number text-secondary"><small></small><?=$room->price?></span><br><?php echo trans('0245');?></p>
                          <form action='<?=base_url("thhotels/checkout/".str_replace(' ', '-', $hotel->company_name)."")?>' method="post">
                            <input type="hidden" name="room" value='<?=base64_encode(json_encode($room))?>'>
                            <input type="hidden" name="hotel" value='<?=base64_encode(json_encode($hotel))?>'>
                            <input type="hidden" name="search_form" value='<?=base64_encode($searchForm->getInJson())?>'>
                            <button class="btn btn-primary btn-sm btn-block" type="submit"><?=lang('0142')?></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
            <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('032');?></span></h3>
              <div class="clear"></div>
              <div class="hotel-detail-location-wrapper">
                <div class="row gap-30">
                  <div class="col-12 col-md-12">
                    <div class="map-holder">
                      <div id="hotel-detail-map" data-lat="<?php echo $hotel->latitude; ?>" data-lon="<?php echo $hotel->longitude; ?>" style="width: 100%; height: 480px;"></div>
                      <div class="infobox-wrapper">
                        <div id="infobox">
                          <div class="infobox-inner">
                            <div class="font500 font12"><?=$hotel->company_name?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        <div  class="col-12 col-lg-4 col-xl-3">
          <aside class="sticky-kit sidebar-wrapper">
            <div class="booking-selection-box mt-20">
              <div class="heading clearfix">
                <div class="d-flex align-items-end fe">
                  <div>
                    <h4 class="text-white font-serif font400"><?php echo trans('0372');?></h4>
                  <div class="clear"></div>
                  </div>
                </div>
              </div>
              <div class="content">

              <style>
              .form-inner .o1,
              .form-inner .o2,
              .form-inner .o3,
              .form-inner .o4{
                order:unset !important;
              }
              .form-inner .o4{width:100% !important;max-width: 100%;}
              .form-inner .o3{width:100% !important;max-width: 100%;flex:none}
              .form-inner .col-inner .o2{width:100% !important;max-width: 100%;flex:none}
              .form-inner .col-inner .o1{width:100% !important;max-width: 100%;flex:none}
              .form-inner .col-md-2  { -ms-flex: none; flex: none; max-width: 100%; }
              .form-inner .col-md-3 { -ms-flex: none; flex: none; max-width: 100%; }
              .form-inner .col-md-4 { -ms-flex: none; flex: none; max-width: 100%; }
              

              </style>
              <?php echo Search_Form($appModule,'hotels'); ?>

                <!--<form action='<?=base_url("thhotels/recheck/{$hotel->company_name}")?>' method="post">
                  <div class="row" id="airDatepickerRange-hotel">
                    <div class="col-md-12">
                      <label><?php echo trans('07');?></label>
                      <div class="form-icon-left">
                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                        <input type="text" placeholder="<?php echo trans('07'); ?>"  value="<?=$searchForm->getCheckin()?>" name="checkin" class="form form-control input-lg" id="checkin" required >
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label><?php echo trans('09');?></label>
                      <div class="form-icon-left">
                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                        <input type="text" placeholder="<?php echo trans('09'); ?>" name="checkout" value="<?=$searchForm->getCheckout()?>" class="form-control checkout">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="go-right"><?php echo trans('010');?></label>
                      <select class="form-control fs12" name="adults">
                        <option value="1" <?=($searchForm->adults == 1)?"selected":""?>>1</option>
                        <option value="2" <?=($searchForm->adults == 2)?"selected":""?>>2</option>
                        <option value="3" <?=($searchForm->adults == 3)?"selected":""?>>3</option>
                        <option value="4" <?=($searchForm->adults == 4)?"selected":""?>>4</option>
                        <option value="5" <?=($searchForm->adults == 5)?"selected":""?>>5</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label class="go-right">Children</label>
                      <select class="form-control fs12" name="children">
                        <option value="1" <?=($searchForm->children == 0)?"selected":""?>>0</option>
                        <option value="1" <?=($searchForm->children == 1)?"selected":""?>>1</option>
                        <option value="2" <?=($searchForm->children == 2)?"selected":""?>>2</option>
                        <option value="3" <?=($searchForm->children == 3)?"selected":""?>>3</option>
                        <option value="4" <?=($searchForm->children == 4)?"selected":""?>>4</option>
                        <option value="5" <?=($searchForm->children == 5)?"selected":""?>>5</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <input type="hidden" name="hotel_id" value='<?=$hotel->id?>'>
                      <input type="hidden" name="custom_payload" value='<?=$custom_payload?>'>
                      <input type="hidden" name="search_form" value='<?=$search_form?>'>
                      <button type="submit" class="btn btn-danger btn-block" style="margin-top: 25px;"><i class="icon_set_1_icon-66"></i>
                      <span id="btn-submit-text"><?php echo trans('012'); ?></span>
                      </button>
                    </div>
                  </div>
                </form>-->
              </div>
            </div>
          </aside>
        </div>
      </div>
      <div class="fullwidth-horizon-sticky border-0">&#032;</div>
      <!-- is used to stop the above stick menu -->
    </div>
  </div>
</div>		


<!-- <link rel="stylesheet" href="<?php echo $theme_url; ?>assets/css/travelport.css" />
<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<link href="<?php echo $theme_url; ?>assets/include/slider/slider.min.css" rel="stylesheet" />
<script src="<?php echo $theme_url; ?>assets/include/slider/slider.js"></script>
<style>
.rooms-search__container.details-page-view form input{font-size:1.125rem;font-weight:500;height:40px;}
</style>
<div class="container">
    <div class="acc-details__description">
        <div class="description">
            <div class="description__header">
                <div class="description__title text-700 c-very-dark-grey">
                    <span class="h2 strong"><?=$hotel->company_name?></span>
                    <span class="go-right mob-fs10">
                    <?php for($star = 0; $star < $hotel->rating; $star++): ?>
                        <i class="star star icon-star-5"></i>
                    <?php endfor; ?>
                    </span>
                </div>
            </div>
            <div class="description__address c-text-grey text-xs-regular">
                <span class="description__address-text text-s-regular-sm">
                    <?=$hotel->address?>
                </span>
            </div>
        </div>
    </div>

    <div>
        <div class="col-md-8">
            <div style="width:100%" class="row fotorama bg-dark" data-width="1000" data-height="490" data-allowfullscreen="true" data-autoplay="true" data-nav="thumbs">
                <?php if(isset($hotel->images) && !empty($hotel->images)): ?>
                    <?php foreach($hotel->images as $image): ?>
                        <img style="width:100%;height:450px !important" src="<?=$image?>">
                    <?php endforeach; ?>
                <?php else: ?>
                    <img style="width:100%;height:450px !important" src="<?=$hotel->slider_image?>">
                <?php endif; ?>
            </div>
        </div>
    </div>

<div class="col-md-4">
<iframe width="100%" height="558" style="position: static; background: #eee;" 
  src="https://maps.google.com/maps?q=<?php echo $hotel->latitude; ?>,<?php echo $hotel->longitude; ?>&hl=es;z=14&amp;output=embed"
 >
 </iframe>

 
</div>
<div class="clearfix"></div>
    <section>
        <div class="overview">
            <div class="overview__body">
                <h4  class="overview__header h4">Overview</h4>
                <p class="text-s-regular c-text-grey overview__content--less">
                    <?=$hotel->description?>
                </p>
            </div>
        </div>
    </section>
    <section class="acc-details__rooms-section" id="rooms">
        <div class="acc-details__search-header">
            <div class="text-l c-dark-blue acc-details__search-header__title">Rooms available</div>
        </div>
        <div class="availability-search">
            <div class="rooms-search">
                <div class="rooms-search__container details-page-view">
                    <form action='<?=base_url("thhotels/recheck/{$hotel->company_name}")?>' method="post">
                        <div style="width:100%">
                            <div class="form-group col-md-3">
                                <label class="go-right"><?php echo trans('07');?></label>
                                <input type="text" placeholder="<?php echo trans('07'); ?>" name="checkin" value="<?=$searchForm->getCheckin()?>" class="form-control hpcheckin">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="go-right"><?php echo trans('09');?></label>
                                <input type="text" placeholder="<?php echo trans('09'); ?>" name="checkout" value="<?=$searchForm->getCheckout()?>" class="form-control hpcheckout">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="go-right"><?php echo trans('010');?></label>
                                <select class="form-control fs12" name="adults">
                                    <option value="1" <?=($searchForm->adults == 1)?"selected":""?>>1</option>
                                    <option value="2" <?=($searchForm->adults == 2)?"selected":""?>>2</option>
                                    <option value="3" <?=($searchForm->adults == 3)?"selected":""?>>3</option>
                                    <option value="4" <?=($searchForm->adults == 4)?"selected":""?>>4</option>
                                    <option value="5" <?=($searchForm->adults == 5)?"selected":""?>>5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="go-right">Children</label>
                                <select class="form-control fs12" name="children">
                                    <option value="1" <?=($searchForm->children == 0)?"selected":""?>>0</option>
                                    <option value="1" <?=($searchForm->children == 1)?"selected":""?>>1</option>
                                    <option value="2" <?=($searchForm->children == 2)?"selected":""?>>2</option>
                                    <option value="3" <?=($searchForm->children == 3)?"selected":""?>>3</option>
                                    <option value="4" <?=($searchForm->children == 4)?"selected":""?>>4</option>
                                    <option value="5" <?=($searchForm->children == 5)?"selected":""?>>5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="hidden" name="hotel_id" value='<?=$hotel->id?>'>
                                <input type="hidden" name="custom_payload" value='<?=$custom_payload?>'>
                                <input type="hidden" name="search_form" value='<?=$search_form?>'>
                                <button type="submit" class="btn btn-danger" style="margin-top: 25px;"><i class="icon_set_1_icon-66"></i>
                                    <span id="btn-submit-text"><?php echo trans('012'); ?></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="acc-details__search-results hotelRateDetail">
            <div class="room-cards">
                <?php if(! empty($hotel->rooms) ): ?>
                    <?php foreach($hotel->rooms as $index => $room): ?>
                        <div class="room-card">
                            <div class="room-card__container">
                                <div class="room-card__body">
                                    <div class="room-card__content">
                                        <div class="room-card__image-box">
                                            <?php $image = (!empty($room->image[0])) ? $room->image[0] : $theme_url.'assets/img/hotel.jpg'?>
                                            <img class="room-card__image" src="<?=$image?>">
                                        </div>
                                        <div class="room-card__content--left">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td><?=str_replace(',', '<br>', $room->room_descriptions)?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="room-card__content--right">
                                            <div class="room-price__container">
                                                <span class="text-l c-dark-blue"><?=$room->price?></span>
                                            </div>
                                            <span class="text-xs-regular c-text-grey">Total price including taxes and fees</span>
                                            <form action='<?=base_url("thhotels/checkout/{$hotel->company_name}")?>' method="post">
                                                <input type="hidden" name="room" value='<?=base64_encode(json_encode($room))?>'>
                                                <input type="hidden" name="hotel" value='<?=base64_encode(json_encode($hotel))?>'>
                                                <input type="hidden" name="search_form" value='<?=base64_encode($searchForm->getInJson())?>'>
                                                <button class="core-btn-primary room-card__book-now-btn" type="submit">Book now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if(!empty($hotel->amenities)): ?>
        <section class="acc-details__facilities_section" id="facilities">
            <div>
                <h2 class="text-l c-dark-blue">Hotel facilities</h2>
                <div class="hotel-facilities">
                    <div class="hotel-facilities__container row">
                        <?php foreach($hotel->amenities as $amenity): ?>
                            <div class="col-md-3">
                                <div class="hotel-facility">
                                    <i class="fa fa-check text-success"></i>
                                    <span class="text-s-regular c-text-grey"><?=$amenity->title?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div> -->

<script>
    $(function(){
        $("[name=hotelRateDetail]").on('submit', function(e) {
            e.preventDefault();
            var payload = $(this).serialize();
            $('#btn-submit-text').text('SEARCHING...');
            $.get('<?=base_url("hotelport/rateAndRule")?>', payload, function(resp) {
                $('#btn-submit-text').empty().text('SEARCHING');
                $('.hotelRateDetail').empty().html(resp.body);
            });
        });
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('[name=checkin]').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        })
        .on('changeDate', function(e){
            $(this).datepicker('hide');
            var newDate = new Date(e.date);
            checkout.setValue(newDate.setDate(newDate.getDate() + 1));
            $('[name=checkout]').focus();
        }).data('datepicker');

        // Checkout time
        var checkout = $('[name=checkout]').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        }).data('datepicker');

        // Default fill up date
        if(checkin.element.val()) {
            checkin.setValue(checkin.element.val());
        }
        if(checkout.element.val()) {
            checkout.setValue(checkout.element.val());
        }
    });
    setTimeout(() => {
      var $document = $(document);
      $( window ).scroll(function() {
        if ($document.scrollTop() >= 50) {
        $('.fullwidth-horizon-sticky').css("top",'85px');
        }
    
});
    }, 500);
    
    
</script>

  
