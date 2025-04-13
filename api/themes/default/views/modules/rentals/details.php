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
    .panel-heading{padding:11px 18px;background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;font-size:14px;color:#000;border-top-right-radius:3px;border-top-left-radius:3px;text-transform:uppercase;letter-spacing:2px}
    .tchkin{height:calc(2.7em+.75rem+2px);margin-top:20px!important}
    ul.booking-amount-list:before{content:''}
    ul.booking-amount-list li{width:100%;float:none}
    .tour-child h6,.tour-child select,.tour-child .childPrice{flex:0 0 33%;margin-right:0!important;letter-spacing:0!important;width:33%!important}
    .tour-child select,.tour-infant select,.adult-Price select{transform:translateX(10px)}
    .tour-child .childPrice{display:flex!important;justify-content:flex-end}
    .tour-infant h6,.tour-infant select,.tour-infant .infantPrice{flex:0 0 33%;margin-right:1px!important;letter-spacing:0!important;width:33%!important}
    .tour-infant .infantPrice{display:flex!important;justify-content:flex-end}
    .adult-Price h6,.adult-Price select,.adult-Price .adultPrice{flex:0 0 33%;margin-right:1px!important;letter-spacing:0!important;width:33%!important}
    .adultPrice{display:flex!important;justify-content:flex-end}
</style>
<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-detail bg-light">
        <div class="detail-header">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row sb">
                    <?php if($appModule != "offers"){ ?>
                        <div class="o2">
                            <h2 id="detail-content-sticky-nav-00" class="name"><?php echo character_limiter($module->title, 50);?></h2>

                            <div class="star-rating-wrapper">
                                <div class="rating-item rating-inline">
                                    <div class="rating-icons">
                                        <?php echo $module->stars;?>
                                        <!-- <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="4.5"/> -->
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($module->discount)): ?>
                            <div class="discount"><?= $module->discount; ?> % <?=lang('0118')?></div>
                            <?php endif ?>
                            <div class="clear"></div>
                            <p class="location">
                                <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "rentals"){ ?>
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
                    <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
                        <?php  if($item->price > 0){ ?>
                            <div class="price">
                                <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                            </div>
                        <?php } ?>
                        <a href="#detail-content-sticky-nav-01" class="anchor btn btn-primary btn-wide mt-5">
                            <?php echo trans('046');?>
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
                                <a href="#packages"><?php echo trans('0630');?></a>
                            </li>
                            <!--<li>
                <a href="#detail-content-sticky-nav-02"><?php echo trans('0372');?></a>
              </li>-->
                            <li>
                                <a href="#detail-content-sticky-nav-03"><?php echo trans('032');?></a>
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
            <div id="change-search" class="collapse mt-30">
                <div class="change-search-wrapper">
                    <div class="row gap-10 gap-xl-20 align-items-end">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <?php echo searchForm($appModule, $data); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row gap-30">
                <div class="col-12 col-lg-4 col-xl-3 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <!--<button class="btn btn-secondary btn-wide btn-toggle collapsed btn-block btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>-->
                        <div class="booking-selection-box">
                            <div class="heading clearfix">
                                <div class="d-flex align-items-end fe">
                                    <div>
                                        <h5 class="text-white font-serif font400"><?php echo trans('0463'); ?></h5>
                                    </div>
                                    <!--<div class="ml-auto">
                                      <a href="#" class="booking-selection-filter">reset</a>
                                      </div>-->
                                </div>
                            </div>
                            <form action="" method="GET">
                                <div class="content">
                                    <form action="" method="GET" id="hello">
                                        <div class="hotel-room-sm-item">
                                            <div class="the-hotel-item">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input name="date" type="text" class="form-control tourdate form-control-sm" placeholder="<?php echo trans('08');?>" value="<?php echo $module->date; ?>" >
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-block btn-success btn-sm loader mt-5 date"><?php echo trans('0454');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form  action="<?php echo base_url().$appModule;?>/book/<?php echo $module->bookingSlug;?>" method="GET" role="search" style="width: 100%">
                                        <input type="hidden" name="date" value="<?php echo $module->date;?>">
                                        <?php if(!empty($modulelib->error)){ ?>
                                            <div class="alert alert-danger go-text-right">
                                                <?php echo trans($modulelib->errorCode); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="hotel-room-sm-item">
                                            <div class="the-room-item">
                                                <?php if($module->adultStatus){ ?>
                                                <div class="d-flex align-items-center adult-Price">
                                                    <h6><?php echo trans('010');?> <?php echo $module->currSymbol;?><?php echo $module->perAdultPrice;?></h6>
                                                    <select style="min-width:50px;height: 35px !important;min-height: 35px !important;" name="adults" class="changeInfo input-sm form-control" id="selectedAdults">
                                                        <?php for($adults = 1; $adults <= $module->maxAdults; $adults++){ ?>
                                                            <option value="<?php echo $adults;?>" <?php echo makeSelected($selectedAdults, $adults); ?>><?php echo $adults;?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="price adultPrice"><?php echo $module->currSymbol;?><?php echo $module->adultPrice;?></span>
                                                </div>
                                                <!--  <a href="#" class="remove"><i class="fa fa-times"></i></a> -->
                                            </div>
                                            <div class="the-room-item">
                                                <?php } if($module->childStatus){ ?>
                                                <div class="d-flex align-items-center tour-child">
                                                    <h6><?php echo trans('011');?>  <?php echo $module->currSymbol;?><?php echo $module->perChildPrice;?></h6>
                                                    <select name="child" class="selectx changeInfo input-sm form-control" id="selectedChild" style="height: 35px !important;min-height: 35px !important;">
                                                        <option value="0">0</option>
                                                        <?php for($child = 1; $child <= $module->maxChild; $child++){ ?>
                                                            <option value="<?php echo $child;?>" <?php echo makeSelected($selectedChild, $child); ?> ><?php echo $child;?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="price childPrice"><?php echo $module->currSymbol;?><?php echo $module->childPrice;?></span>
                                                </div>
                                                <!--  <a href="#" class="remove"><i class="fa fa-times"></i></a> -->
                                            </div>
                                            <div class="the-room-item">
                                                <?php } if($module->infantStatus){  ?>
                                                    <div class="d-flex align-items-center tour-infant">
                                                        <h6><?php echo trans('0282');?>  <?php echo $module->currSymbol;?><?php echo $module->perInfantPrice;?></h6>
                                                        <select name="infant" class="selectx changeInfo input-sm form-control" id="selectedInfants" style="height: 35px !important;min-height: 35px !important;">
                                                            <option value="0">0</option>
                                                            <?php for($infant = 1; $infant <= $module->maxInfant; $infant++){ ?>
                                                                <option value="<?php echo $infant;?>" <?php echo makeSelected($selectedInfants, $infant); ?> ><?php echo $infant;?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="price infantPrice"><?php echo $module->currSymbol;?><?php echo $module->infantPrice;?></span>
                                                    </div>
                                                <?php } ?>
                                                <!--  <a href="#" class="remove"><i class="fa fa-times"></i></a> -->
                                            </div>
                                        </div>
                                        <div class="hotel-room-sm-item">
                                            <div class="the-hotel-item">
                                                <h4 class="well well-sm text-center strong" style="margin-top: 4px; line-height: 20px;"> <?php echo trans('0334'); ?> <span style="color:#333333;" class="totalCost"><?php echo $module->currCode;?> <?php echo $module->currSymbol;?><strong><?php echo $module->totalCost;?></strong></span>

                                                    <small style="font-size: 12px;"> <?php echo trans('0126');?> <span class="totaldeposit"> <?php echo $module->currCode;?> <?php echo $module->currSymbol;?><?php echo $module->totalDeposit;?></span> </small>
                                                </h4>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <button style="height: 59px; margin: 3px;" type="submit" class="btn btn-secondary btn-block mt-20 btn-action btn-lg loader"><?php echo trans('0142');?></button>
                                </div>
                            </form>
                        </div>
                        </form>
                    </aside>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
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
                        <?php require $themeurl.'views/socialshare.php';?>
                        <?php include $themeurl.'views/includes/copyURL.php';?>
                        <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section tour-over">
                            <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
                            <div class="clear"></div>

                            <?php echo $module->desc ;?>

                            <hr>
                        </div>
                        <div class="clear"></div>
                        <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section" style="padding-top:0px">
                            <script>
                                $("form[name=fModifySearch]").submit(function (e) {
                                    e.preventDefault();
                                    var values = {};
                                    $.each($(this).serializeArray(), function(i, field) {
                                        values[field.name] = field.value;
                                    });
                                    redirectUrl = values.city+'/'+values.hotelname+'/'+values.checkin.replace(/\//g,'-')+'/'+values.checkout.replace(/\//g,'-')+'/'+values.adults+'/'+values.child;
                                    window.location.href = '<?=base_url('hotels/detail/')?>'+redirectUrl;
                                });
                            </script>
                            <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "rentals"){ ?>
                            <!-- Start checkInInstructions -->
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
                            <!-- end checkInInstructions -->
                            <!-- Start SpecialcheckInInstructions -->
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

                             <?php if(!empty($packages)){ ?>  
                            <h3 class="heading-title"><span><?=lang('0278')?> <?=lang('0630')?></span></h3>

                            <table class="table table-striped table-hover trip_dates" id="packages">
                                <thead>
                                <tr>
                                    <th> <?=lang('0273')?> - <?=lang('0274')?> - <?=lang('0560')?></th>
                                    <th><?=lang('0275')?></th>
                                    <th class="text-center"><?=lang('080')?></th>
                                    <th class="text-center"><?=lang('0446')?></th>
                                    <th class="text-center"><?=lang('070')?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($packages as $package ) { ?>
                                    <tr>
                                        <td><i class="fa fa-calendar"></i> <?= $package->start_date ?> <?= $package->from_day ?> <strong><?=lang('0274')?></strong> <?= $package->end_date ?> <?= $package->to_day ?></td>
                                        <td><i class="fa fa-moon"></i> <?= $package->stay ?> </td>
                                        <td><p class="alert-primary btn btn-block"><?= !empty($package->status) ? lang('0252') :lang('0519') ?></p></td>
                                        <td class="text-center"><i class="fa fa-users"></i> <?= $package->travelers ?></td>
                                        <td class="text-center"><strong><?= $package->price ?></strong></td>
                                        <td><a href="#" class="btn btn-primary btn-sm btn-block" onclick="show_model('<?=$package->id?>' )"><?=lang('0477')?></a></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                                <?php } ?>
                            <!-- The Modal -->
                            <div class="modal fade" id="packages_modal">
                                <div class="modal-dialog" style="width: 60%; max-width: 100%; z-index: 9999; margin-top: 145px; padding: 15px 15px 0px 30px;">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?=lang('Viator')?> <?=lang('0145')?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action=""  id="send_enquery">
                                                <input name="password" value="" hidden >
                                                <input name="package_id" value="" id="package_id" hidden >
                                                <input type="hidden" name="itemid_package" id="itemid_package" value="<?php echo $module->id; ?>" />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <?php if($appModule != "offers"){ ?>
                                                            <div class="star-rating-wrapper">
                                                                <div class="rating-item rating-inline">
                                                                    <div class="rating-icons">
                                                                        <?php echo $module->stars;?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p><?php echo character_limiter($module->title, 28);?></p>
                                                        <?php } ?>
                                                        <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
                                                            <?php  if($item->price > 0){ ?>
                                                                <div class="price">
                                                                    <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="image"><img src="<?php echo $module->sliderImages[0]['fullImage']; ?>" alt="Images" /></div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row gap-20 mb-0">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label><?=lang('0350')?></label>
                                                                    <input type="text" name="firstname" required class="form-control" placeholder="<?=lang('0350')?>">
                                                                    <input type="hidden" name="lastname" required class="form-control" placeholder="<?=lang('0350')?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label><?=lang('094')?></label>
                                                                    <input type="text" name="email" required class="form-control" placeholder="<?=lang('094')?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row gap-20 mb-0">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label><?=lang('092')?></label>
                                                                    <input type="text" required name="phone" class="form-control" placeholder="<?=lang('092')?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label><?="Address"?></label>
                                                                    <input type="text" required name="address" class="form-control" placeholder="Address">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row gap-20 mb-0"">
                                                        <div class="col">
                                                            <button type="submit" id="ClickMyButton"  class="btn btn-success btn-lg btn-block"><?=lang('0142')?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- End SpecialcheckInInstructions -->
                        <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
                            <h3 class="heading-title"><span><?=lang('0143')?></span></h3>
                            <div class="clear"></div>
                            <div class="hotel-detail-location-wrapper">
                                <div class="row gap-30">
                                    <div class="col-12 col-md-12">
                                        <div class="map-holder">
                                            <?php  if($appModule == "rentals"){
                                                ?>
                                                <iframe id="mapframe" width="100%" height="558" style="position: static; background: #eee;" src="<?php echo base_url();?>rentals/rentalmap/<?php echo $module->id; ?>" frameborder="0"></iframe>
                                                <script>
                                                    // $('#collapseMap').on('shown.bs.collapse', function(e){
                                                    jQuery(function($) {
                                                        $("#mapframe").prop("src","<?php echo base_url();?>rentals/rentalmap/<?php echo $module->id; ?>");
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
                                        <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                            <p><?php if(!empty($module->policy)){ ?><?php echo $module->policy; } ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if(!empty($module->paymentOptions)){ ?>
                                    <div class="feature-row">
                                        <div class="row gap-10 gap-md-30">
                                            <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                                <h6><?php echo trans('0265');?></h6>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                                <p><?php foreach($module->paymentOptions as $pay){ if(!empty($pay->name)){ ?>
                                                        <?php echo $pay->name;?> -
                                                    <?php } } ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="feature-row">
                                    <div class="row gap-10 gap-md-30">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <p class="go-text-left"><i class="fa fa-sun-o text-success"></i> <strong> <?php echo trans('0275');?> </strong> :   <?php echo $module->rentalDays;?> | <i class="fa fa-moon-o text-warning"></i>   <strong> <?php echo trans('0276');?> </strong> :  <?php echo $module->rentalNights;?>  | <i class="fa fa-moon-o text-warning"></i>   <strong> <?php echo trans('0441');?> </strong> :  <?php echo $module->rentalhours;?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="">
                                <div class="clearfix"></div>
                                <!-- Start checkInInstructions -->
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
                                <!-- End checkInInstructions -->
                                <!-- Start SpecialcheckInInstructions -->
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
                                <!-- End  SpecialcheckInInstructions -->
                                <!-- Start Tours Inclusions / Exclusions -->
                                <div class="row">
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="col-md-6" id="INCLUSIONS">
                                        <h4 class="main-title float-none"><?php echo trans('0280');?></h4>
                                        <i class="tiltle-line"></i>
                                        <div class="clearfix"></div>
                                        <br>
                                        <?php foreach($module->inclusions as $inclusion){ if(!empty($inclusion->name)){  ?>
                                            <ul class="list_ok col-md-12" style="margin: 0 0 5px 0;">
                                                <li class=""><i class="fas fa-check-circle text-primary"></i>  &nbsp;&nbsp;&nbsp; <?php echo $inclusion->name; ?></li>
                                            </ul>
                                        <?php } } ?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-6" id="EXCLUSIONS">
                                        <h4 class="main-title float-none"><?php echo trans('0281');?></h4>
                                        <div class="clear"></div>
                                        <i class="tiltle-line"></i>

                                        <br>
                                        <?php foreach($module->exclusions as $exclusion){ if(!empty($exclusion->name)){  ?>
                                            <ul class="col-md-12" style="margin: 0 0 5px 0;list-style:none;">
                                                <li class=""><i class="fas fa-times-circle text-primary"></i> &nbsp;&nbsp;&nbsp; <?php echo $exclusion->name; ?> &nbsp;&nbsp;&nbsp;</li>
                                            </ul>
                                        <?php } } ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    </section>
                    <script>
                        $("[name^=rooms").on('click', function() {
                            if ($('[name="rooms[]"]:checked').length > 0) {
                                $('[type=submit]').prop('disabled', false);
                            } else {
                                $('[type=submit]').prop('disabled', true);
                            }
                        });
                    </script>
                    <!------------------------  Related Listings   ------------------------------>
                    <div id="detail-content-sticky-nav-06" class="fullwidth-horizon-sticky-section">
                        <div class="container hidden-xs">

                            <div class="clearfix"></div>
                            <div class="clearfix"></div>

                            <?php require $themeurl.'views/includes/reviews.php';?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- End Hotel Reviews bars -->
                    <!-- End Add/Remove Wish list Review Section -->
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-md-12 form-group">
                            <?php if($appModule != "cars" && $appModule != "ean" && $appModule != "offers" ){ ?>
                                <button  data-toggle="collapse"  type="button" class="writeReview btn btn-primary btn-block mb-10" sdata-target="#ADDREVIEW" href="#ADDREVIEW" aria-controls="#ADDREVIEW"><i class="icon_set_1_icon-68"></i> <?php echo trans('083');?></button>
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
                                                        <button type="submit" class="btn btn-primary btn-block btn-lg addreview" id="<?php echo $module->id; ?>" ><?php echo trans('086');?></button>
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
</div>
<div class="fullwidth-horizon-sticky border-0">&#032;</div>
<!-- is used to stop the above stick menu -->
</div>
</div>
<?php if(!empty($module->relatedItems)){ ?>
    <section class="bg-white section-sm">
        <div class="container">
            <div class="section-title mb-25">
                <h3><?= trans('0637'); ?></h3>
                <div class="clear"></div>
            </div>
            <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
                <?php foreach($module->relatedItems as $item){ ?>
                    <div class="col">
                        <div class="product-grid-item">
                            <a href="<?php echo $item->slug;?>">
                                <div class="image">
                                    <img src="<?php echo $item->thumbnail;?>" alt="Image">
                                </div>
                                <div class="content clearfix">
                                    <div class="rating-item rating-sm go-text-right">
                                        <div class="rating-icons">
                                            <?php echo $item->stars;?>
                                        </div>
                                        <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
                                    </div>
                                    <div class="short-info">
                                        <h5 class="RTL"><?php echo character_limiter($item->title,25);?></h5>
                                        <div class="clear"></div>
                                        <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo character_limiter($item->location,20);?></p>

                                        <?php if($item->price > 0){ ?>
                                        <div class="mt-10">
                                            <?php echo trans( '0368');?>
                                            <span class="text-secondary"><strong><?php echo $item->currSymbol; ?><?php echo $item->price;?></strong></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
</div>

<input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
<input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
<input type="hidden" id="module" value="<?php echo $appModule;?>" />
<input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
<input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />

<script>

    function show_model(package_id){
        var package = getPackage(package_id,JSON.parse('<?=json_encode($packages)?>'));
        $("#packages_modal").modal('show');
        $("#package_id").val(package_id)
    }
    function getPackage(id,array){
        for (var i = 0; i<array.length;i++){
            if(array[i].id == id){
                return array[i];
            }
        }
    }

    $(".changeInfo").on("change",function(){
        var tourid = "<?php echo $module->id; ?>";
        var adults = $("#selectedAdults").val();
        var child = $("#selectedChild").val();
        var infants = $("#selectedInfants").val();
        $.post("<?php echo base_url()?>rentals/rentalajaxcalls/changeInfo",{rentalid: tourid, adults: adults, child: child, infants: infants},function(resp){
            var result = $.parseJSON(resp);
            $(".adultPrice").html(result.currSymbol+result.adultPrice);
            $(".childPrice").html(result.currSymbol+result.childPrice);
            $(".infantPrice").html(result.currSymbol+result.infantPrice);
            $(".totalCost").html(result.currCode+" "+result.currSymbol+result.totalCost);
            $(".totaldeposit").html(result.currCode+" "+result.currSymbol+result.totalDeposit);
            console.log(result);
        })
    }); //end of change info

    //------------------------------
    // Write Reviews
    //------------------------------

    $('.reviewscore').change(function(){
        var sum = 0;
        var avg = 0;
        var id = $(this).attr("id");
        $('.reviewscore_'+id+' :selected').each(function() {
            sum += Number($(this).val());
        });
        avg = sum/5;
        $("#avgall_"+id).html(avg);
        $("#overall_"+id).val(avg);
    });

    //submit review
    $(".addreview").on("click",function(){
        var id = $(this).prop("id");
        $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-"+id).serialize(), function(resp){
            var response = $.parseJSON(resp);
            // alert(response.msg);
            $("#review_result"+id).html("<div class='alert "+response.divclass+"'>"+response.msg+"</div>").fadeIn("slow");
            if(response.divclass == "alert-success"){
                setTimeout(function(){
                    $("#ADDREVIEW").removeClass('in');
                    $("#ADDREVIEW").slideUp();
                }, 5000);
            }
        });
        setTimeout(function(){
            $("#review_result"+id).fadeOut("slow");
        }, 3000);
    });

    $("#send_enquery").submit(function (e) {
        e.preventDefault();
        $("#ClickMyButton").attr("disabled", true);
        $.ajax({
            url: '<?=base_url('rentals/do_rentals_guest_booking')?>',
            type: 'post',
            data: $('#send_enquery').serialize(),
            success: function(data) {
                console.log(data)
                window.location.href = data+"";
            }
        });
    });

    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
    //------------------------------
    // Add to Wishlist
    //------------------------------
    $(function(){
        // Add/remove wishlist
        $(".wish").on('click',function(){
            var loggedin = $("#loggedin").val();
            var removelisttxt = $("#removetxt").val();
            var addlisttxt = $("#addtxt").val();
            var title = $("#itemid").val();
            var module = $("#module").val();
            if(loggedin > 0){ if($(this).hasClass('addwishlist')){
                var confirm1 = confirm("<?php echo trans('0437');?>");
                if(confirm1){
                    $(".wish").removeClass('addwishlist btn-primary');
                    $(".wish").addClass('removewishlist btn-warning');
                    $(".wishtext").html(removelisttxt);
                    $.post("<?php echo base_url();?>account/wishlist/add", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){ });
                }
                return false;
            }else if($(this).hasClass('removewishlist')){
                var confirm2 = confirm("<?php echo trans('0436');?>");
                if(confirm2){
                    $(".wish").addClass('addwishlist btn-primary'); $(".wish").removeClass('removewishlist btn-warning');
                    $(".wishtext").html(addlisttxt);
                    $.post("<?php echo base_url();?>account/wishlist/remove", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){
                    });
                }
                return false;
            } }else{ alert("<?php echo trans('0482');?>"); } });
        // End Add/remove wishlist
    })
</script>