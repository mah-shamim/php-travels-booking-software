<style>
  @media(min-width:992px){.header-waypoint-sticky.header-main{position:fixed;top:0;left:0;right:0;z-index:99999}
  }.amint-text{display:inline-block;transform:translateY(-10px)}
  .form-icon-left{display:flex}
  .form-icon-left>label{flex:2}
  .form-icon-left>select{flex:2}
  .collapse .card-body{margin-bottom:10px}
  .table-condensed>tbody>tr>td{padding:5px}
  .section-title h3{font-family:inherit!important}
  .header-main .header-nav{box-shadow:none!important}
  .w-40{width:40%!important}
  .heading-title+p{font-size:inherit;font-weight:normal}
  .page-wrapper.page-detail .sidebar-wrapper{padding-top:20px!important}
  .review-item ul.meta-list li{padding-left: 0 !important; margin: 12px 12px 0 0;}
  .product-grid-item .image img {
  min-height: 260px !important;
  }
  .slide-images .slick-list{
  height:600px;
  }
  .slide-thumbs .slick-list{
  height:70px;
  }
</style>
<?php if(isset($errorMessage) && ! empty($errorMessage)) {
  echo $errorMessage; die(); }
  ?>
<link href="<?php echo $theme_url; ?>assets/include/slider/slider.min.css" rel="stylesheet">
<script src="<?php echo $theme_url; ?>assets/js/details.js"></script>
<script src="<?php echo $theme_url; ?>assets/include/slider/slider.js"></script>
<div class="main-wrapper scrollspy-action">
<div class="page-wrapper page-detail bg-light">
<div class="detail-header">
  <div class="container">
    <div class="d-flex flex-column flex-lg-row sb">
      <div class="o2">
        <h2 id="detail-content-sticky-nav-00" class="name"><?=$hotel->name?></h2>
        <div class="star-rating-wrapper go-right">
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
          <?=$hotel->city?>
          <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, <?=$hotel->address?></small>
          <?php } ?>
          <a href="#detail-content-sticky-nav-03" class="anchor">
          <?php echo trans('0143');?>
          </a>
        </p>
      </div>
      <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
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
<div  class="col-12 col-lg-3 col-xl-3 order-lg-last">
  <aside class="sticky-kit sidebar-wrapper">
    <!-- <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-block btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button> -->
    <div class="booking-selection-box mt-20">
      <div class="heading clearfix">
        <div class="d-flex justify-content-between">
          <h5 class="text-white"><?php echo trans('0197'); ?> </h5>
          <span class="text-white"><?php echo trans('0122');?> <?php echo $modulelib->stay; ?></span>
        </div>
      </div>
      <!--Refine dates -->
      <form name="fRecheckForm"  action="<?=base_url('hotelb/detail/')?>" method="POST">
        <div class="col-md-12 col-xs-12 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-calendar-7"></i> <?php echo trans('07');?></label>
            <input type="text" placeholder="<?php echo trans('07');?>" name="checkin" class="form-control dpd1rooms" value="<?=$_SESSION['checkIn']?>" required>
          </div>
        </div>
        <div class="col-md-12 col-xs-12 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-calendar-7"></i> <?php echo trans('09');?></label>
            <input type="text" placeholder="<?php echo trans('09');?>" name="checkout" class="form-control dpd2rooms" value="<?=$_SESSION['checkOut']?>" required>
          </div>
        </div>
        <div class="col-md-12 col-xs-12 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-user-7"></i> <?php echo trans('010');?></label>
            <select class="mySelectBoxClass form-control" name="adults" id="adults">
              <?php for($i = 1; $i <= 10; $i++): ?>
              <option value="<?=$i?>" <?=($i == $input->adult)?'selected':''?>><?=$i?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="col-md-12 col-xs-12 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-user-7"></i> <?php echo trans('011');?></label>
            <select class="mySelectBoxClass form-control" name="child" id="child">
              <?php for($i = 0; $i < 5; $i++): ?>
              <option value="<?=$i?>" <?=($i == $input->children)?'selected':''?>><?=$i?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="col-md-12 col-xs-12 go-right">
          <label class="hidden-xs">&nbsp;</label>
          <input type="hidden" name="hotelname" value="<?=$hotel->slug?>">
          <button type="submit" class="btn btn-secondary btn-block mt-20 btn-action btn-lg loader"><?php echo trans('0106');?></button>
        </div>
      </form>
      <!--Refine dates -->
    </div>
  </aside>
</div>
<div class="col-12 col-lg-9 col-xl-9">
  <div class="content-wrapper">
    <div class="slick-gallery-slideshow detail-gallery">
      <div class="slider gallery-slideshow slide-images">
        <?php  foreach(array_slice(json_decode($hotel->images), 0, 10) as $image) { ?>
        <div>
          <div class="image"><img src="//photos.hotelbeds.com/giata/<?=$image->path?>" alt="<?=$hotel->imageTypeCode?>" title="<?=$hotel->imageTypeCode?>" /></div>
        </div>
        <?php } ?>
      </div>
      <div class="slider gallery-nav slide-thumbs">
        <?php  foreach(array_slice(json_decode($hotel->images), 0, 10) as $image) { ?>
        <div>
          <div class="image"><img src="//photos.hotelbeds.com/giata/<?=$image->path?>" alt="<?=$hotel->imageTypeCode?>" title="<?=$hotel->imageTypeCode?>" /></div>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php include $themeurl.'views/socialshare.php';?>
    <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section">
      <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
      <div class="clear"></div>
      <?=$hotel->description?>
      <hr>
    </div>
    <div class="clear"></div>
    <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
      <h3 class="heading-title"><span><?php echo trans('0372'); ?></span></h3>
      <div class="clear"></div>
      <section id="ROOMS" class="pt-0">
        <div class="panel panel-default">
          <div class="clearfix"></div>
          <div class="clearfix"></div>
          <div class="clearfix"></div>
          <table class="bgwhite table table-striped">
            <tbody>
              <?php foreach($sessionHotel['rooms'] as $index => $room): ?>
              <tr>
                <td class="wow fadeIn p-10-0 animated" style="visibility: visible; animation-name: fadeIn;">
                  <div class="row align-items-center">
                    <div class="col-md-2 col-xs-5 go-right rtl_pic">
                      <div class="img_list_rooms">
                        <div class="zoom-gallery52">
                          <a href="<?=base_url()?>uploads/images/hotels/rooms/thumbs/hotelbeds-room-default.jpg" data-source="<?=base_url()?>uploads/images/hotels/rooms/thumbs/hotelbeds-room-default.jpg" title="Hyatt Regency Perth">
                          <img style="max-height:180px" class="img-responsive" src="<?=base_url()?>uploads/images/hotels/rooms/thumbs/hotelbeds-room-default.jpg">
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10 col-xs-7 g0-left">
                      <div class="row align-items-center">
                        <div class="col-md-4" style="margin-top: 15px;">
                          <h5 class="RTL go-text-right mt0 list_title ttu">
                            <a href="javascript:void(0)">
                            <?=$room->name?>
                            </a>
                          </h5>
                        </div>
                        <div class="col-md-8 book_area">
                          <div class="row no-gutters align-items-center">
                            <div class="col-md-3 book_buttons hidden-xs hidden-sm">
                              <button data-toggle="collapse" data-parent="#accordion" class="d-none d-md-block btn btn-primary btn-block btn-sm" href="#details_<?=$index?>"><?php echo trans('0246');?></button>
                            </div>
                            <div class="col-md-5">
                              <h2 class="book_price text-center mob-fs18 rooms-book-button go-right">
                                <small>
                                <?php
                                  $min_price = min(array_column($room->rates, 'net'));
                                  echo $sessionHotel['hotel']->currency;
                                  ?></small> <strong><?=$vfHotelbedsMarkup($min_price, $markupPercentage)?></strong>
                              </h2>
                            </div>
                            <div class="col-md-4">
                              <form name="fBookNow" action="#" method="post">
                                <input type="hidden" name="detailPageUrl" value="<?=$detailPageUrl?>"/>
                                <input type="hidden" name="hotelname" value="<?=$hotel->name?>"/>
                                <input type="hidden" name="hotelslug" value="<?=$hotel->slug?>"/>
                                <input type="hidden" name="rateKey" value=""/><!-- set value onclick radion button -->
                                <input type="hidden" name="checkIn" value="<?=$sessionHotel['checkIn']?>"/>
                                <input type="hidden" name="checkOut" value="<?=$sessionHotel['checkOut']?>"/>
                                <input type="hidden" name="adults" value="<?=$input->adult?>"/>
                                <input type="hidden" name="childrens" value="<?=$input->children?>"/>
                                <button type="button" id="fBookNow" class="book_button btn btn-md btn-danger btn-block btn-block chk mob-fs10 loader">Book Now</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div style="color:#333333 !important" id="details_<?=$index?>" class="panel-body panel-collapse collapse in">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <!-- room rates -->
                        <table class="table table-striped" id="room_rates">
                          <thead>
                            <tr>
                              <td><?php echo trans('070');?></td>
                              <td><?php echo trans('0350');?></td>
                              <td><?php echo trans('016');?></td>
                              <td><?php echo trans('010');?></td>
                              <td><?php echo trans('011');?></td>
                              <td><?php echo trans('0586');?></td>
                              <td><?php echo trans('0265');?></td>
                              <td><?php echo trans('0340');?> <?php echo trans('00');?></td>
                              <td><?php echo trans('0181');?></td>
                              <td><?php echo trans('0155');?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($room->rates as $rate_index => $rate): ?>
                            <tr data-ratekey="<?=$rate->rateKey?>">
                              <?php $hotelCurrency = (array_key_exists('hotelCurrency', $rate))?$rate->hotelCurrency:$sessionHotel['hotel']->currency;?>
                              <td id="net_rate"><?=$hotelCurrency.$rate->net?></td>
                              <td><?=$rate->boardName?></td>
                              <td><?=$rate->rooms?></td>
                              <td><?=$rate->adults?></td>
                              <td><?=$rate->children?></td>
                              <td><?=$rate->rateClass?></td>
                              <td><?=$rate->paymentType?></td>
                              <td id="rate_type">
                                <?php if (strtoupper($rate->rateType) == 'RECHECK'):?>
                                <?=$rate->rateType?><br /> <span style="cursor: pointer;color: blue;text-decoration: underline;" onclick="recheckPrice('<?=$rate->rateKey?>', '<?=$index.$rate_index?>')">click here</span>
                                <p id="processing-<?=$index.$rate_index?>" style="text-align: center"></p>
                                <?php else: ?>
                                <?=$rate->rateType?>
                                <?php endif; ?>
                              </td>
                              <td><?=$rate->allotment?></td>
                              <td>
                                <input type="radio" value="<?=$rate->rateKey?>" name="rRateKey" id="rate_key"/>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="10">
                                <div class="cancellation-policy">
                                  <h5><strong>Cancellation Policy:</strong></h5>
                                  <p>
                                    <?php if (isset($rate->cancellationPolicies) && ! empty($rate->cancellationPolicies)): ?>
                                    Amount: <?=current($rate->cancellationPolicies)->amount?><br/>
                                    From: <?=current($rate->cancellationPolicies)->from?>
                                    <?php else: ?>
                                    Not Available
                                    <?php endif; ?>
                                  </p>
                                </div>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
    <div class="clear"></div>
    <!-- <button type="submit" class="book_button btn btn-md btn-success btn-block btn-block chk mob-fs10 loader" disabled>
      <?php echo trans('0142');?>
      </button> -->
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
  <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
  <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
    <h3 class="heading-title"><span><?=lang('0143')?></span></h3>
    <div class="clear"></div>
    <div class="hotel-detail-location-wrapper">
      <div class="row gap-30">
        <div class="col-12 col-md-12">
          <div class="map-holder">
            <div id="hotel-detail-map" data-lat="<?php echo $module->latitude;?>" data-lon="<?php echo $module->longitude;?>" style="width: 100%; height: 480px;"></div>
            <div class="infobox-wrapper">
              <div id="infobox">
                <div class="infobox-inner">
                  <div class="font500 font12"><?php echo character_limiter($module->title, 28);?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
    <h3 class="heading-title"><span><?php echo trans('0148');?></span></h3>
    <div class="clear"></div>
    <div class="feature-box-2 mb-0 bg-white">
      <div class="feature-row">
        <div class="row gap-10 gap-md-30">
          <div class="col-xs-12 col-sm-4 col-md-3 o2">
            <h6><?php echo trans('0148');?></h6>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="feature-row">
        <div class="row gap-10 gap-md-30">
          <div class="col-12 col-sm-4 col-md-3 o2">
            <h6><?php echo trans('07');?></h6>
            <div class="clear"></div>
          </div>
          <div class="col-12 col-sm-8 col-md-9 o1">
            <p><?=$sessionHotel['checkIn']?></p>
          </div>
        </div>
      </div>
      <div class="feature-row">
        <div class="row gap-10 gap-md-30">
          <div class="col-12 col-sm-4 col-md-3 o2">
            <h6><?php echo trans('09');?></h6>
            <div class="clear"></div>
          </div>
          <div class="col-12 col-sm-8 col-md-9 o1">
            <p><?=$sessionHotel['checkOut']?> </p>
          </div>
        </div>
      </div>
      <div class="feature-row">
        <div class="row gap-10 gap-md-30">
          <div class="col-xs-12 col-sm-4 col-md-3 o2">
            <h6><?php echo trans('0265');?></h6>
            <div class="clear"></div>
          </div>
          <div class="col-xs-12 col-sm-8 col-md-9 o1">
            <p> <?php echo implode(', ', array_column($sessionHotel['creditCards'], 'name')); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Hotel Reviews bars -->
</div>
<!------------------------  Feature hotels   ------------------------------>
<section class="bg-white section-sm">
  <div class="container">
  <div class="section-title mb-25">
    <h3> <?php echo trans('0290');?></h3>
    <div class="clear"></div>
  </div>
  <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
    <?php foreach($featuredHotels as $fHotel): ?>
    <a href="<?=sprintf($featuredHotelsUrl,strtolower(str_replace(' ', '-', $fHotel->name)))?>">
      <div class="col">
        <div class="product-grid-item">
          <?php $image = json_decode($fHotel->images)[0]->path; ?>
          <?php
            $external_link = $hotel->image;
            if (@getimagesize($external_link)) {
                echo '<img src="//photos.hotelbeds.com/giata/<?=$image" alt="Image" />';
              } else { ?>
          <img src="<?php echo base_url().'themes/default/assets/img/data/hotel.jpg'; ?>" alt="default-imge">
          <?php }
            ?>
          <div class="content clearfix">
            <div class="rating-item rating-sm go-text-right">
              <div class="rating-icons">
                <?php for($star = 1; $star <= 5; $star++): ?>
                <?php if($fHotel->ratingStars < $star): ?>
                <i class="rating-icon fa fa-star rating-rated"></i>
                <?php else: ?>
                <i class="rating-icon fa fa-star rating-rated"></i>
                <?php endif; ?>
                <?php endfor; ?>
              </div>
              <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
            </div>
            <div class="short-info">
              <h5 class="go-text-right"><?=$fHotel->name?></h5>
              <div class="clear"></div>
              <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary go-right"></i> <?=$fHotel->city?></p>
            </div>
            <?php if($item->price > 0){ ?>
            <div class="price">
              <div class="float-right">
                <?php echo trans( '0299');?>
                <span class="text-secondary"><?php echo $item->currCode;?><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
              </div>
            </div>
            <?php } ?>
          </div>
    </a>
    </div>
    </div>
    </a>
    <?php endforeach; ?>
</section>
<!------------------------  Related Listings   ------------------------------>
<div id="OVERVIEW" class="container mob-row">
<div class="col-md-4 hidden-xs">
<div class="row">
<div id="map" class="map hidden-xs"></div>
<script>
  $(document).ready(function(){
      var myLatLng = {lat: <?=$hotel->latitude?>, lng: <?=$hotel->longitude?>};
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: myLatLng
      });
      var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: '<?=$hotel->name?>'
      });
  });
</script>
</div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 go-left">
<div class="row">
<div class="panel panel-default">
<div class="desc-scrol">
<div class="panel-body">
<div class="visible-xs">
<div id="accordion">
<div class="panel-heading dn">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"></a>
</h4>
</div>
<div id="collapse1" class="panel-collapse collapse in">
</div>
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><strong> <i class="lightcaret mt-2 go-leftt"></i></strong></a>
</h4>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- aside -->
</div>
</div>
<script>
  function recheckPrice(rateKey, index) {
      var processing = $("#processing-"+index);
      processing.text("...");
      $.post('<?=base_url("hotelb/checkrate")?>', {
          "rateKey": rateKey
      }, function (res) {
          if (res.status == 'success') {
              var row = $("#room_rates tbody tr[data-rateKey='"+rateKey+"']");
              row.find('#net_rate').text(res.data.net);
              if (res.rateType != "RECHECK") {
                  row.find('#rate_type').text(res.data.rateType);
                  processing.text("");
              }
              row.find('#rate_key').text(res.data.rateKey);
          } else {
              processing.text("fail");
              console.log(res);
          }
      });
  }
  
  //    function create_slug(data) {
  //        var checkin = data['checkin'].replace(/\/+/g, '-');
  //        var checkout = data['checkout'].replace(/\/+/g, '-');
  //        alert( data['hotelname']+"/"+checkin+"/"+checkout+"/"+data['adults']+"/"+data['child']);return;
  //    }
  $("form[name=fRecheckForm]").on("submit", function(e) {
      e.preventDefault();
      var values = {};
      $.each($(this).serializeArray(), function(i, field) {
          values[field.name] = field.value;
      });
      var checkin = values['checkin'].replace(/\/+/g, '-');
      var checkout = values['checkout'].replace(/\/+/g, '-');
      var url = values['hotelname']+"/"+checkin+"/"+checkout+"/"+values['adults']+"/"+values['child'];
      window.location.href = $(this).attr('action')+'recheck/'+url;
  });
  
  $("button[id=fBookNow]").on("click", function (e) {
  var fBookNow = $("form[name=fBookNow]");
  var rRateKey = $("input[name=rRateKey]:checked").val();
  $("input[name=rateKey]").val(rRateKey);
  if($("input[name=rateKey]").val() != "") {
      fBookNow.attr('action', "<?=base_url('hotelb/checkout')?>");
      fBookNow.submit();
  } else {
      e.preventDefault();
  }
  })
  
</script>