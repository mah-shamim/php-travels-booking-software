<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
        <div id="change-search" class="collapse">
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
      <div class="row gap-20 gap-md-30 gap-xl-40">
        <div class="col-12 col-lg-3">
          <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
          <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
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
                  <div class="sidebar-box">
                    <div class="box-title">
                      <h5><?php echo trans('0137');?> <?php echo trans('069');?></h5>
                    </div>
                    <div class="box-content">
                      <div class="rating-item rating-sm rating-inline">
                        <div class="rating-icons">
                          <?php $star = '<span class="rating-icon fas fa-star rating-rated"></span>'; ?>
                          <?php $stars = '<div class="rating-symbol-background rating-icon far fa-star"></div>'; ?>
                          <div class="custom-control custom-radio">
                            <div class="go-right" style="margin-bottom:5px">
                              <input id="1" type="radio" name="stars" class="custom-control-input go-right" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                              <label class="custom-control-label go-left" for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                            </div>
                            <div class="go-right" style="margin-bottom:5px">
                              <input id="2" type="radio" name="stars" class="custom-control-input go-right" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                              <label class="custom-control-label go-left" for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                            </div>
                            <div class="go-right" style="margin-bottom:5px">
                              <input id="3" type="radio" name="stars" class="custom-control-input" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                              <label class="custom-control-label go-left" for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                            </div>
                            <div class="go-right" style="margin-bottom:5px">
                              <input id="4" type="radio" name="stars" class="custom-control-input" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                              <label class="custom-control-label go-left" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                            </div>
                            <div class="go-right" style="margin-bottom:5px">
                              <input id="5" type="radio" name="stars" class="custom-control-input" value="5" <?php if($starsCount == "5"){echo "checked";}?>>
                              <label class="custom-control-label go-left" for="5">&nbsp; <?php for($i=1;$i<=5;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=0;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="sidebar-box">
                    <div class="box-title">
                      <h5><?php echo trans('0301');?></h5>
                    </div>
                    <div class="box-content">
                      <input id="price_range" />
                      <?php if(!empty($priceRange)){
                        $selectedprice = str_replace('-',',', $priceRange);
                        }else{
                        $selectedprice =  $minprice.",".$maxprice;
                        }?>
                      <!--<input type="text" class="col-md-12" value="" data-slider-min="<?=$minprice?>" data-slider-max="<?=$maxprice?> " data-slider-step="10" data-slider-value="[<?=$selectedprice?>]" id="sl2" name="price">-->
                    </div>
                  </div>
                  <!-- End of Price range -->
                  <!-- <div class="sidebar-box">
                    <div class="box-title"><h5>Price range</h5></div>
                    
                    <div class="box-content">
                      <input id="price_range" />
                    </div>
                    
                    </div>-->
                  <!-- <div class="sidebar-box">
                    <div class="box-title"><h5>Star range</h5></div>
                    
                    <div class="box-content">
                      <input id="star_range" />
                    </div>
                    
                    </div>  -->
                  <div class="sidebar-box">
                    <div class="box-title">
                      <h5>Boats Type</h5>
                    </div>
                    <div class="box-content">
                      <div class="clearfix"></div>
                      <?php @$vartype = $_GET['type'];
                        if(empty($vartype)){
                        $vartype = array();
                        }
                        foreach($moduleTypes as $mtype){
                        if(!empty($mtype->name)){
                        if($appModule == "hotels"){
                        ?>
                      <div class="custom-control custom-checkbox"> <input type="checkbox" value="<?php echo $mtype->id;?>" <?php if(in_array($mtype->id,$vartype)){echo "checked";}?> name="type[]" id="<?php echo $mtype->name;?>" class="custom-control-input" /> <label for="<?php echo $mtype->name;?>" class="custom-control-label">&nbsp;&nbsp;<?php echo $mtype->name;?></label></div>
                      <div class="clearfix"></div>
                      <?php }else if($appModule == "boats" || $appModule == "cars"){ ?>
                      <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" value="<?php echo $mtype->id;?>" name="type" id="<?php echo $mtype->name;?>" class="checkbox go-right" <?php if($mtype->id == $vartype){echo "checked";}?> /><label for="<?php echo $mtype->name;?>" class="custom-control-label"> &nbsp;&nbsp; <?php echo $mtype->name;?> &nbsp;&nbsp;</label></div>
                      <div class="clearfix"></div>
                      <?php } } } ?>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <input type="hidden" name="txtSearch" value="<?php echo @$_GET['txtSearch']; ?>">
                  <input type="hidden" name="searching" value="<?php echo @$_GET['searching']; ?>">
                  <input type="hidden" name="modType" value="<?php echo @$_GET['modType']; ?>">
                  <div class="sidebar-box">
                    <div class="box-content">
                      <button type="submit" class="btn btn-primary btn-block" id="searchform"><?php echo trans('012');?></button>
                    </div>
                  </div>
                  <!-- <div class="sidebar-box">
                    <div class="box-title"><h5>Tour Type</h5></div>
                    
                    <div class="box-content">
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerTourType-01" name="filerTourType" checked>
                        <label class="custom-control-label" for="filerTourType-01">Beaches &amp; Islands <small class="text-muted font11">(854)</small></label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerTourType-02" name="filerTourType" >
                        <label class="custom-control-label" for="filerTourType-02">Family Travel <small class="text-muted font11">(25)</small></label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerTourType-03" name="filerTourType" >
                        <label class="custom-control-label" for="filerTourType-03">Food Travel <small class="text-muted font11">(254)</small></label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerTourType-04" name="filerTourType" >
                        <label class="custom-control-label" for="filerTourType-04">Adventure <small class="text-muted font11">(22)</small></label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerTourType-05" name="filerTourType" >
                        <label class="custom-control-label" for="filerTourType-05">Romantic Vacations <small class="text-muted font11">(24)</small></label>
                      </div>
                      
                      <div id="filerTourTypeShowHide" class="collapse"> 
                      
                        <div class="collapse-inner">
                        
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerTourType-06" name="filerTourType" >
                            <label class="custom-control-label" for="filerTourType-06">Road Trips <small class="text-muted font11">(25)</small></label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerTourType-07" name="filerTourType">
                            <label class="custom-control-label" for="filerTourType-07">Weird &amp; Amazing <small class="text-muted font11">(14)</small></label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerTourType-08" name="filerTourType" >
                            <label class="custom-control-label" for="filerTourType-08">Spas <small class="text-muted font11">(8)</small></label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerTourType-09" name="filerTourType" >
                            <label class="custom-control-label" for="filerTourType-09">Arts &amp; Culture <small class="text-muted font11">(2)</small></label>
                          </div>
                          
                        </div>
                        
                      </div>
                      
                      <div class="clear mb-5"></div>
                      
                      <button class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on" type="buttom" data-toggle="collapse" data-target="#filerTourTypeShowHide">Show more (+)</button>
                      
                      <button class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off" type="buttom" data-toggle="collapse" data-target="#filerTourTypeShowHide">Show less (-)</button>
                      
                      
                    </div>
                    
                    </div> -->
                  <!--<div class="sidebar-box">
                    <div class="box-title"><h5>Starting point</h5></div>
                    
                    <div class="box-content">
                    
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerStartPoint-01" name="filerStartPoint" checked>
                        <label class="custom-control-label" for="filerStartPoint-01">Berlin</label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerStartPoint-02" name="filerStartPoint" >
                        <label class="custom-control-label" for="filerStartPoint-02">Paris</label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerStartPoint-03" name="filerStartPoint" >
                        <label class="custom-control-label" for="filerStartPoint-03">Munich</label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerStartPoint-04" name="filerStartPoint" >
                        <label class="custom-control-label" for="filerStartPoint-04">Lyon</label>
                      </div>
                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="filerStartPoint-05" name="filerStartPoint" >
                        <label class="custom-control-label" for="filerStartPoint-05">Vienna</label>
                      </div>
                      
                      <div id="filerStartPointShowHide" class="collapse"> 
                      
                        <div class="collapse-inner">
                        
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerStartPoint-06" name="filerStartPoint" >
                            <label class="custom-control-label" for="filerStartPoint-06">Toulouse</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerStartPoint-07" name="filerStartPoint">
                            <label class="custom-control-label" for="filerStartPoint-07">Graz</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerStartPoint-08" name="filerStartPoint" >
                            <label class="custom-control-label" for="filerStartPoint-08">Linz</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="filerStartPoint-09" name="filerStartPoint" >
                            <label class="custom-control-label" for="filerStartPoint-09">Florence</label>
                          </div>
                          
                        </div>
                        
                      </div>
                      
                      <div class="clear mb-5"></div>
                      
                      <button class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on" type="buttom" data-toggle="collapse" data-target="#filerStartPointShowHide">Show more (+)</button>
                      
                      <button class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off" type="buttom" data-toggle="collapse" data-target="#filerStartPointShowHide">Show less (-)</button>
                      
                    </div>
                    
                    </div> -->
                  <!--<div class="sidebar-box">
                    <div class="box-title"><h5>Filer Select</h5></div>
                    
                    <div class="box-content">
                      <div class="form-group">
                      <select  data-placeholder="Please select" class="chosen-the-basic form-control" tabindex="2">
                        <option value=""></option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                    </div>
                    
                    </div>
                    
                    <div class="sidebar-box">
                    
                    <div class="box-title"><h5>Filer Text</h5></div>
                    
                    <div class="box-content">
                      <p class="line-15">Park fat she nor does play deal our. Procured sex material his offering humanity laughing moderate can.</p>
                    </div>
                    
                    </div> -->
                </div>
              </div>
            </div>
            <!-- <div class="featured-contact-01 mt-40 mb-30 d-none d-md-block">
              <h6>Need help? Call us on</h6>
              <span class="phone-number"><i class="material-icons">phone</i> 1985 5524 145</span>
              It's free to call from anywhere
              </div>
              
              <div class=" d-none d-lg-block">
              
              <h6 class="text-uppercase letter-spacing-2 line-1 font500"><span>Why Book With Travel Material</span></h6>
              
              <ul class="list-icon-data-attr font-ionicons">
                <li data-content="&#xf383">Excited him now natural saw passage age explain.</li>
                <li data-content="&#xf383">Farther so friends is detract do private.</li>
                <li data-content="&#xf383">Procured is material his offering humanity laughing moderate can.</li>
              </ul>
              
              </div>
              
              <div class="d-block d-lg-none">
              <button type="buttom" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile">Show Filter</button>   
              </div> -->
              </form>
          </aside>
        </div>
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="d-lg-flex mb-30">
              <div>
                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                <h3 class="heading-title"><span><?=lang('0630')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                <?php } ?>
                <p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p>
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
              </div>
            </div>

            <!-- <div class="sorting-box mb-30">
              <div class="row align-items-center">
              
                <div class="col-12 col-md-9">
                  <div class="sort-by-wrapper mb-10 mb-md-0">
                    <label class="sorting-label block-xs">Sort by: </label> 
                    <div class="sorting-middle-holder">
                      <ul class="sort-by">
                        <li class="active up"><a href="#">Name <i class="fas fa-long-arrow-alt-down"></i></a></li>
                        <li><a href="#">Price</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="#">Start Rating</a></li>
                        <li><a href="#">User Rating</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                
                <div class="col-12 col-md-3">
                  <div class="sort-by-wrapper float-left float-md-right">
                    <label class="sorting-label">View as: </label> 
                    <div class="sorting-middle-holder">
                      <a href="#" class="btn btn-sorting active"><i class="dripicons-checklist"></i></a>
                      <a href="#" class="btn btn-sorting"><i class="dripicons-view-thumb"></i></a>
                    </div>
                  </div>
                </div>
                
              </div>
              
              </div> -->
            <div class="product-long-item-wrapper">
              <?php if(!empty($module)){ ?>
              <?php if($appModule != "offers"){ ?>
              <?php foreach($module as $item){ ?>
              <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink">
                   <?php if(!empty($item->discount)){?><span class="discount"><?=$item->discount?> % <?=lang('0118')?></span> <?php } ?>
                    <div class="image">
                      <a href="<?php echo $item->slug;?>">
                      <img src="<?php echo $item->thumbnail;?>" alt="<?php echo character_limiter($item->title,20);?>" />
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
                                <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="4.0"/>
                              </div>
                              <!--<p class="rating-text text-muted"><span class="font13">- (93 reviews</span></p>-->
                            </div>
                            <h5><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,20);?></a></h5>
                            <p class="location"><i class="fas fa-map-marker-alt "></i><a  href="javascript:void(0);" onclick="showMap('<?php echo base_url();?>home/maps/<?php echo $item->latitude; ?>/<?php echo $item->longitude; ?>/<?php echo $appModule; ?>/<?php echo $item->id;?>','modal');" title="<?php echo $item->location;?>"><?php echo character_limiter($item->location,10);?></a></p>
                          </div>
                          <?php  if($item->price > 0){ ?>
                          <div class="ml-auto">
                            <div class="price">
                              <?=lang('0218')?> <?=lang('0273')?>
                              <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                              <?=lang('0367')?>
                            </div>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="content">
                        <?php echo character_limiter($item->desc,150);?>
                      </div>
                      <div class="content-bottom mt-auto">
                        <div class="d-flex align-items-center">
                          <div>
                            <p><i class="far"></i><?php echo trans('0631');?>: <?php echo character_limiter($item->boatType,5); ?> <strong><?php echo trans('0275');?>: <?php echo $item->boatDays;?>  <?php echo trans('0276');?>: <?php echo $item->boatNights;?></strong></p>
                          </div>
                          <div class="ml-auto">
                            <a href="<?php echo $item->slug;?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
           <br><br>
           <nav class="mt-10 mt-md-0">
           <ul class="pagination justify-content-center justify-content-lg-left">
           <?php echo createPagination($info);?>
           </ul>
           </nav>
            <!-- <div class="pager-wrappper mt-40">
              <div class="pager-innner">
              
                <div class="row align-items-center text-center text-md-left">
                
                  <div class="col-12 col-md-5">
                    Showing reslut 1 to 15 from 248 
                  </div>
                  
                  <div class="col-12 col-md-7">
                    <nav class="float-lg-right mt-10 mt-md-0">
                      <ul class="pagination justify-content-center justify-content-lg-left">
                        <li>
                          <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><span>...</span></li>
                        <li><a href="#">11</a></li>
                        <li><a href="#">12</a></li>
                        <li><a href="#">13</a></li>
                        <li>
                          <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                  
                </div>
              
              </div>
              
              </div>-->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- end Main Wrapper -->
<style>
  .summary  { border-right: solid 2px rgb(0, 93, 247); color: #ffffff; background: #4285f4; padding: 14px; float: left; font-size: 14px; }
  .sideline { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; display: table-cell; border-left: solid 1px #e7e7e7; }
  .localarea { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; }
  .captext  { display: block; font-size: 14px; font-weight: 400; color: #23527c; line-height: 1.2em; text-transform: capitalize; }
  .ellipsis { max-width: 250px; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; }
  .noResults { right: 30px; top: 26px; color: #008cff; font-size: 16px; }
  .table { margin-bottom: 5px; }
</style>
<!-- <div class="header-mob">
  <div class="container">
    <div class="row">
      <div class="col-xs-2 text-leftt">
        <a data-toggle="tooltip" data-placement="right" title="<?php echo trans('0533');?>" class="icon-angle-left pull-left mob-back" onclick="goBack()"></a>
      </div>
      <div class="col-xs-2 text-center pull-right visible-xs">
        <a class="ttu" data-toggle="modal" data-target="#sidebar_filter">
        <i class="icon-filter mob-filter"></i>
        <span class="cw"><?php echo trans('0217');?></span>
        </a>
      </div>
      <div class="col-xs-2 text-center pull-right hidden-xs ttu">
          <a class="btn btn-primary btn-xs btn-block" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">
          <i class="icon-location-7 mob-filter"></i>
          <span><?php echo trans('067');?></span>
          </a>
      </div>
    </div>
  </div>
  </div> -->
<div class="search_head">
  <div class="container">
    <div class="clearfix"></div>
  </div>
</div>
<div class="clearfix"></div>
<div style="margin-top:-15px" class="collapse" id="collapseMap">
  <div id="map" class="map"></div>
  <br>
</div>
<!-- <div class="container">
  <?php if($appModule != "offers"){ ?>
  <div class="row listing-search">
  
  <div class="col-md-1 col-sm-2 col-xs-4 summary go-right">
   <small><?php echo trans('0379');?></small>
   <?php echo trans('039');?>
   </div>
  
    <?php if($appModule == "cars"){ ?>
    <div class="col-md-3 col-sm-10 col-xs-8 localarea go-right">
   <small class=" go-right"><?php echo trans('0210');?></small><div class="clearfix"></div>
   <span class="captext ellipsis go-right"><?php if(!empty($pickupLocationName)){ echo $pickupLocationName; }else{ ?> <span data-toggle="modal" data-target="#modify" style="cursor: pointer"> <?php echo trans('0447'); ?> </span> <?php } ?></span>
   </div>
  
   <div class="col-md-3 col-sm-10 col-xs-8 sideline localarea go-right">
   <small class=" go-right"><?php echo trans('0211');?></small><div class="clearfix"></div>
   <span class="captext ellipsis go-right"><?php if(!empty($dropoffLocationName)){ echo $dropoffLocationName; }else{ ?> <span data-toggle="modal" data-target="#modify" style="cursor: pointer">  <?php echo trans('0447'); ?> </span> <?php } ?></span>
   </div>
  
   <div class="visible-sm"><div class="clearfix"></div></div>
   <div class="visible-xs"><div class="clearfix"></div></div>
  
   <div class="col-md-2 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('0210');?> <?php echo trans('08');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo @$checkin; ?></span>
   </div>
  
   <div class="col-md-2 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('0211');?> <?php echo trans('08');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo @$checkout; ?></span>
   </div>
  
    <?php }else{ ?>
   <div class="col-md-<?php if($appModule == "tours"){ echo '6'; }else{ echo '3'; }?> col-sm-10 col-xs-8 localarea go-right">
   <small class=" go-right"><?php echo trans('0254');?></small><div class="clearfix"></div>
   <span class="captext ellipsis go-right"><?php if(!empty($searchText)){ echo @$searchText; }else{ ?><span data-toggle="modal" data-target="#modify" style="cursor: pointer">  <?php echo trans('0447'); ?> </span><?php } ?></span>
   </div>
  
   <div class="visible-sm"><div class="clearfix"></div></div>
   <div class="visible-xs"><div class="clearfix"></div></div>
  
   <div class="col-md-2 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('07');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo @$checkin; ?></span>
   </div>
    <?php if(!empty($checkout)){ ?>
   <div class="col-md-2 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('09');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo @$checkout; ?></span>
   </div>
   <?php } ?>
  
    <?php if(!empty($totalStay)){ ?>
   <div class="col-md-2 col-sm-2 col-xs-4 sideline hidden-md go-right">
   <small class="go-right"><?php echo trans('060');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo $totalStay; ?> <?php echo trans('0122'); ?></span>
   </div>
   <?php } ?>
  
   <div class="visible-xs"><div class="clearfix"></div></div>
   <div class="col-md-1 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('010');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo $adults;?></span>
   </div>
  
   <div class="col-md-1 col-sm-2 col-xs-4 sideline go-right">
   <small class="go-right"><?php echo trans('011');?></small><div class="clearfix"></div>
   <span class="captext go-right"><?php echo (int)$child; ?></span>
   </div>
  
   <?php } ?>
  
   <div class="clearfix"></div>
   </div>
  
  <?php } ?>
   </div>-->
<!-- CONTENT -->
<div style="margin-top:-15px" class="collapse" id="collapseMap">
  <div id="map" class="map"></div>
  <br>
</div>
<div class="listingbg">
  <div class="container offset-0">
    <div class="clearfix"></div>
    <?php if(!$ismobile): ?>
    <div class="col-md-3 hidden-sm hidden-xs filter"></div>
    <?php endif; ?>
    <div class="col-md-9 col-xs-12">
      <?php if($appModule != "ean" && $appModule != "hotels" && $appModule != "boats" && $appModule != "cars"){ ?>
      <?php if($appModule == "offers"); {?>
      <?php foreach($module as $item){ ?>
      <div class="col-md-6 owl-item go-right" style="margin-bottom: 25px;">
        <a href="<?php echo $item->slug;?>">
          <div class="imgLodBg loader">
            <div class="load"></div>
            <img style="width:100%" data-wow-duration="0.2s" data-wow-delay="1s" class="wow fadeIn" src="<?php echo $item->thumbnail;?>">
          </div>
        </a>
        <h4 class="ellipsis bold mb0 go-right RTL"><?php echo character_limiter($item->title,20);?></h4>
        <div class="clearfix"></div>
        <p class="tr RTL">
          <?php echo character_limiter($item->desc,100);?> &nbsp;
        </p>
        <a class="btn btn-primary go-right loader" href="<?php echo $item->slug;?>">
        <?php echo trans( '0286');?>
        </a>
        <?php  if($item->price > 0){ ?>
        <div class="text-success fs18 text-left go-text-right go-right" style="position: absolute; top: 120px; color: white; padding: 10px; background: #e94b28;">
          <b>
          <small><?php echo $item->currCode;?></small> <?php echo $item->currSymbol; ?><?php echo $item->price;?>
          </b>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <div class="itemscontainer">
        <div class="clearfix"></div>

      </div>
      <?php }else{  echo '<h1 class="text-center">' . trans("066") . '</h1>'; } ?>
      <!-- End of offset1-->
      <!-- start EAN multiple locations found and load more hotels -->
      <?php if($appModule == "ean"){ if($multipleLocations > 0){ foreach($locationInfo as $loc){ ?>
      <p><?php echo $loc->link; ?></p>
      <?php } } ?>
      <!--This is for display cache Parameter-->
      <!-- END OF LIST CONTENT-->
      <?php } ?>
      <!-- End EAN multiple locations found and load more hotels  -->
    </div>
    <!-- END OF LIST CONTENT-->
  </div>
  <!-- END OF container-->
</div>
</div>
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