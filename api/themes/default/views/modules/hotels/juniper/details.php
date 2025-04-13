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
            <h2 id="detail-content-sticky-nav-00" class="name float-none"><?=$hotel[0]->company_name?></h2>
            <div class="star-rating-wrapper">
              <div class="rating-item rating-inline">
                <div class="rating-icons">
                  <?php for($star = 1; $star <= 5; $star++): ?>
                  <?php if($hotel[0]->rating < $star): ?>
                  <i class="rating-symbol-background rating-icon far fa-star"></i>
                  <?php else: ?>
                  <i class="rating-icon fas fa-star rating-rated"></i>
                  <?php endif; ?>
                  <?php endfor; ?>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <p class="location"><i class="material-icons text-info small">place</i> <?=$hotel[0]->address?> <a href="#detail-content-sticky-nav-03" class="anchor"><?php echo trans('0143');?></a></p>
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
            <?php if(isset($hotel[0]->images) && !empty($hotel[0]->images)):
            ?>
            <div class="slick-gallery-slideshow detail-gallery">
              <div class="slider gallery-slideshow">
                <?php foreach($hotel[0]->images as $image){
                    if(!empty($image->FileName)){
                    ?>
                <div>
                  <div class="image">
                   <img style="width:100%;max-height: 600px; !important" src="<?=$image->FileName?>" alt="Images">
                   </div>
                </div>
                <?php } }?>
              </div>
              <div class="slider gallery-nav slider-thumbnail">
                <?php foreach($hotel[0]->images as $image){
                if(!empty($image->FileName)){
                 ?>
                <div>
                  <div class="image">
                  <img style="max-height:65px; !important" src="<?=$image->FileName?>" alt="Images">
                  </div>
                </div>
                <?php } } ?>
              </div>
              <?php else: ?>
              <img style="width:100%;max-height: 600px; !important" src="<?=$hotel->slider_image?>">
              <?php endif; ?>
            </div>
             <p>
               <?=$hotel[0]->description?>
              </p>
            <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('0248');?></span></h3>
              <div class="clear"></div>
              <?php if(!empty($hotel[0]->amenities)): ?>
              <ul class="main-facility-list clearfix">
                <?php foreach($hotel[0]->amenities as $amenity): ?>
                <li>
                  <span class="icon-font"><i class="ion-checkmark text-primary"></i></span> <?=$amenity->_?>
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
                <?php if(! empty($hotel[0]->room) ): ?>
                <?php foreach($hotel[0]->room as $index => $room):?>
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
                            <h5 class="float-none"><a href="#"><?=$room->boardTypename?></a></h5>
                            <p class="mb-0 mt-20"><span class="font700"><?=$room->roomTypename?></span>  </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-md-6 align-self-center">
                      <div class="row gap-20 justify-content-between">
                        <div class="col-7 col-sm-8 col-md-8 d-none d-md-block">
                        </div>
                        <div class="col-5 col-sm-4 col-md-4 ml-auto">
                          <p class="price text-center"> <span class="number text-secondary"><small></small><?=$room->currencies?> <?=$room->price?></span><br><?php echo trans('0245');?></p>
                          <form action='<?=base_url("hotelsj/checkout/".str_replace(' ','-',$hotel[0]->company_name))?>' method="post">
                              <input type="hidden" name="hotel_id" value='<?=$hotel[0]->id?>'>
                              <input type="hidden" name="room" value='<?=base64_encode(json_encode($room))?>'>
                              <input type="hidden" name="hotel" value='<?=base64_encode(json_encode($hotel[0]))?>'>
                              <input type="hidden" name="searchForm" value='<?=base64_encode(json_encode($searchForm))?>'>
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
                            <div class="font500 font12"><?=$hotel[0]->company_name?></div>
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

  
