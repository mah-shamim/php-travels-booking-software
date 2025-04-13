<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
    <div id="change-search" class="collapse">
    <div class="change-search-wrapper">
    <?php echo searchForm($appModule,$searchFormhotels); ?>
    </div>
    </div>
      <div class="row gap-20 gap-md-30 gap-xl-40">
        <div class="col-12 col-lg-3">
          <aside class="sidebar-wrapper filter-wrapper sticky-kit mb-10 mb-md-0">
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
                  <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?php echo trans('0137');?> <?php echo trans('069');?></h5>
                        <div class="clear"></div>
                      </div>
                      <div class="box-content">
                        <div class="rating-item rating-sm rating-inline">
                          <div class="rating-icons go-right custom-stars">
                            <?php $star = '<span class="rating-icon fas fa-star rating-rated"></span>'; ?>
                            <?php $stars = '<div class="rating-symbol-background rating-icon far fa-star"></div>'; ?>
                            <div class="custom-control custom-radio">
                              <div class="mb-5 custom-ratting">

                                <input id="1" type="radio" name="stars" class="custom-control-input" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                                <label class="custom-control-label " for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?>
                                </label>
                              <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting">
                                <input id="2" type="radio" name="stars" class="custom-control-input" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                                <label class="custom-control-label" for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                              <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting">
                                <input id="3" type="radio" name="stars" class="custom-control-input" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                                <label class="custom-control-label" for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                              <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting">
                                <input id="4" type="radio" name="stars" class="custom-control-input" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                                <label class="custom-control-label" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                              <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting" >
                                <input id="5" type="radio" name="stars" class="custom-control-input" value="5" <?php if($starsCount == "5"){echo "checked";}?>>
                                <label class="custom-control-label" for="5">&nbsp; <?php for($i=1;$i<=5;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=0;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                              <div class="clear"></div>
                              </div>
                            </div>
                          </div>
                          <div class="clear"></div>
                        </div>
                      </div>
                    </div>
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?php echo trans('0301');?></h5>
                        <div class="clear"></div>
                      </div>
                      <div class="box-content">
                        <input id="price_range" name = 'price' />
                          <!--<?php if(!empty($priceRange)){
                          $selectedprice = str_replace('-',',', $priceRange);
                          }else{
                          $selectedprice =  $minprice.",".$maxprice;
                          }?>
                        <input type="text" class="col-md-12" value="" data-slider-min="<?=$minprice?>" data-slider-max="<?=$maxprice?> " data-slider-step="10" data-slider-value="[<?=$selectedprice?>]" id="sl2" name="price">-->
                      </div>
                    </div>
                    <?php if(!empty($amenities)){ ?>
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?php echo trans('048');?></h5>
                        <div class="clear"></div>
                      </div>
                      <div class="box-content">
                        <?php $varAmt = explode('-', $famenities);
                          if(empty($varAmt)){
                              $varAmt = array();
                          }
                          foreach($amenities as $index => $hamt){
                              if (in_array($hamt->name, $conceptFilters)) { continue; }
                              ?>
                        <?php if ($index==4)  {   ?>
                        <div id="filerPropertyTypeShowHide" class="collapse">
                          <div class="collapse-inner">
                            <?php  }  ?>
                            <div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="<?php echo $hamt->id;?>" <?php if(in_array($hamt->id,$varAmt)){echo "checked";}?> name="amenities[]" id="<?php echo $hamt->name;?>" class="custom-control-input" />
                                <label for="<?php echo $hamt->name;?>" class="custom-control-label"> <img height="25" width="25" class="go-right amenities" src="<?php echo $hamt->icon;?>">  <span style="transform: translateY(-6px); display: inline-block;"><?php echo $hamt->name;?></span></label>
                              <div class="clear"></div>
                              </div>
                            </div>
                            <?php } ?>
                            <?php if (count($amenities)>4 )   { ?>
                          </div>
                        </div>
                        <?php } ?>
                        <div class="clear mb-5"></div>
                        <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('0185')?> (+)</span>
                        <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('067')?> (-)</span>
                      </div>
                    </div>
                    <?php } ?>
                    <!-- End of Hotel Amenities -->
                    <!-- Module types -->
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?php if($appModule == "hotels"){ echo trans('0478'); }else if($appModule == "tours"){ echo trans('0366'); }else if($appModule == "cars"){ echo trans('0214'); } ?></h5>
                      <div class="clear"></div>
                      </div>
                      <div class="box-content">
                        <?php $vartype = explode('-', $fpropertyTypes);
                          if(empty($vartype)){
                              $vartype = array();
                          }
                          foreach($moduleTypes as $mtype){
                              if(!empty($mtype->name)){ ?>
                        <div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="<?php echo $mtype->id;?>" <?php if(in_array($mtype->id,$vartype)){echo "checked";}?> name="type[]" id="<?php echo $mtype->name;?>" class="custom-control-input" />
                            <label for="<?php echo $mtype->name;?>" class="custom-control-label">&nbsp;&nbsp;<?php echo $mtype->name;?></label>
                          <div class="clear"></div>
                          </div>
                        </div>
                        <?php }} ?>
                        <br>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <!-- End of Module Types -->
                    <!-- End of Concept Filters -->
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5>Filer Select</h5>
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
                    </div>
                    <input type="hidden" name="txtSearch" value="<?php echo @$_GET['txtSearch']; ?>">
                    <input type="hidden" name="searching" value="<?php echo @$_GET['searching']; ?>">
                    <input type="hidden" name="modType" value="<?php echo @$_GET['modType']; ?>">
                    <div class="sidebar-box">
                      <div class="box-content">
                      <button  type="submit" class="btn btn-primary br25 btn-lg btn-block loader" id="searchform"><?php echo trans('012');?></button>
                        <!-- <button type="submit" class="btn btn-primary btn-block" id="searchform"><?php echo trans('012');?></button> -->
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
                <p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p>
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
              </div>
            </div>
            <!-- hotele content starts from here -->
            <div class="product-long-item-wrapper">
              <?php if(!empty($module)){ ?>
              <?php
                foreach($module as $item){
                $hotel_title = ($item->trans_title)?$item->trans_title:$item->hotel_title;
                $hotel_desc = ($item->trans_desc)?$item->trans_desc:$item->hotel_desc;
                $city = (isset($item->location_trans) && $item->location_trans != 'NULL')?$item->location_trans:$city;
                ?>
              <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink o2">
                    <div class="image">
                        <a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>">
                         <img src="<?php echo base_url('uploads/images/hotels/slider/thumbs/'.$item->thumbnail_image);?>" alt="images" />
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
                                <!--<?php echo wishListInfo($appModule, $item->hotel_id); ?>-->
                                <?php if($appModule != "offers"){ ?>
                                <a class="ellipsisFIX go-text-right mob-fs14" href="javascript:void(0);" onclick="showMap('<?php echo base_url();?>home/maps/<?php echo $item->hotel_latitude; ?>/<?php echo $item->hotel_longitude; ?>/<?php echo $appModule; ?>/<?php echo $item->hotel_id;?>','modal');" title="<?php echo $city;?>">
                                <i style="margin-left: -3px;" class="mob-fs14 icon-location-6 go-right"></i>
                                </a>
                                <?php for($i=0;$i<5;$i++):  if($i < $item->hotel_stars):  ?>
                                <span class="rating-icon fas fa-star rating-rated"></span>
                                <?php else: ?>
                                <div class="rating-symbol-background rating-icon far fa-star"></div>
                                <?php endif; endfor; } ?>
                              </div>
                              <?php  if($item->avg_review > 0){ ?>
                              <p class="rating-text text-muted"><span class="bg-primary"><?=number_format($item->avg_review, 2, '.', '')?></span> <strong class="text-dark"><?=lang('0208')?></strong> <span class="font13">- <?=floor(($item->reviews_count/2))?> <?=lang('042')?></span></p>
                              <?php } ?>
                            </div>
                            <h5><a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>"><?php echo character_limiter($hotel_title,20);?></a></h5>
                            <div class="clear"></div>
                            <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary go-right"></i> <?php echo $city;?></p>
                          <div class="clear"></div>
                          </div>
                          <div class="ml-auto rtl-mr-auto o1">
                            <?php  if($item->price > 0){ ?>
                            <div class="price">
                              <?=lang('0218')?> <?=lang('0273')?>
                              <span class="text-secondary">
                                <!--<?php echo $currCode;?>--> <?php echo $currSign; ?><?php echo currencyConverter($item->price);?>
                              </span>
                              <?=lang('0245')?>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="content">
                        <p><?php echo character_limiter($hotel_desc,150);?></p>
                      </div>
                      <div class="content-bottom mt-auto">
                        <div class="d-flex align-items-center">
                          <div class="o2">
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
                          <div class="ml-auto rtl-mr-auto o1">
                            <!--<a href="<?php echo base_url('hotels/detail/'.$city.'/'.$item->hotel_slug);?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>-->
                            <a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            <br><br>
            <nav class="mt-10 mt-md-0">
            <ul class="pagination justify-content-center justify-content-lg-left">
            <?php echo createPagination($info);?>
            </ul>
            </nav>
              <?php }else{  echo '<h2 class="text-center">' . trans("066") . '</h2>'; } ?>
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
