<style>
.progress {
  position: relative;
  height: 10px;
  display: block;
  width: 100%;
  background-color: #bfc1ce;
  border-radius: 2px;
  background-clip: padding-box;
  margin: 0.5rem 0 1rem 0;
  overflow: hidden; }
  .progress .determinate {
    position: absolute;
    background-color: inherit;
    top: 0;
    bottom: 0;
    background-color:#3f51b5;
    transition: width .3s linear; }
  .progress .indeterminate {
    background-color: #3f51b5; }
    .progress .indeterminate:before {
      content: '';
      position: absolute;
      background-color: inherit;
      top: 0;
      left: 0;
      bottom: 0;
      will-change: left, right;
      -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
              animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite; }
    .progress .indeterminate:after {
      content: '';
      position: absolute;
      background-color: inherit;
      top: 0;
      left: 0;
      bottom: 0;
      will-change: left, right;
      -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
              animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
      -webkit-animation-delay: 1.15s;
              animation-delay: 1.15s; }

@-webkit-keyframes indeterminate {
  0% {
    left: -35%;
    right: 100%; }
  60% {
    left: 100%;
    right: -90%; }
  100% {
    left: 100%;
    right: -90%; } }
@keyframes indeterminate {
  0% {
    left: -35%;
    right: 100%; }
  60% {
    left: 100%;
    right: -90%; }
  100% {
    left: 100%;
    right: -90%; } }
@-webkit-keyframes indeterminate-short {
  0% {
    left: -200%;
    right: 100%; }
  60% {
    left: 107%;
    right: -8%; }
  100% {
    left: 107%;
    right: -8%; } }
@keyframes indeterminate-short {
  0% {
    left: -200%;
    right: 100%; }
  60% {
    left: 107%;
    right: -8%; }
  100% {
    left: 107%;
    right: -8%; } }

</style>
<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
    <div id="change-search" class="collapse">
    <div class="change-search-wrapper">
    <?php echo searchForm($appModule, $searchFormEan); ?>
    </div>
    </div>
      <div class="row gap-20 gap-md-30 gap-xl-40">
      <div class="col-12 col-lg-3">
      <?php require $themeurl.'views/includes/filter.php';?>
      </div>
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="d-lg-flex mb-30 mb-lg-10">
              <div>
                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                <h3 class="heading-title"><span><?=lang('Hotels')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                <?php } ?>
                <!-- <p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p> -->
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
              </div>
            </div>
            <!-- hotele content starts from here -->
            <div class="product-long-item-wrapper">
            <?php if(!empty($module)){ ?>
              <?php foreach($module as $item){ ?>
                
              <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink o2 ">
                    <div class="image">
                    <a href="<?php echo $item->slug;?>">
                    
                         <img src="<?php echo $item->thumbnail;?>" alt="images" />
                        </a>
                    </div>
                  </div>
                  <div class="col-12 col-auto o1">
                    <div class="col-inner d-flex flex-column">
                      <div class="content-top">
                        <div class="d-flex">
                          <div class="o2 rtl-ml-auto">
                            <div class="rating-item rating-sm rating-inline">
                              <div class="rating-icons go-right">
                                 <?php echo $item->stars;?>
                              </div>
                              <div class="clear"></div>
                            </div>
                            <h5><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,20);?></a></h5>
                            <div class="clear"></div>
                            <p class="location go-text-right "><i class="fas fa-map-marker-alt text-primary go-right"></i> <?php echo character_limiter($item->location,10);?></p>
                            <div class="clear"></div>
                          </div>
                          <div class="ml-auto">
                            <?php  if($item->price > 0){ ?>
                            <div class="price">
                              <?=lang('0218')?> <?=lang('0273')?>
                              <span class="text-secondary">
                              <?php echo $currSign; ?> <?php echo currencyConverter($item->price);?>
                              </span>
                              <?=lang('0245')?>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="content">
                        <p><?php echo character_limiter($item->desc,150);?></p>
                      </div>
                      <div class="content-bottom mt-auto">
                        <div class="d-flex align-items-center">
                          <div>
                            <ul class="list-icon-absolute list-inline-block">
                              <?php
                                $cnt = 0;
                                if(!empty($amenities = json_decode($item->h_amenities))){
                                foreach($amenities as $amenity){
                                $name = ($amenity->trans_name)?$amenity->trans_name:$amenity->sett_name;
                                $cnt++;
                                if($cnt <= 10){
                                ?>
                              <img title="<?=$name?>" data-toggle="tooltip" data-placement="top" style="height:20px;" src="<?=base_url('uploads/images/hotels/amenities/'.$amenity->sett_img)?>" alt="<?=$name?>" />
                              <?php } } } ?>
                            </ul>
                          </div>
                          <div class="ml-auto">
                            <!--<a href="<?php echo base_url('hotels/detail/'.$city.'/'.$item->hotel_slug);?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>-->
                            <a href="<?php echo $item->slug;?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="pull-right">
                <?php echo $pagination; ?>
              </div>
              <?php }else{  echo '<h2 class="text-center">' . trans("066") . '</h2>'; } ?>
            </div>
          </div>
          <?php if($appModule == "ean"){ if($multipleLocations > 0){ foreach($locationInfo as $loc){ ?>
        <p><?php echo $loc->link; ?></p>
        <?php } } ?>
        

        <!--This is for display cache Parameter-->
        <div id="latest_record_para">
          <input type="hidden" name="moreResultsAvailable" id="moreResultsAvailable" value="<?php echo $moreResultsAvailable; ?>" />
          <input type="hidden" name="cacheKey" id="cacheKey" value="<?php echo $cacheKey; ?>" />
          <input type="hidden" name="cacheLocation" id="cacheLocation" value="<?php echo $cacheLocation; ?>" />
          <input type="hidden" name="" id="agesappendurl" value="<?php echo $agesApendUrl; ?>" />
          <input type="hidden" name="" id="adultsCount" value="<?php echo $adults;?>" />
        </div>
        <!--This is for display content-->
        <div id="New_data_load"></div>
        <!--This is for display Loader Image-->
        <div id="loader_new"></div>
        <div id="message_noResult"></div>
        <!-- END OF LIST CONTENT-->
        <div class="progress">
       <div class="indeterminate"></div>
        </div>
        <?php } ?>
        </div>

      </div>
    </div>
  </section>
</div>
<!-- end Main Wrapper -->
<?php if($ismobile): ?>
<div class="modal <?php if($isRTL == "RTL"){ ?> right <?php } else { ?> left <?php } ?> fade" id="sidebar_filter" tabindex="1" role="dialog" aria-labelledby="sidebar_filter">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close go-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="close icon-angle-<?php if($isRTL == "RTL"){ ?>right<?php } else { ?>left<?php } ?>"></i></span></button>
        <h4 class="modal-title go-text-right" id="sidebar_filter"><i class="icon_set_1_icon-65 go-right"></i> <?php echo trans('0191');?></h4>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<div id="map" class="map"></div>
<div class="clearfix"></div>
<?php if(!$ismobile): ?>
<div class="col-md-3 hidden-sm hidden-xs filter">
  <script>
    $("form[name=fFilters]").on("submit", function(e) {
        e.preventDefault();
        var uri = '<?=$uri?>';
        var stars = $(".iradio_square-grey.checked").find("input[name=stars]").val() || 0;
        var price = $("input[name=price]").val();
        var propertyTypes = $('.icheckbox_square-grey.checked input[name^="type"]').map(function() {
            return this.value;
        }).get();
        var amenities = $('.icheckbox_square-grey.checked input[name^="amenities"]').map(function() {
            return this.value;
        }).get();
        // Validation
        price = price.replace(',','-') || 0;
        propertyTypes = propertyTypes.join("-") || 0;
        amenities = amenities.join("-") || 0;
        var redirect_url = uri+"/"+stars+"/"+price+"/"+propertyTypes+"/"+amenities;
        window.location.href = redirect_url;
    });
  </script>
</div>
<?php endif; ?>
<!-- END OF CONTENT -->
<!-- End container -->
<!-- Map -->
<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div  class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo trans('0254');?></h4>
      </div>
      <div class="mapContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block btn-lg pfb0" data-dismiss="modal"><?php echo trans('0234');?></button>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<script>
  // Sorting according to prices.
  $("[name^=priceOrder]").click(function() {
      var order = $(this).val();
      var tb = $('#hotelResultTable');

      var rows = tb.find('tr');
      rows.sort(function(a, b) {
          var keyA = $(a).data('price');
          var keyB = $(b).data('price');

          if (order == 'acs') {
              return keyA - keyB;
          } else {
              return keyB - keyA;
          }
      });

      $.each(rows, function(index, row) {
          tb.append(row);
      });
  });
  $('#collapseMap').on('shown.bs.collapse', function(e){
  (function(A) {

  if (!Array.prototype.forEach)
  A.forEach = A.forEach || function(action, that) {
   for (var i = 0, l = this.length; i < l; i++)
     if (i in this)
       action.call(that, this[i], i, this);
   };

  })(Array.prototype);
  var
  mapObject,
  markers = [],
  markersData = {
   'map-red': [
    <?php foreach($module as $item): ?>
   {
     name: 'hotel name',
     location_latitude: "<?php echo $item->hotel_latitude;?>",
     location_longitude: "<?php echo $item->hotel_longitude;?>",
     map_image_url: "<?php echo base_url('uploads/images/hotels/slider/thumbs/'.$item->thumbnail_image);?>",
     name_point: "<?php echo $item->hotel_title;?>",
     description_point: "<?php echo character_limiter(strip_tags(trim($hotel_desc)),75);?>",
     url_point: "<?php echo base_url('hotels/detail/'.$city.'/'.$item->hotel_slug);?>"
   },
    <?php endforeach; ?>
   ],
  };
   var mapOptions = {
      <?php if(empty($_GET)){ ?>
     zoom: 10,
      <?php }else{ ?>
       zoom: 12,
      <?php } ?>
     center: new google.maps.LatLng(<?php echo $item->hotel_latitude;?>, <?php echo $item->hotel_longitude;?>),
     mapTypeId: google.maps.MapTypeId.ROADMAP,

     mapTypeControl: false,
     mapTypeControlOptions: {
       style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
       position: google.maps.ControlPosition.LEFT_CENTER
     },
     panControl: false,
     panControlOptions: {
       position: google.maps.ControlPosition.TOP_RIGHT
     },
     zoomControl: true,
     zoomControlOptions: {
       style: google.maps.ZoomControlStyle.LARGE,
       position: google.maps.ControlPosition.TOP_RIGHT
     },
     scrollwheel: false,
     scaleControl: false,
     scaleControlOptions: {
       position: google.maps.ControlPosition.TOP_LEFT
     },
     streetViewControl: true,
     streetViewControlOptions: {
       position: google.maps.ControlPosition.LEFT_TOP
     },
     styles: [/*map styles*/]
   };
   var
   marker;
   mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
   for (var key in markersData)
     markersData[key].forEach(function (item) {
       marker = new google.maps.Marker({
         position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
         map: mapObject,
         icon: '<?php echo base_url(); ?>assets/img/' + key + '.png',
       });

       if ('undefined' === typeof markers[key])
         markers[key] = [];
       markers[key].push(marker);
       google.maps.event.addListener(marker, 'click', (function () {
     closeInfoBox();
     getInfoBox(item).open(mapObject, this);
     mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
    }));
  });
  function hideAllMarkers () {
   for (var key in markers)
     markers[key].forEach(function (marker) {
       marker.setMap(null);
     });
  };
  function closeInfoBox() {
   $('div.infoBox').remove();
  };
  function getInfoBox(item) {
   return new InfoBox({
     content:
     '<div class="marker_info" id="marker_info">' +
     '<img style="width:280px;height:140px" src="' + item.map_image_url + '" alt=""/>' +
     '<h3>'+ item.name_point +'</h3>' +
     '<span>'+ item.description_point +'</span>' +
     '<a href="'+ item.url_point + '" class="btn btn-primary"><?php echo trans('0177');?></a>' +
     '</div>',
     disableAutoPan: true,
     maxWidth: 0,
     pixelOffset: new google.maps.Size(40, -190),
     closeBoxMargin: '0px -20px 2px 2px',
     closeBoxURL: "<?php echo $theme_url; ?>assets/img/close.png",
     isHidden: false,
     pane: 'floatPane',
     enableEventPropagation: true
   }); };  });
</script>































