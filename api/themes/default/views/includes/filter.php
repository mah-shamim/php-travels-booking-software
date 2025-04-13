<?php if($appModule == "offers"){ ?>
<?php echo run_widget(63); ?>
<?php }else{ ?>
<?php if($appModule == "ean"){ ?>
<aside class="sticky-kit sidebar-wrapper mb-10 mb-md-0">
  <div class="box-expand-lg">
    <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
      <div class="wrapper-inner">
        <div class="sidebar-title bg-primary">
          <div class="d-flex align-items-end">
            <div>
              <h4 class="text-white font-serif font400 go-right"><?=lang('0191')?></h4>
              <div class="clear"></div>
            </div>
          </div>
        </div>
        <form id="filter" action="<?php echo $baseUrl;?>search" method="GET" >
          <div class="sidebar-box">
            <div class="box-title">
              <h5><?php echo trans('0137');?> <?php echo trans('069');?></h5>
              <div class="clear"></div>
            </div>
            <div class="box-content">
              <div class="rating-item rating-sm rating-inline rotX">
                <div class="rating-icons go-right">
                  <?php $star = '<span class="rating-icon fas fa-star rating-rated"></span>'; ?>
                  <?php $stars = '<div class="rating-symbol-background rating-icon far fa-star"></div>'; ?>
                  <div class="custom-control custom-radio">
                    <div class="mb-5">
                      <input id="1" type="radio" name="stars" class="custom-control-input stars" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                      <label class="custom-control-label" for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                      <div class="clear"></div>
                    </div>
                    <div class="mb-5">
                      <input id="2" type="radio" name="stars" class="custom-control-input stars" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                      <label class="custom-control-label " for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                      <div class="clear"></div>
                    </div>
                    <div class="mb-5">
                      <input id="3" type="radio" name="stars" class="custom-control-input stars" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                      <label class="custom-control-label " for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                      <div class="clear"></div>
                    </div>
                    <div class="mb-5">
                      <input id="4" type="radio" name="stars" class="custom-control-input stars" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                      <label class="custom-control-label" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                      <div class="clear"></div>
                    </div>
                    <div class="mb-5">
                      <input id="5" type="radio" name="stars" class="custom-control-input stars" value="5" <?php if($starsCount == "5"){echo "checked";}?>>
                      <label class="custom-control-label " for="5">&nbsp; <?php for($i=1;$i<=5;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=0;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
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
              <input id="price_range" />
              <?php if(!empty($_GET['price'])){
                $selectedprice = $_GET['price'];
                }else{
                $selectedprice =  $minprice.",".$maxprice;
                }?>
            </div>
          </div>
          <!-- End of Hotel Amenities -->
          <!-- Module types -->
          <div class="sidebar-box">
            <div class="box-title">
              <h5><?php if($appModule == "hotels"){ echo trans('0478'); }else if($appModule == "ean"){ echo trans('0478'); }else if($appModule == "tours"){ echo trans('0366'); }else if($appModule == "cars"){ echo trans('0214'); } ?></h5>
              <div class="clear"></div>
            </div>
            <div class="box-content">
              <div class="custom-control custom-checkbox ">
                <input type="checkbox" name="propertyCategory[]" value="6" id="all" class="custom-control-input" <?php if(in_array("6", $propertyCategory)){ echo "checked"; } ?> />
                <label for="all" class="custom-control-label"><?php echo trans('0467');?></label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <div class="custom-control custom-checkbox "><input type="checkbox" name="propertyCategory[]" value="1" id="hotel" class="custom-control-input" <?php if(in_array("1", $propertyCategory)){ echo "checked"; } ?> />
                <label for="hotel" class="custom-control-label"> <?php echo trans('01');?></label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <div class="custom-control custom-checkbox ">
                <input type="checkbox" name="propertyCategory[]" value="2" id="suite" class="custom-control-input" <?php if(in_array("2", $propertyCategory)){ echo "checked"; } ?> />
                <label for="suite" class="custom-control-label"> <?php echo trans('0468');?> </label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <div class="custom-control custom-checkbox ">
                <input type="checkbox" name="propertyCategory[]" value="3" id="resort" class="custom-control-input" <?php if(in_array("3", $propertyCategory)){ echo "checked"; } ?> />
                <label for="resort" class="custom-control-label"><?php echo trans('0469');?></label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <div class="custom-control custom-checkbox ">
                <input type="checkbox" name="propertyCategory[]" value="4" id="vacation" class="custom-control-input" <?php if(in_array("4", $propertyCategory)){ echo "checked"; } ?> />
                <label for="vacation" class="custom-control-label"> <?php echo trans('0470');?>  </label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <div class="custom-control custom-checkbox ">
                <input type="checkbox" name="propertyCategory[]" value="5" id="bed" class="custom-control-input" <?php if(in_array("5", $propertyCategory)){ echo "checked"; } ?> />
                <label for="bed" class="custom-control-label"><?php echo trans('0471');?></label>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
              <br>
            </div>
            <div class="clear"></div>
          </div>
          <!-- End of Module Types -->
          <!-- End of Concept Filters -->
          <?php if(!empty($propertyAmenities)){ ?>
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
                foreach($propertyAmenities as $in=> $pa){
                    if (in_array($pa->name, $conceptFilters)) { continue; }
                    ?>
              <?php if ($in==4)  {   ?>
              <div id="filerPropertyTypeShowHide" class="collapse">
                <div class="collapse-inner">
                  <?php  }  ?>
                  <div class="">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" id="pa<?php echo $pa->id;?>" name="amenities[]" value="<?php echo $ra->id;?>" type="checkbox">
                      <label class="custom-control-label" for="pa<?php echo $pa->id;?>"><?php echo character_limiter($pa->name,20); ?>
                      </label>
                      <div class="clear"></div>

                    </div>
                  </div>
                  <?php } ?>
                  <?php if (count($propertyAmenities)>4 )   { ?>
                </div>
              </div>
              <?php } ?>
              <div class="clear mb-5"></div>
              <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('0185')?> (+)</span>
              <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('067')?> (-)</span>
            </div>
          </div>
          <?php } ?>
            <input type="hidden" name="city" id="city" value="<?php if(!empty($_GET['city'])){ echo $_GET['city']; }else{ echo 'united-arab-emirates/dubai'; } ?>">
            <input type="hidden" name="checkIn" id="checkIn" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkOut" id="checkOut" value="<?php echo $outcheck; ?>">
            <input type="hidden" name="childages" id="childages" value="<?php echo $childAges; ?>">
            <input type="hidden" name="adults" id="adults" value="<?php echo $adults; ?>">
            <input type="hidden" name="search" value="1">
          <div class="sidebar-box">
            <div class="box-content">
              <button type="submit" class="btn btn-primary btn-block" id="searchform"><?php echo trans('012');?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="d-block d-lg-none">
    <button type="button" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile"><?=lang('0191')?></button>
  </div>
</aside>
<?php } } ?>
<script>
    $("#filter").submit(function(e){
        e.preventDefault();
        var stars= $(".stars:checked").val();
        var checkIn= $("#checkIn").val();
        var checkOut= $("#checkOut").val();
        var child = 0;
        var adults= $("#adults").val();
        var city= $("#city").val();
        var endpoint = $(this).attr("action");
        var new_url = endpoint+"/"+city+"/"+checkIn+"/"+checkOut+"/"+adults+"/"+child+"/"+stars;
        window.location.href = new_url;
    });
</script>
