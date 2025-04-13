<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
<section class="page-wrapper bg-light-primary">
  <div class="container">
    <div class="row gap-20 gap-md-30 gap-xl-40">
      <div class="col-12 col-lg-3">
        <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
          <div class="box-expand-lg">
            <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
              <div class="wrapper-inner">
                <?php if(!$ismobile): ?>
                <?php require $themeurl.'views/includes/filter.php';?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </aside>
      </div>
      <div class="col-12 col-lg-9">
        <div class="content-wrapper">
          <!-- hotele content starts from here -->
          <div class="product-long-item-wrapper">
            <?php if($appModule != "ean" && $appModule != "hotels" && $appModule != "tours" && $appModule != "cars"){ ?>
            <?php if($appModule == "offers"); {?>
            <?php foreach($module as $item){ ?>
            <div class="product-long-item">
              <div class="row equal-height shrink-auto-md gap-15">
                <div class="col-12 col-shrink">
                  <div class="image">
                    <img src="<?php echo $item->thumbnail;?>" alt="images" />
                  </div>
                </div>
                <div class="col-12 col-auto">
                  <div class="col-inner d-flex flex-column">
                    <div class="content-top">
                      <div class="d-flex">
                        <div>
                          <h5><a href="#"><?php echo character_limiter($item->title,20);?></a></h5>
                        </div>
                        <div class="ml-auto">
                          <?php  if($item->price > 0){ ?>
                          <div class="price">
                            <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="content">
                      <?php echo character_limiter($item->desc,120);?>
                    </div>
                    <div class="content-bottom mt-auto">
                      <div class="d-flex align-items-center">
                        <div class="ml-auto">
                          <a href="<?php echo $item->slug;?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans( '0286');?></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
</section>
</div>
<!-- end Main Wrapper -->
<script>
  <?php if($appModule == "cars"){ ?>
  $(function(){
    $(".saveDates").on("click",function(){
      var pickup = $("#departcar").val();
      var drop = $("#returncar").val();
      var htmlvar = pickup+' - '+drop;
      $(".datesModal").html(htmlvar);
    });
  })
  
  <?php } ?>
  
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
       location_latitude: "<?php echo $item->latitude;?>",
       location_longitude: "<?php echo $item->longitude;?>",
       map_image_url: "<?php echo $item->thumbnail;?>",
       name_point: "<?php echo $item->title;?>",
       description_point: "<?php echo character_limiter(strip_tags(trim($item->desc)),75);?>",
       url_point: "<?php echo $item->slug;?>"
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
       center: new google.maps.LatLng(<?php echo $item->latitude;?>, <?php echo $item->longitude;?>),
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