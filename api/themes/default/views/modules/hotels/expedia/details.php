<style>
@media (min-width: 992px){
.header-waypoint-sticky.header-main {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 99999;
}
}
  .amint-text {
  display: inline-block;
  transform: translateY(-10px);
  }
  .form-icon-left {
  display: flex;
  }
  .form-icon-left >label {
  flex: 2;
  }
  .form-icon-left > select {
  flex: 2;
  }
  .collapse .card-body{
    margin-bottom:10px;

  }

  .table-condensed>tbody>tr>td{
    padding:5px;
  }
  .section-title h3{
    font-family:inherit !important;
  }
  .header-main .header-nav{
    box-shadow:none !important;
  }
  .w-40{
    width:40% !important;
  }
  .heading-title+p {
    font-size:inherit;
    font-weight:normal;
  }

ul.main-facility-list li{
margin-right:10px !important;
}
.page-wrapper.page-detail .sidebar-wrapper{
  padding-top:20px !important;
  }

</style>
<div class="main-wrapper scrollspy-action">
  <div class="page-wrapper page-detail bg-light">
    <div class="detail-header">
      <div class="container">
        <div class="d-flex flex-column flex-lg-row">
        <?php if($appModule != "ean" && $appModule != "hotels" && $appModule != "tours" && $appModule != "cars"){ ?>
      <h3 style="margin: 12px 0px; color: white;" class="text-success text-center"><?php echo character_limiter($module->title, 28);?></h3>
      <?php } ?>
          <?php if($appModule != "offers"){ ?>
          <div>
          
            <h2 id="detail-content-sticky-nav-00" class="name"><?php echo character_limiter($module->title, 28);?></h2>
            <div class="star-rating-wrapper">
              <div class="rating-item rating-inline">
                <div class="rating-icons">
                  <?php echo $module->stars;?>
                  <!-- <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="4.5"/> -->
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <p class="location">
              <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
              <i class="material-icons text-info small">place</i>
              <?php } ?>
              <?php echo $module->location; ?>
              <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, <?php echo character_limiter($module->mapAddress, 50);?></small>
              <?php } ?>
              <a href="#detail-content-sticky-nav-03" class="anchor">
              <?php echo trans('0143');?>
              </a>
            </p>
          </div>
          <?php } ?>
          <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0">
            <?php if($hasRooms){ ?>
            <?php if($hasRooms || $appModule == "offers"){ ?>
            <div class="price">
              <?php echo trans('0141');?> <span><?php echo @$currencySign; ?><span><?php echo @$lowestPrice; ?></span></span>
            </div>
            <?php } ?>
            <?php } ?>
            <a href="#detail-content-sticky-nav-02" class="anchor btn btn-primary btn-wide mt-5">
            <?php echo trans('0138');?>
            </a>
          </div>
        </div>
      </div>
    </div>
    <span id="detail-content-sticky-nav-00" class="d-block"></span>
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
                <a href="#detail-content-sticky-nav-02"><?php echo trans('0372');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-03"><?php echo trans('032');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-04"><?php echo trans('033');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-05"><?php echo trans('040');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-06"><?php echo trans('0396');?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row gap-30">
        <div class="col-12 col-lg-12 col-xl-12">
          <div class="content-wrapper">
          <div class="slick-gallery-slideshow detail-gallery">
            <div class="slider gallery-slideshow">
              <?php foreach($module->sliderImages as $img){ ?>
              <div>
                <div class="image"><img src="<?php echo $img['fullImage']; ?>" alt="Images" /></div>
              </div>
              <?php } ?>
            </div>
            <div class="slider gallery-nav">
              <?php foreach($module->sliderImages as $img){ ?>
              <div>
                <div class="image"><img src="<?php echo $img['fullImage']; ?>" alt="Images" /></div>
              </div>
              <?php } ?>
            </div>
          </div>
            <?php include $themeurl.'views/socialshare.php';?>
            
            <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
            
                <?php echo character_limiter($module->desc,1000 );?>
              
              <hr>
              <div id="detail-content-sticky-nav-04" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('048'); ?></span></h3>
              <?php if(!empty($module->amenities)){ ?>
              <ul class="main-facility-list clearfix">
                <?php foreach($module->amenities as $amt){ if(!empty($amt->name)){ ?>
                <?php if($appModule == "ean"){ ?>
                <li>
                  <?php echo $amt->name; ?>
                </li>
                <?php } ?>
                <?php if($appModule == "hotels"){ ?>
                <li>
                  <img data-toggle="tooltip" data-placement="top" title="<?php echo $amt->name; ?>" class="go-right" style="max-height:30px;max-witdh:40px" src="<?php echo $amt->icon;?>"> <span class="amint-text"><?php echo $amt->name; ?></span>
                </li>
                <?php } ?>
                <?php } } ?>
              </ul>
              <?php } ?>
              </div>
            </div>
            <div class="clear"></div>
            <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
              <?php require $themeurl.'views/modules/hotels/expedia/expedia_rooms.php';?>   
            <div class="clear"></div>  
              </div>
            <script>
              $("[name^=rooms]").on('click', function() {
                  if ($('[name="rooms[]"]:checked').length > 0) {
                      $('[type=submit]').prop('disabled', false);
                  } else {
                      $('[type=submit]').prop('disabled', true);
                  }
              });
            </script>
            <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?=lang('0143')?></span></h3>
              <div class="hotel-detail-location-wrapper">
                <div class="row gap-30">
                <div class="col-12 col-md-12">
                <div class="map-holder">
            <?php if($appModule == "ean"){ ?>
              <iframe id="map" src="//maps.google.com/maps?q=<?php echo $module->latitude;?>,<?php echo $module->longitude;?>&z=15&output=embed" width="100%" height="500" frameborder="0" style="border:0"></iframe>
              <script>
                // $('#collapseMap').on('shown.bs.collapse', function(e){
                $(document).ready(function(e){
                  $("#mapframe").prop("src","<?php echo base_url();?>tours/tourmap/<?php echo $module->id; ?>");
                });
              </script>
              <?php }else{ ?>
              <div id="map" class="map hidden-xs"></div>
              <br>
              <script>
                  // $('#collapseMap').on('shown.bs.collapse', function(e){
                  $(document).ready(function(e){
                  (function(A){
                      if(!Array.prototype.forEach)
                        A.forEach=A.forEach||function(action,that){for(var i=0,l=this.length;i<l;i++)
                        if(i in this) action.call(that,this[i],i,this);}
                  })(Array.prototype);
                  var mapObject,markers=[],markersData={'marker':[{name:'<?php echo character_limiter($module->title, 80);?>',location_latitude:<?php echo $module->latitude;?>,location_longitude:<?php echo $module->longitude;?>,map_image_url:'<?php echo $module->thumbnail;?>',name_point:'<?php echo character_limiter($module->title, 80);?>',description_point:'<?php echo character_limiter(strip_tags(trim($module->desc)),100);?>',url_point:'<?php echo base_url($appModule.'/'.$module->slug);?>'},<?php foreach($module->relatedItems as $item):?>{name:'hotel name',location_latitude:"<?php echo $item->latitude;?>",location_longitude:"<?php echo $item->longitude;?>",map_image_url:"<?php echo $item->thumbnail;?>",name_point:"<?php echo $item->title;?>",description_point:'<?php echo character_limiter(strip_tags(trim($item->desc)),100);?>',url_point:"<?php echo $item->slug;?>"},<?php endforeach;?>]};var mapOptions={zoom:14,center:new google.maps.LatLng(<?php echo $module->latitude;?>,<?php echo $module->longitude;?>),mapTypeId:google.maps.MapTypeId.ROADMAP,mapTypeControl:!1,mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU,position:google.maps.ControlPosition.LEFT_CENTER},panControl:!1,panControlOptions:{position:google.maps.ControlPosition.TOP_RIGHT},zoomControl:!0,zoomControlOptions:{style:google.maps.ZoomControlStyle.LARGE,position:google.maps.ControlPosition.TOP_RIGHT},scrollwheel:!1,scaleControl:!1,scaleControlOptions:{position:google.maps.ControlPosition.TOP_LEFT},streetViewControl:!0,streetViewControlOptions:{position:google.maps.ControlPosition.LEFT_TOP},styles:[]};var marker;mapObject=new google.maps.Map(document.getElementById('map'),mapOptions);for(var key in markersData)
                    markersData[key].forEach(function(item){marker=new google.maps.Marker({position:new google.maps.LatLng(item.location_latitude,item.location_longitude),map:mapObject,icon:'<?php echo base_url(); ?>uploads/global/default/'+key+'.png',});if('undefined'===typeof markers[key])
                    markers[key]=[];markers[key].push(marker);google.maps.event.addListener(marker,'click',(function(){closeInfoBox();getInfoBox(item).open(mapObject,this);mapObject.setCenter(new google.maps.LatLng(item.location_latitude,item.location_longitude))}))});function hideAllMarkers(){for(var key in markers)
                    markers[key].forEach(function(marker){marker.setMap(null)})};function closeInfoBox(){$('div.infoBox').remove()};function getInfoBox(item){return new InfoBox({content:'<div class="marker_info" id="marker_info">'+'<img style="width:280px;height:140px" src="'+item.map_image_url+'" alt="<?php echo character_limiter($module->title, 80);?>"/>'+'<h3>'+item.name_point+'</h3>'+'<span>'+item.description_point+'</span>'+'<a href="'+item.url_point+'" class="btn btn-primary"><?php echo trans('0177');?></a>'+'</div>',disableAutoPan:!0,maxWidth:0,pixelOffset:new google.maps.Size(40,-190),closeBoxMargin:'0px -20px 2px 2px',closeBoxURL:"<?php echo $theme_url; ?>assets/img/close.png",isHidden:!1,pane:'floatPane',enableEventPropagation:!0})}
                  });
                    </script>
                   <?php } ?>
                  </div>             
                  </div>
                </div>
              </div>
            </div>
            <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
            <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?php echo trans('0550');?></span></h3>
              <div class="feature-box-2 mb-0 bg-white">
                <div class="feature-row">
                  <div class="row gap-10 gap-md-30">
                  <?php if(!empty($checkInInstructions)){ ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                      <h6><?php echo trans('0550');?></h6>
                    </div>
                    <?php }  if(!empty($checkInInstructions)){ ?>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                      <p> <?php echo $checkInInstructions; ?></p>
                    </div>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            
  <!-- End Hotel Reviews bars -->
 <!-- End Add/Remove Wish list Review Section -->
  <div class="row">
    <div class="clearfix"></div>
    <div class="col-md-12 form-group">
      <?php if($appModule != "cars" && $appModule != "ean" && $appModule != "offers" ){ ?>
      <button  data-toggle="collapse"  type="button" class="writeReview btn btn-primary btn-block mb-10" data-target="#ADDREVIEW" href="#ADDREVIEW" aria-controls="#ADDREVIEW"><i class="icon_set_1_icon-68"></i> <?php echo trans('083');?></button>
      <div class="collapse mt-20" id="ADDREVIEW">
      <div class="card card-body row">
      <form class="form-horizontal row" method="POST" id="reviews-form-<?php echo $module->id;?>" action="" onsubmit="return false;">
          <div id="review_result<?php echo $module->id;?>" style="width:100%" >
          </div>
          <div class="alert resp row" style="display:none"></div>
          <?php $mdCol = 12; if($appModule == "hotels"){ $mdCol = 8; ?>
          <div class="col-md-4 go-right">
            <div class="card card-body card-light">
              <h3 class="text-center"><strong><?php echo trans('0389');?></strong>&nbsp;<span id="avgall_<?php echo $module->id; ?>"> 1</span> / 10</h3>
              <div class="row">
                <div class="col-md-6 form-horizontal">
                  <div class="form-group">
                     <label class="control-label"><?php echo trans('030');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_clean">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                   </div>
                  <div class="form-group">
                      <label class="control-label"><?php echo trans('031');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_comfort">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label class="control-label"><?php echo trans('032');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_location">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label"><?php echo trans('033');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_facilities">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                  </div>
                        <input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
                                <input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
                                <input type="hidden" id="module" value="<?php echo $appModule;?>" />
                                <input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
                                <input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />
                  <div class="form-group">

                      <label class="control-label"><?php echo trans('034');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_staff">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <div class="col-md-<?php echo $mdCol;?>">
            <div class="row">
              <div class="col-md-6">
                <input class="form-control" type="text" name="fullname" placeholder="<?php echo trans('0390');?> <?php echo trans('0350');?>">
              </div>
              <div class="col-md-6">
                <input class="form-control" type="text" name="email" placeholder="<?php echo trans('0390');?> <?php echo trans('094');?>">
              </div>
            </div>
            <div class="form-group"></div>
            <textarea class="form-control" type="text" placeholder="<?php echo trans('0391');?>" name="reviews_comments" id="" cols="30" rows="10"></textarea>
            <div class="form-group"></div>
            <p class="text-danger"><strong><?php echo trans('0371');?></strong> : <?php echo trans('085');?></p>
            <input type="hidden" name="addreview" value="1" />
            <input type="hidden" name="overall" id="overall_<?php echo $module->id; ?>" value="1" />
            <input type="hidden" name="reviewmodule" value="<?php echo $appModule; ?>" />
            <input type="hidden" name="reviewfor" value="<?php echo $module->id; ?>" />
            <div class="form-group">
              <div class="col-md-12">
                <label class="control-label">&nbsp;</label>
                <button type="button" class="btn btn-primary btn-block btn-lg addreview" id="<?php echo $module->id; ?>" ><?php echo trans('086');?></button>
              </div>
            </div>
          </div>
        </form>
      </div>
      </div>
          <?php } ?>
          <?php if($appModule != "offers" && $appModule != "ean"){ ?>
          <?php $currenturl = current_url(); $wishlist = pt_check_wishlist($customerloggedin,$module->id); 
          if($allowreg){
           if($wishlist){ ?>
          <span class="btn wish btn-danger btn-outline removewishlist btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('028');?></span></span>
          <?php }else{ ?>
      <span class="btn wish addwishlist btn-danger btn-outline btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('029');?></span></span>
      <?php } } } ?>
        </div>
       </div>
      </div>
    </div>
  </div>
  
  </div>
  <div class="fullwidth-horizon-sticky border-0">&#032;</div>
      <!-- is used to stop the above stick menu -->
    </div>
  <?php if(!empty($module->relatedItems)){ ?>
  <section class="bg-white section-sm">
    <div class="container">
      <div class="section-title mb-25">
        <h3><?php if($appModule == "hotels" || $appModule == "ean"){ echo trans('0290'); }else if($appModule == "tours"){ echo trans('0453'); }else if($appModule == "cars"){ echo trans('0493'); } ?></h3>
      </div>
      <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
      <?php foreach($module->relatedItems as $item){ ?>
        <div class="col">
          <div class="product-grid-item">
            <a href="<?php echo $item->slug;?>">
              <div class="image">
                <img src="<?php echo $item->thumbnail;?>" class="img-fluid" alt="Image">
              </div>
              <div class="content clearfix">
                <div class="rating-item rating-sm">
                  <div class="rating-icons">
                  <?php echo $item->stars;?>
                  </div>
                  <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
                </div>
                <div class="short-info">
                  <h5><?php echo character_limiter($item->title,25);?></h5>
                  <p class="location"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo character_limiter($item->location,20);?></p>
                </div>
                <?php if($item->price > 0){ ?>
                <div class="price">
                  <div class="float-right">
                  <?php echo trans( '0299');?>
                    <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                  </div>
                </div>
                <?php } ?>
              </div>
            </a>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>
  
<!------------------------  Related Listings   ------------------------------>
<script>
  //------------------------------
  // Write Reviews
  //------------------------------
  $(function() {
      $('.reviewscore').change(function() {
          var sum = 0;
          var avg = 0;
          var id = $(this).attr("id");
          $('.reviewscore_' + id + ' :selected').each(function() {
              sum += Number($(this).val());
          });
          avg = sum / 5;
          $("#avgall_" + id).html(avg);
          $("#overall_" + id).val(avg);
      });

      //submit review
      $(".addreview").on("click", function() {
          var id = $(this).prop("id");
          $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-" + id).serialize(), function(resp) {
              var response = $.parseJSON(resp);
              // alert(response.msg);
              $("#review_result" + id).html("<div class='alert " + response.divclass + "'>" + response.msg + "</div>").fadeIn("slow");
              if (response.divclass == "alert-success") {
                  setTimeout(function() {
                      $("#ADDREVIEW").removeClass('in');
                      $("#ADDREVIEW").slideUp();
                  }, 5000);
              }
          });
          setTimeout(function() {
              $("#review_result" + id).fadeOut("slow");
          }, 3000);
      });
  })

  //------------------------------
  // Add to Wishlist
  //------------------------------
  $(function() {
      // Add/remove wishlist
      $(".wish").on('click', function() {
          var loggedin = $("#loggedin").val();
          var removelisttxt = $("#removetxt").val();
          var addlisttxt = $("#addtxt").val();
          var title = $("#itemid").val();
          var module = $("#module").val();
          if (loggedin > 0) {
              if ($(this).hasClass('addwishlist')) {
                  var confirm1 = confirm("<?php echo trans('0437');?>");
                  if (confirm1) {
                      $(".wish").removeClass('addwishlist btn-primary');
                      $(".wish").addClass('removewishlist btn-warning');
                      $(".wishtext").html(removelisttxt);
                      $.post("<?php echo base_url();?>account/wishlist/add", {
                          loggedin: loggedin,
                          itemid: title,
                          module: module
                      }, function(theResponse) {});
                  }
                  return false;
              } else if ($(this).hasClass('removewishlist')) {
                  var confirm2 = confirm("<?php echo trans('0436');?>");
                  if (confirm2) {
                      $(".wish").addClass('addwishlist btn-primary');
                      $(".wish").removeClass('removewishlist btn-warning');
                      $(".wishtext").html(addlisttxt);
                      $.post("<?php echo base_url();?>account/wishlist/remove", {
                          loggedin: loggedin,
                          itemid: title,
                          module: module
                      }, function(theResponse) {});
                  }
                  return false;
              }
          } else {
              alert("<?php echo trans('0482');?>");
          }
      });
      // End Add/remove wishlist
  })

  //------------------------------
  // Rooms
  //------------------------------

  $('.collapse').on('show.bs.collapse', function() {
      $('.collapse.in').collapse('hide');
  });
  <?php if($appModule == "hotels"){ ?>
  jQuery(document).ready(function($) {
      $('.showcalendar').on('change', function() {
          var roomid = $(this).prop('id');
          var monthdata = $(this).val();
          $("#roomcalendar" + roomid).html("<br><br><div class='matrialprogress'><div class='indeterminate'></div></div>");
          $.post("<?php echo base_url();?>hotels/roomcalendar", {
              roomid: roomid,
              monthyear: monthdata
          }, function(theResponse) {
              console.log(theResponse);
              $("#roomcalendar" + roomid).html(theResponse);
          });
      });
  });
  <?php } ?>
  
</script>
<script>
              setTimeout(function(){
                var silck = document.getElementsByClassName('slick-track');
                silck[0].style.height="360px";
                silck[1].style.height="64px";
              },5000)
              var accr = document.getElementsByClassName('btn-accord');
   for(var i = 0; i < accr.length;i++){
    let activeTab = document.querySelectorAll(".show");
    
    accr[i].addEventListener('click',function(e){

     var dynId = document.getElementById(e.target.href.split("#")[1]);
      
      if(dynId.classList.contains('show')){
        dynId.classList.remove("show");
      }else{dynId.classList.add("show");}
      
    })
   }
  
  </script>

































<!-- <div class="modal <?php if($isRTL == "RTL"){ ?> right <?php } else { ?> left <?php } ?> fade" id="modify" tabindex="1" role="dialog" aria-labelledby="sidebar_filter">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close go-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="close icon-angle-<?php if($isRTL == "RTL"){ ?>right<?php } else { ?>left<?php } ?>"></i></span></button>
        <h4 class="modal-title go-text-right" id="modify"><i class="icon_set_1_icon-65 go-right"></i> <?php echo trans('0106');?></h4>
      </div>
      <?php require $themeurl.'views/includes/rooms_modify.php';?>
    </div>
  </div>
</div>
<div style="margin-top:25px">
  <div class="container">
    <div class="row">
      <?php if($appModule != "offers"){ ?>
      <div class="col-md-12">
        <div class="mob-trip-info-head ttu">
          <span><strong class="ellipsis ttu"><span><?php echo character_limiter($module->title, 28);?></span></strong></span>
          <span class="RTL">
          <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
          <i style="margin-left:-5px" class="icon-location-6"></i>
          <?php } ?>
          <?php echo $module->location; ?> <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, <?php echo character_limiter($module->mapAddress, 50);?></small> <?php } ?>
          </span>
          <div class="clearfix"></div>
          <div><small><?php echo $module->stars;?></small></div>
        </div>
      </div> -->
      <!-- <div class="col-xs-2 col-sm-1 text-center pull-right visible-xs">
        <a class="ttu" data-toggle="modal" data-target="#modify">
        <i class="icon-filter mob-filter"></i>
        <span class="cw"><?php echo trans('0106');?></span>
        </a>
      </div>
      <?php } ?>
      <?php if($appModule != "ean" && $appModule != "hotels" && $appModule != "tours" && $appModule != "cars"){ ?>
      <h3 style="margin: 12px 0px; color: white;" class="text-success text-center"><?php echo character_limiter($module->title, 28);?></h3>
      <?php } ?>
    </div>
  </div>
</div>
<div id="OVERVIEW" class="container mob-row">
  <div class="col-xs-12 col-md-8 go-right mob-row mt-15 pl0">
    <?php if($appModule == "offers"){ ?>
    <h3 style="margin: 0px; background: #eee; padding: 15px; text-transform: uppercase; font-size: 18px; letter-spacing: 3px; border: 1px solid #ccc; font-weight: bold;" class="go-text-right"><i class="icon_set_1_icon-55"></i> <?php echo $module->phone;?></h3>
    <?php } ?>
    <style>
      .fotorama__wrap .fotorama__wrap--css3 .fotorama__wrap--slide .fotorama__wrap--toggle-arrows .fotorama__wrap--no-controls { width:100%; }
      .fotorama__loaded--img img { width:100%; }
    </style> -->
    <!-- slider -->
    <!-- <?php if($hasRooms){ ?>
    <div class="avgprice">
      <small><?php echo trans('0141');?></small>
      <?php if($hasRooms || $appModule == "offers"){ ?>
      <strong><?php echo trans('070');?></strong> <?php echo @$currencySign; ?> <?php echo @$lowestPrice; ?>
      <?php } ?>
    </div>
    <?php } ?>
    <div style="width:100%" class="fotorama bg-dark" data-width="1000" data-height="490" data-allowfullscreen="true" data-autoplay="true" data-nav="thumbs">
      <?php foreach($module->sliderImages as $img){ ?>
      <img style="width:100%;height:450px !important" src="<?php echo $img['fullImage']; ?>" />
      <?php } ?>
    </div>
    <div class="clearfix form-group"></div>
  </div>
  <div class="col-md-4 hidden-xs">
    <div class="row">
      
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="container">
  <div class="col-md-12 go-left">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading panel-green hidden-xs"><?php echo trans('0177'); ?></div>
        <div class="desc-scrol">
          <div class="panel-body">
            <div class="visible-lg visible-md RTL">
              <?php require $themeurl.'views/includes/description.php';?>
            </div>
            <div class="visible-xs">
              <div id="accordion">
                <div class="panel-heading dn">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"></a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                  <p class="main-title go-right"><?php echo trans('046');?></p>
                  <div class="clearfix"></div>
                  <i class="tiltle-line  go-right"></i>
                  <div class="clearfix"></div>
                  <div class="mob-fs14 RTL"><?php echo character_limiter($module->desc, 88);?></div>
                </div>
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><strong><?php echo trans('0286');?> <i class="lightcaret mt-2 go-leftt"></i></strong></a>
                </h4>
                <div id="collapse2" class="panel-collapse collapse">
                  <?php require $themeurl.'views/includes/description.php';?>
                </div>
                <div class="clearfix"></div>
                <input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
                <input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
                <input type="hidden" id="module" value="<?php echo $appModule;?>" />
                <input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
                <input type="hidden" id="removetxt" value="<?php echo trans('028');?>" /> -->
                <!-- Start Add/Remove Wish list Review Section -->
              <!-- </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 aside -->
<!-- <div class="container mob-row">
  <?php include 'amenities.php';?>
  <div class="clearfix"></div>
  <div class="visible-lg visible-md">
    <?php include 'rooms_modify.php';?>
  </div>
  <?php if($appModule == "hotels") {?>
  <div class="hidden-sm hidden-md hidden-lg">
    <div class="col-xs-6">
      <label class="check_dates"><?php echo trans('07');?>: <?php echo $module->defcheckin;?></label>
      <div><?php echo $checkin;?></div>
    </div>
    <div class="col-xs-6 text-right">
      <label class="check_dates"><?php echo trans('07');?>: <?php echo $module->defcheckin;?></label>
      <div><?php echo $checkout;?></div>
    </div>
    <div class="clearfix"></div>
    <br>
  </div>
  <?php } ?>
  <div class="clearfix"></div>
  
  <div class="">
    <div class="">
      <div class="clearfix"></div> -->
      <!-- <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
      Start checkInInstructions 
      <?php if(!empty($checkInInstructions)){ ?>
      <div class="panel panel-default">
        <div class="panel-heading go-text-right panel-green">
          <?php echo trans('0550'); ?>
        </div>
        <?php }  if(!empty($checkInInstructions)){ ?>
        <div class="panel-body">
          <span class="RTL">
            <p>
              <?php echo $checkInInstructions; ?>
            </p>
          </span>
        </div>
      </div>
      <?php } ?>
      End checkInInstructions 
      Start SpecialcheckInInstructions 
      <?php if(!empty($specialCheckInInstructions)){ ?>
      <div class="panel panel-default">
        <div class="panel-heading go-text-right panel-green">
          <?php echo trans('0551'); ?>
        </div>
        <?php }  if(!empty($specialCheckInInstructions)){ ?>
        <div class="panel-body">
          <span class="RTL">
            <p>
              <?php echo $specialCheckInInstructions; ?>
            </p>
          </span>
        </div>
      </div>
      <?php } ?>
      End  SpecialcheckInInstructions 
      <?php if(!empty($module->policy)){ ?>
      <p class="main-title go-right"><?php echo trans('0148');?></p>
      <div class="clearfix"></div>
      <i class="tiltle-line  go-right"></i>
      <div class="clearfix"></div>
      <?php echo $module->policy; } ?>
      <?php } ?> -->
      
      <!-- <?php if($appModule != "cars" && $appModule != "ean"){ ?>
      <div class="clearfix"></div>
      <hr>
      <?php if(!empty($module->paymentOptions)){ ?>
      <p id="terms" class="main-title  go-right"><?php echo trans('0265');?></p>
      <div class="clearfix"></div>
      <i class="tiltle-line  go-right"></i>
      <div class="clearfix"></div>
      <span class="RTL">
      <?php foreach($module->paymentOptions as $pay){ if(!empty($pay->name)){ ?>
      <?php echo $pay->name;?> -
      <?php } } ?>
      </span>
      <br><br>
      <?php } ?>
      <div class="hidden-xs">
        <?php if($appModule == "hotels"){ ?>
        <?php } ?>
      </div> -->
      <!-- Start Tours Inclusions / Exclusions -->
      <!-- <?php if($appModule == "tours"){ ?>
      <p class="go-text-left"><i class="fa fa-sun-o text-success"></i> <strong> <?php echo trans('0275');?> </strong> :   <?php echo $module->tourDays;?> | <i class="fa fa-moon-o text-warning"></i>   <strong> <?php echo trans('0276');?> </strong> :  <?php echo $module->tourNights;?> </p>
      <div class="row">
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-6" id="INCLUSIONS">
          <h4 class="main-title go-right"><?php echo trans('0280');?></h4>
          <div class="clearfix"></div>
          <i class="tiltle-line go-right"></i>
          <div class="clearfix"></div>
          <br>
          <?php foreach($module->inclusions as $inclusion){ if(!empty($inclusion->name)){  ?>
          <ul class="list_ok col-md-12 RTL" style="margin: 0 0 5px 0;">
            <li class="go-right"><?php echo $inclusion->name; ?></li>
          </ul>
          <?php } } ?>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-6" id="EXCLUSIONS">
          <h4 class="main-title go-right"><?php echo trans('0281');?></h4>
          <div class="clearfix"></div>
          <i class="tiltle-line go-right"></i>
          <div class="clearfix"></div>
          <br>
          <?php foreach($module->exclusions as $exclusion){ if(!empty($exclusion->name)){  ?>
          <ul class="col-md-12" style="margin: 0 0 5px 0;list-style:none;">
            <li class="go-right"><i style="font-size: 13px; color: #E25A70; margin-left: -16px;" class="icon-cancel-5 go-right"></i> &nbsp;&nbsp;&nbsp; <?php echo $exclusion->name; ?> &nbsp;&nbsp;&nbsp;</li>
          </ul>
          <?php } } ?>
          <div class="clearfix"></div>
        </div>
      </div>
      <?php } } ?>
    </div>
  </div>
  <br> -->
  <!-- End Tour Form aside -->
  <!-- <div class="container hidden-xs">
    <?php include 'includes/ratinigs.php';?>
    <div class="clearfix"></div>
    <?php if($appModule != "cars" && $appModule != "ean"){ include 'includes/review.php'; } ?>
    <div class="clearfix"></div>
    <?php include 'includes/review.php';?>
    <?php include 'includes/reviews.php';?>
    <div class="clearfix"></div>
  </div>
</div>
<?php if(!empty($module->relatedItems)){ ?>
<div class="featured-back hidden-xs hidden-sm">
  <div class="container">
    <div class="row">
      <h2 class="destination-title go-right">
        <?php if($appModule == "hotels" || $appModule == "ean"){ echo trans('0290'); }else if($appModule == "tours"){ echo trans('0453'); }else if($appModule == "cars"){ echo trans('0493'); } ?>
      </h2>
    </div>
    <div class="main_slider">
      <div class="set hotels-left fa-left"> <i class="icon-left-open-3"></i> </div>
      <div class="related" class="get">
        <?php foreach($module->relatedItems as $item){ ?>
        <div class="owl-item">
          <div class="imgLodBg">
            <div class="load"></div>
            <img data-wow-duration="0.2s" data-wow-delay="1s" class="wow fadeIn" src="<?php echo $item->thumbnail;?>">
            <div class="country-name wow fadeIn">
              <h4 class="ellipsis go-text-right"><?php echo character_limiter($item->title,25);?></h4>
              <p class="go-text-right"><i class="icon-location-6 go-text-right go-right"></i>
                <?php echo character_limiter($item->location,20);?> &nbsp;
              </p>
            </div>
            <div class="overlay">
              <div class="textCenter">
                <div class="textMiddle">
                  <a class="loader" href="<?php echo $item->slug;?>">
                  <?php echo trans( '0142');?>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="additional-info">
            <div class="pull-left rating-passive"> <span class="stars"><?php echo $item->stars;?></span> </div>
            <div class="pull-right"> <i data-toggle="tooltip" title="Price" class="icon-tag-6"></i>
              <?php if($item->price > 0){ ?> <span class="text-center">
              <small><?php echo $item->currCode;?></small> <?php echo $item->currSymbol; ?><?php echo $item->price;?>
              </span>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="set fa-right hotels-right"> <i class="icon-right-open-3"></i> </div>
    </div>
  </div>
</div>
<?php } ?> -->
<!------------------------  Related Listings   ------------------------------>
<!------------------------  Related Listings   ------------------------------>
<!-- <div class="container">
  <div class="col-md-12"> -->
    <!-- Start Offers Contact Form -->
    <!-- <?php if($appModule == "offers"){ ?>
    <?php if(!empty($module->email)){ ?>
    <form class="panel panel-default" action="" method="POST">
      <fieldset>
        <?php if(!empty($success)){ ?>
        <div class="alert alert-success successMsg"><?php echo trans('0479');?></div>
        <?php } ?> <br>
        <div class="col-md-12 go-right form-group">
          <label class="go-right"><?php echo trans('0350');?></label>
          <input class="form-control" placeholder="<?php echo trans('0350');?>" type="text" name="name" value="" required>
        </div>
        <div class="col-md-12 go-left form-group">
          <label class="go-right"><?php echo trans('092');?></label>
          <input class="form-control" placeholder="<?php echo trans('092');?>" type="text" name="phone" value="" required>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <label class="go-right"><?php echo trans('0262');?></label>
          <textarea class="form-control" placeholder="<?php echo trans('0262');?>" name="message" rows="4" cols="25" required></textarea><br>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
          <input type="hidden" name="toemail" value="<?php echo $module->email;?>">
          <input type="hidden" name="sendmsg" value="1">
          <input class="btn btn-success btn-success btn-block btn-lg" type="submit" name="" value="<?php echo trans('0439');?>">
          <br>
        </div>
        <br> -->
        <!-- END CONTACT FORM -->
      <!-- </fieldset>
    </form> -->
    <!-- <?php } if(!$module->offerForever){ ?> -->
    <!-- Start Offers countdown -->
    <!-- <i class="fa fa-clock-o go-right"></i>
    <h4><?php echo trans('0269');?></h4>
    <p href="#" class="phone"><span class="wow fadeInLeft animated" id="countdown"></span></p> -->
    <!-- End Offers countdown -->
    <!-- <?php } ?>
    <div class="clearfix"></div>
    <script type="text/javascript">
      // set the date we're counting down to
      var target_date = new Date('<?php echo $module->fullExpiryDate; ?>').getTime();

      // variables for time units
      var days, hours, minutes, seconds;

      // get tag element
      var countdown = document.getElementById('countdown');

      // update the tag with id "countdown" every 1 second
      setInterval(function () {

      // find the amount of "seconds" between now and target
      var current_date = new Date().getTime();
      var seconds_left = (target_date - current_date) / 1000;

      // do some time calculations
      days = parseInt(seconds_left / 86400);
      seconds_left = seconds_left % 86400;

      hours = parseInt(seconds_left / 3600);
      seconds_left = seconds_left % 3600;

      minutes = parseInt(seconds_left / 60);
      seconds = parseInt(seconds_left % 60);

      // format countdown string + set tag value
      countdown.innerHTML = '<span class="days">' + days +  ' <b><?php echo trans("0440");?></b></span> <span class="hours">' + hours + ' <b><?php echo trans("0441");?></b></span> <span class="minutes">'
      + minutes + ' <b><?php echo trans("0442");?></b></span> <span class="seconds">' + seconds + ' <b><?php echo trans("0443");?></b></span>';

      }, 1000);

      $(function(){
          setTimeout(function(){
      $(".successMsg").fadeOut("slow");
      }, 7000);

      });

    </script>
    <?php } ?> -->
    <!-- End Offers Contact Form -->
  <!-- </div>
</div> -->

