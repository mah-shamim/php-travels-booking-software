<div class="clearfix"></div>
<input type="hidden" name="moreResultsAvailable" id="moreResultsAvailable" value="<?php echo $moreResultsAvailable; ?>" />
<input type="hidden" name="cacheKey" id="cacheKey" value="<?php echo $cacheKey; ?>" />
<input type="hidden" name="cacheLocation" id="cacheLocation" value="<?php echo $cacheLocation; ?>" />
<input type="hidden" name="" id="agesappendurl" value="<?php echo $agesApendUrl; ?>" />
<div class="product-long-item-wrapper">
    <?php if(!empty($module)){ foreach($module as $item){ ?>
      <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink">
                    <div class="image">
                    <a href="<?php echo $item->slug;?>">
                    
                         <img src="<?php echo $item->thumbnail;?>" alt="images" />
                        </a>
                    </div>
                  </div>
                  <div class="col-12 col-auto">
                    <div class="col-inner d-flex flex-column">
                      <div class="content-top">
                        <div class="d-flex">
                          <div>
                            <div class="rating-item rating-sm rating-inline">
                              <div class="rating-icons">
                                 <?php echo $item->stars;?>
                              </div>
                              
                            </div>
                            <h5><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,20);?></a></h5>
                            <p class="location"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo character_limiter($item->location,10);?></p>
                            
                          </div>
                          <div class="ml-auto">
                            <?php  if($item->price > 0){ ?>
                            <div class="price">
                              <?=lang('0218')?> <?=lang('0273')?>
                              <span class="text-secondary">
                              <?php echo $currCode;?><?php echo currencyConverter($item->price);?>
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
              
    <?php } } ?>
</div>
