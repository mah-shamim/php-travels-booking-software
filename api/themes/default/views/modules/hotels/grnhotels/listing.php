<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
      <div id="change-search" class="collapse">
        <div class="change-search-wrapper">
          <?php echo Search_Form($appModule,'hotels'); ?>
        </div>
      </div>
      <div class="row gap-20 gap-md-30 gap-xl-40">
        <div class="col-12 col-lg-3">
          <aside class="sidebar-wrapper  mb-10 mb-md-0">
            <div class="box-expand-lg">
              <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
                <div class="wrapper-inner">
                  <div class="sidebar-title bg-primary">
                    <div class="d-flex align-items-end">
                      <div>
                        <h4 class="text-white font-serif font400"><?=lang('0191')?></h4>
                      </div>
                    </div>
                  </div>
                  <form name="fFilters" action="<?php echo base_url($uri.'/filter'); ?>" method="GET" role="search">
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?=lang('0598')?></h5>
                        <div class="clear"></div>
                      </div>
                      <div class="box-content">
                        <div class="mb-5">
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="priceOrderDes" name="priceOrder" value="des">
                            <label class="custom-control-label" for="priceOrderDes"><?=lang('0599')?></label>
                            <div class="clear"></div>
                          </div>
                        </div>
                        <div class="mb-5">
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="priceOrderAsc" name="priceOrder" value="acs">
                            <label class="custom-control-label" for="priceOrderAsc"><?=lang('0600')?></label>
                            <div class="clear"></div>
                          </div>
                        </div>
                      </div>

                  </form>
                </div>
              </div>
            </div>
            <div class="d-block d-lg-none">
              <button type="buttom" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile"><?=lang('0191')?></button>
            </div>
          </aside>
        </div>
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="d-lg-flex mb-30 mb-lg-10">
              <div>
                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                <h3 class="heading-title"><span><?=lang('Hotels')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                <div class="clear"></div>
                <?php } ?>
                <p class="text-muted post-heading"><?= count($hotels->hotels) ?> <?=lang('0535')?></p>
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
              </div>
            </div>
            <!-- hotele content starts from here -->
            <div class="product-long-item-wrapper">
              <?php if(isset($hotels->hotels) && ! empty($hotels->hotels)): ?>
              <?php  foreach($hotels->hotels as $hotel_index=>$hotel): ?>
              <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink o2">
                    <div class="image">
                      <a href="<?=base_url()?>">

                      <img src="<?=$hotel->images->url?>" alt="<?=$hotel->name?>">
                      </a>
                    </div>
                  </div>
                  <div class="col-12 col-auto o1">
                    <div class="col-inner d-flex flex-column">
                      <div class="content-top">
                        <div class="d-flex">
                          <div class="o2">
                            <div class="rating-item rating-sm rating-inline">
                              <div class="rating-icons">
                                <h5><a href="<?=base_url()?>"><?= $hotel->name ?></a></h5>
                                <div class="clear"></div>
                                <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary go-right"></i><?=$hotel->address?>
                                </p>
                              </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="ml-auto rtl-mr-auto o1">
                            <div class="price">
                              <span class="text-secondary">
                                <!--<?php echo $currCode;?>--> <?= "INR " ?><?= $hotel->min_rate->price ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="content">
                        <p> <?=strlen($hotel->description) > 250 ? substr($hotel->description,0,250)."..." : $hotel->description;?></p>
                      </div>
                      <div class="content-bottom mt-auto border-0">
                        <div class="d-flex align-items-center">
                          <div class="ml-auto rtl-mr-auto o1">
                          <a class="btn btn-primary btn-sm btn-wide" data-toggle="collapse" href="#collapseExample<?=$hotel_index?>" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo trans('0177');?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="collapse mt-30 border-top" id="collapseExample<?=$hotel_index?>">

                    <?php foreach ($hotel->min_rate->rooms as $index=>$room) { ?>
                         <div class="card-body">
                             <form action="<?=base_url('grnhotels/book')?>" method="post">
                         <h6 class="mb-20">Room #<?=$index+1?>></h6>
                         <div class="row align-items-center">
                         <div class="col-md-4">
                         <div class="d-flex justify-content-between">
                         <strong class="max-adult">Max Adult</strong>
                         <span><?=$room->no_of_adults?></span>
                             <input type="hidden" name="book[search_id]" value="<?=$hotels->search_id?>">
                             <input type="hidden" name="book[room_code]" value="<?=$hotel->min_rate->room_code?>">
                             <input type="hidden" name="book[rate_key]" value="<?=$hotel->min_rate->rate_key?>">
                             <input type="hidden" name="book[group_code]" value="<?=$hotel->min_rate->group_code?>">
                             <input type="hidden" name="book[hotel_code]" value="<?=$hotel->hotel_code?>">
                             <input type="hidden" name="book[room_reference]" value="<?=$room->room_reference?>">
                             <input type="hidden" name="book[city_code]" value="<?=$hotel->city_code?>">
                             <input type="hidden" name="payload" value="<?=$payload?>">
                             <input type="hidden" name="hotel[room_name]" value="<?=$room->description?>">
                             <input type="hidden" name="hotel[hotel_name]" value="<?= $hotel->name ?>">
                             <input type="hidden" name="hotel[image]" value="<?= $hotel->images->url ?>">
                             <input type="hidden" name="hotel[price]" value="<?= $hotel->min_rate->price ?>">
                             <input type="hidden" name="hotel[currency]" value="<?= "INR" ?>">
                             <input type="hidden" name="book[payment_type] " value="<?=!empty($hotel->min_rate->payment_type[0]) ? $hotel->min_rate->payment_type[0] : ""?>">
                         </div>
                         <div class="d-flex justify-content-between mt-20">
                         <strong class="max-child">Max Child</strong>
                         <span><?=$room->no_of_children?></span>
                         </div>
                         </div>
                         <div class="col-md-8">
                         <div class="d-flex justify-content-between">
                         <strong class="max-adult">Room Type</strong>
                         <span><?=$room->description?></span>
                         </div>
                         <div class="d-flex justify-content-between mt-20">
                         <strong class="max-adult">Description</strong>
                         <span><?=$room->room_type?></span>
                         </div>
                         </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                        <div class="col-md-12">
                         <button type="submit" class="btn btn-primary btn-sm btn-wide mt-20 float-right">Book Now</button>
                             </form>
                         <div class="clear"></div>
                         </div>
                        </div>
                        </div>
                       </div>
              </div>
              <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="close icon-angle-<?php if($isRTL == "RTL"){ ?>right<?php } else { ?>left<?php } ?>"></i></span></button>
        <h4 class="modal-title go-text-right" id="sidebar_filter"><i class="icon_set_1_icon-65"></i> <?php echo trans('0191');?></h4>
        <div class="clear"></div>
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
    var starRating = document.getElementsByClassName('custom-stars');
    var starInput = document.querySelectorAll('.custom-control-input');
    var customRating = starRating[0].querySelectorAll('.custom-ratting');
    var input = document.querySelectorAll("input[name^ ='price']");
    console.log(input)
    console.log(customRating[0])
    for(var i = 0; i < starInput.length; i++){
      console.log(customRating[i])
      starInput[i].addEventListener('change',function(){
        if(this.checked == true){
        
          customRating[i].classList.add('checked');
         console.log(true)
         
        }else{
          customRating[i].classList.remove('checked')
        console.log(false)
        }
      })
    }
     $("form[name=fFilters]").on("submit", function(e) {
            e.preventDefault();
            var uri = '<?=$uri?>';
            var stars = $(".custom-ratting.checked").find("input[name=stars]").val() || 0;
            var price = $("input[name=price]").val();
            var propertyTypes = $('.icheckbox_square-grey.checked input[name^="type"]').map(function() {
                return this.value;
            }).get();
            var amenities = $('.icheckbox_square-grey.checked input[name^="amenities"]').map(function() {
                return this.value;
            }).get();
            // Validation
            price = price.replace(';','-') || 0;
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
<script>
  // Sorting according to prices.
  $("[name^=priceOrder]").click(function() {
      var order = $(this).val();
      var tb = $('#listing');
  
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
  
  function create_slug(data) {
      var facilities = [];
      var accommodation = [];
      $('.icheckbox_square-grey.checked input[name^="facilities"]').each(function() {
          facilities.push($(this).val());
      });
      $('.icheckbox_square-grey.checked input[name^="accommodation"]').each(function() {
          accommodation.push($(this).val());
      });
      var p_1 = data['stars'] || 0;
      var p_2 = data['price'] || 0;
      var p_3 = facilities.join('-') || 34;
      var p_4 = accommodation.join('-') || 0;
      return "/"+p_1+"/"+p_2+"/"+p_3+"/"+p_4;
  }
  $("form[name=fFilters]").on("submit", function(e) {
      e.preventDefault();
      var values = {};
      $.each($(this).serializeArray(), function(i, field) {
          values[field.name] = field.value;
      });
      window.location.href = $(this).attr('action')+create_slug(values);
  });
  var count = 1;
  function bindScroll(){
     if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
         $("#listing").after( "<div class='loading' style='margin: 30px auto;'></div>" );
         $(window).unbind('scroll');
         loadHotels(count);
         count++;
     }
  }
  $(window).scroll(bindScroll);
  function loadHotels(pageNumber) {
      $.get("<?=base_url('hotelb/pagination/')?>"+pageNumber+"/<?=$base64_detailpage_uri?>", function(response) {
        if(response.status == 'success') {
            $(".loading").remove();
            $('#listing').find('tbody').append( response.listHtml );
            $(window).bind('scroll', bindScroll);
        } else {
          scrolling = false;
        }
      });
  }
</script>