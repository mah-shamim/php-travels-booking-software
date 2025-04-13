<style>
  .summary  { border-right: solid 2px rgb(0, 93, 247); color: #ffffff; background: #4285f4; padding: 14px; float: left; font-size: 14px; }
  .sideline { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; display: table-cell; border-left: solid 1px #e7e7e7; }
  .localarea { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; }
  .captext  { display: block; font-size: 14px; font-weight: 400; color: #23527c; line-height: 1.2em; text-transform: capitalize; }
  .ellipsis { max-width: 250px; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; }
  .noResults { right: 30px; top: 26px; color: #008cff; font-size: 16px; }
  .table { margin-bottom: 5px; }
</style>

<?php if($ismobile): ?>
<div class="modal <?php if($isRTL == "RTL"){ ?> right <?php } else { ?> left <?php } ?> fade" id="sidebar_filter" tabindex="1" role="dialog" aria-labelledby="sidebar_filter">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close go-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="close icon-angle-<?php if($isRTL == "RTL"){ ?>right<?php } else { ?>left<?php } ?>"></i></span></button>
        <h4 class="modal-title go-text-right" id="sidebar_filter"><i class="icon_set_1_icon-65 go-right"></i> <?php echo trans('0191');?></h4>
      </div>
      <?php require $themeurl.'views/includes/filter.php';?>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="search_head">
  <div class="container">
    <br>
    <?php include $themeurl.'views/modules/travelport/hotel/search_form.php' ?>
    <div class="clearfix"></div>
    </div>
    </div>

<div class="header-mob">
  <div class="container">
    <div class="row">
      <div class="col-xs-2 text-leftt">
        <a data-toggle="tooltip" data-placement="right" title="<?php echo trans('0533');?>" class="icon-angle-left pull-left mob-back" onclick="goBack()"></a>
      </div>
      <div class="col-xs-7 p5">
        <div class="mob-trip-info-head ttu">
          <span><?php echo $searchText; ?></span>
          <div><?php echo $checkinDate; ?>  --  <?php echo $checkoutDate; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mob-alert-msg go-text-right">
  <div class="container">
    <div class="row">
      <div class="col-md-6 fs12">
        <i class="icon-info-circled-alt go-right"></i>
        <span><?php echo trans('0534');?></span>
        </div>
      <div class="col-md-6 text-right hidden-xs">
        <strong class="go-text-right"><?php echo count($hotels->HotelSearchResult); ?></strong>
        <span  class="go-text-left"><?php echo trans('0535');?></span>
        </div>
    </div>
  </div>
</div>
<div class="collapse listing-search-BG" id="modify">
  <div class="container">
    <div class="panel-body">
      <?php echo searchForm($appModule); ?>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<div style="margin-top:-15px" class="collapse" id="collapseMap">
  <div id="map" class="map"></div>
  <br>
</div>
<div class="container offset-0">

  <div class="clearfix"></div>
  <?php if(!$ismobile): ?>
    <div class="col-md-3 hidden-sm hidden-xs" style="background: #f2f2f2;padding-bottom:15px">
      <!-- FILTERS -->
      <form action="<?php echo base_url('hotelport/search/filter'); ?>" method="GET" role="search">
        <div style="padding:10px 10px 10px 10px">
            <div class="textline">
                <span class="filterstext"><span><i class="icon_set_1_icon-95"></i>Filter Search</span></span>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Facilities -->
        <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse3">
          Facilities <span class="collapsearrow"></span>
        </button>
        <div id="collapse3" class="collapse in">
            <div class="scroll-400">
                <div class="hpadding20">
                    <br>
                    <?php foreach($facilities as $facilitie): ?>
                    <div class="go-right">
                      <?php if(isset($_GET['facilities'])): ?>
                      <?php foreach($_GET['facilities'] as $type => $code): ?>
                      <?php if($facilitie->facilityGroupCode == $type && in_array($facilitie->code, $code)): ?>
                      <input type="checkbox" checked name="facilities[<?=$facilitie->facilityGroupCode?>][]" value="<?=$facilitie->code?>" class="checkbox go-right" />
                      <?php else: ?>
                      <input type="checkbox" name="facilities[<?=$facilitie->facilityGroupCode?>][]" value="<?=$facilitie->code?>" class="checkbox go-right" />
                      <?php endif; ?>
                      <?php endforeach; ?>
                      <?php else: ?>
                      <input type="checkbox" name="facilities[<?=$facilitie->facilityGroupCode?>][]" value="<?=$facilitie->code?>" class="checkbox go-right" />
                      <?php endif; ?>
                      <label for="all" class="css-label go-left"><?=$facilitie->description?></label>
                    </div><div class="clearfix"></div>
                    <?php endforeach; ?>
                    <br>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- End of Facilities -->
        <!-- Accommodations -->
        <!-- <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse3">
            Accommodations <span class="collapsearrow"></span>
        </button>
        <div id="collapse3" class="collapse in">
            <div class="scroll-400">
                <div class="hpadding20">
                    <br>
                    <?php foreach($accommodations as $accommodation): ?>
                        <div class="go-right">
                            <input type="checkbox" name="accommodation[]" value="<?=$accommodation->code?>" class="checkbox go-right"/>
                            <label for="all" class="css-label go-left"><?=$accommodation->description?></label>
                        </div><div class="clearfix"></div>
                    <?php endforeach; ?>
                    <br>
                </div>
            </div>
            <div class="clearfix"></div>
        </div> -->
        <!-- End of Accommodations -->
        <div class="clearfix"></div>
        <br>
          <!-- <input type="text" name="checkin" value="<?=$input->checkin?>">
          <input type="text" name="checkout" value="<?=$input->checkout?>">
          <input type="text" name="adult" value="<?=$input->adult?>">
          <input type="text" name="children" value="<?=$input->children?>">
          <input type="text" name="destination" value="<?=$input->destination?>"> -->
          <button style="border-radius:0px;margin-bottom:0px;" type="submit" class="btn btn-action btn-lg btn-block loader" id="searchform">Search</button>
      </form>
    </div>
  <?php endif; ?>

  <div class="col-md-9 col-xs-12">
    <div class="itemscontainer">
      <?php if(isset($hotels->HotelSearchResult) && ! empty($hotels->HotelSearchResult)): ?>
      <?php foreach($hotels->HotelSearchResult as $hotel): ?>
      <?php 
        if($hotel->VendorLocation->ProviderCode == '1G') {
          // Galelio Provider
          $amount = $hotel->RateInfo->ApproximateMinimumAmount;
          if(empty($amount)) {
            $amount = $hotel->RateInfo->MinimumAmount;
          }
          $description = 'N/A';
          $image = "https://demo.travelportuniversalapi.com/Content/img/hotel/{$hotel->HotelProperty->HotelChain}.gif";
          $PropertyAddress = $hotel->HotelProperty->PropertyAddress->Address;
          $RateSupplier = ''; // N/A
          $HostToken = '';
        } else {
          // TRM Provider
          $amount = $hotel->RateInfo->ApproximateMinimumStayAmount;
          $description = $hotel->PropertyDescription->_;
          $image = $hotel->MediaItem->url;
          $PropertyAddress = $hotel->HotelProperty->PropertyAddress->Address;
          $PropertyAddress = implode(', ', $PropertyAddress);
          $RateSupplier = $hotel->RateInfo->RateSupplier;
          $HostToken = $hotels->HostToken->_;
        }
      ?>
      <form id="detailForm" action="<?=base_url('hotelport/detail/'.rawurlencode(create_url_slug(strtolower($hotel->HotelProperty->Name))))?>" method="post">
      <table class="bgwhite table table-striped" id="hotel-<?=$hotel->HotelProperty->HotelCode?>">
      <tr>
        <td class="wow fadeIn p-10-0">
          <div class="col-md-4 col-xs-5 go-right rtl_pic">
            <div class="img_list">
              <a href="#" onclick="document.getElementById('detailForm').submit()">
                <img src="<?=$image?>" class="center-block loader" alt="<?= $hotel->HotelProperty->Name ?>">
                <div class="short_info"></div>
              </a>
            </div>
          </div>
          <div class="col-md-8 col-xs-7 g0-left">
            <div class="row">
              <h4 class="RTL go-text-right mt0 list_title">
                  <a href="#" onclick="document.getElementById('detailForm').submit()"><b><?= $hotel->HotelProperty->Name ?></b>
                  <span class="fs18 text-left go-text-right go-right pull-right">
                    <span class="col-md-12"><?= $amount ?></span>
                  </span>
                  </a>
                  <p style="margin-top: 12px;font-size: 14px;font-weight: bold;font-style: italic;">
                    <?=$PropertyAddress?>
                  </p>
              </h4>
              <p style="margin: 7px 0px 7px 0px;" class="grey RTL fs12 hidden-xs"><?=(strlen($description)>300)?substr($description, 0, 300).'...':$description?></p>
              <div class="hidden-xs">
                <div class="mt15"></div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-4 col-xs-6 col-sm-4 go-right">
                <div class="row">

                </div>
              </div>
              <div class="col-md-4 col-xs-4 col-sm-4 hidden-xs go-right">
                <!-- <div class="review text-center size18 hidden-xs"><i class="icon-thumbs-up-4"></i>3 / 5</div> -->
              </div>
              <div class="col-md-4 col-xs-6 col-sm-4 go-left">
                <input type="hidden" name="hotelCode" value="<?=$hotel->HotelProperty->HotelCode?>"/>
                <input type="hidden" name="hotelChain" value="<?=$hotel->HotelProperty->HotelChain?>"/>
                <input type="hidden" name="RateSupplier" value="<?= $RateSupplier ?>"/>
                <input type="hidden" name="HostToken" value="<?= $HostToken ?>"/>
                <input type="hidden" name="adults" value="<?= $adults ?>"/>
                <input type="hidden" name="checkinDate" value="<?= $checkinDate ?>"/>
                <input type="hidden" name="checkoutDate" value="<?= $checkoutDate ?>"/>
                <button class="btn btn-action loader loader btn-block" type="submit">
                  <?php echo trans('0177');?>
                </button>
                </a>
              </div>
            </div>
          </div>
        </td>
      </tr>
      </table>
      </form>
      <div class="clearfix"></div>
      <?php endforeach; ?>
      <?php endif; ?>
      
      <div class="clearfix"></div>
    </div>
    <!-- END OF LIST CONTENT-->
  </div>
  <!-- END OF container-->
</div>
<!-- END OF CONTENT -->

<script>
  function hotelDetail(hotel) {
    alert(hotel);
    return false;
  }
</script>