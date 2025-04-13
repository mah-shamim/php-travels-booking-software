<style>#LIST li{ display:none;margin-bottom:15px;}
.content-top .fa-map-marker-alt:before{
  left:0 !important;
  top:0 !important;
}
.form-inner  label{
  position:static
}
.form-icon-left .icon-font{
  top: -2px;
}
.form-spin-group .form-icon-left .icon-font i{top: -3px;left: -9px;}
.input-group.bootstrap-touchspin{align-items:center !important}
.row.gap-10.mb-15.align-items-end{align-items:center !important}
.col-md-2.col-xs-12 button[type="submit"]{top: 10px}

</style>
<script>
$( document ).ready(function() {
size_li = $("#LIST li").size();
x=25;
$('#LIST li:lt('+x+')').show();
$('#loadMore').click(function () {
x= (x+25 <= size_li) ? x+25 : size_li;
$('#LIST li:lt('+x+')').show();
$('#showLess').show();
if(x == size_li){
$('#loadMore').hide();
}
});
});
</script>

<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
    <div id="change-search" class="collapse">
    <div class="change-search-wrapper">
    <?php echo Search_Form("TravelhopeHotels","hotels"); ?>
    </div>
    </div>
      <div class="row gap-20 gap-md-30 gap-xl-40">
        <div class="col-12 col-lg-3">
          <aside class=" sticky-kit sidebar-wrapper filter-wrapper mb-10 mb-md-0">
            <div class="box-expand-lg">
              <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
                <div class="wrapper-inner">
                  <div class="sidebar-title bg-primary">
                    <div class="d-flex align-items-end">
                      <div>
                        <h4 class="text-white font-serif font400"><?=trans('0191')?></h4>
                      </div>
                    </div>
                  </div>
                  <form name="fFilters" action="#" method="POST" role="search">
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?php echo trans('0137');?> <?php echo trans('069');?></h5>
                      </div>
                      <div class="box-content">
                        <div class="rating-item rating-sm rating-inline">
                          <div class="rating-icons go-right custom-stars">
                            <?php $star = '<span class="rating-icon fas fa-star rating-rated"></span>'; ?>
                            <?php $stars = '<div class="rating-symbol-background rating-icon far fa-star"></div>'; ?>
                            <div class="custom-control custom-radio">
                              <div class="mb-5 custom-ratting rating-stars">
                                <input id="1" type="radio" name="stars" class="custom-control-input" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                                <label class="custom-control-label " for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?>
                                </label>
                                <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting rating-stars">
                                <input id="2" type="radio" name="stars" class="custom-control-input" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                                <label class="custom-control-label" for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting rating-stars">
                                <input id="3" type="radio" name="stars" class="custom-control-input" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                                <label class="custom-control-label" for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting rating-stars">
                                <input id="4" type="radio" name="stars" class="custom-control-input" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                                <label class="custom-control-label" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                <div class="clear"></div>
                              </div>
                              <div class="mb-5 custom-ratting rating-stars">
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
                      </div>
                      <div class="box-content">
                      <input class="js-range-slider"/>
                      </div>
                    </div>
                    <div class="sidebar-box">
                      <div class="box-title">
                        <h5><?=trans('0598')?></h5>
                      </div>
                      <div class="box-content">
                        <div class="custom-control custom-radio">
                          <div><input type="radio" id="priceOrderDes" class="custom-control-input priceOrderAsc" name="priceOrder" value="des">&nbsp;&nbsp;<label class="custom-control-label" for="priceOrderDes"><?=trans('0599')?></label></div>
                          <div ><input type="radio" class="custom-control-input priceOrderAsc" id="priceOrderAsc" name="priceOrder" value="acs">&nbsp;&nbsp;<label class="custom-control-label" for="priceOrderAsc"><?=trans('0600')?></label></div>
                        </div>
                      </div>
                    </div>
                    <div class="sidebar-box">
                      <div class="box-content">
                        <button  type="submit" class="btn btn-primary btn-lg btn-block" id="searchform"><?=lang('0191')?></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="d-block d-lg-none">
              <button type="buttom" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile">Show Filter</button>
            </div>
          </aside>
        </div>
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="d-lg-flex mb-30 mb-lg-0">
              <div>
                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                <h3 class="heading-title"><span><?=lang('Hotels')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                <div class="clear"></div>
                <?php } ?>
                <!--<p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p>-->
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search">Modify</button>
              </div>
            </div>
            <div id="listing">
              <ul id="LIST">
              <?php if(isset($hotels) && ! empty($hotels)): ?>
              <?php $min_price = 0;$max_price =0; foreach($hotels as $hotel):
                $url = preg_replace('/\s+|&/', '-', $hotel->company_name);?>
               <li class="loadAll" data-price="<?=$hotel->price?>" data-stars="<?=ceil($hotel->rating)?>">
               <div class="product-long-item"  >
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink">
                    <div class="image">
                      <img src="<?= $hotel->image ?>" class="center-block loader" alt="<?= $url ?>">
                    </div>
                  </div>
                  <div class="col-12 col-auto">
                    <div class="col-inner d-flex flex-column">
                      <div class="content-top">
                        <div class="d-flex">
                          <div class="rtl-mr-auto">
                            <div class="rating-item rating-sm rating-inline">
                              <div class="rating-icons">
                                <?php for($star = 1; $star <= 5; $star++): ?>
                                <?php if($hotel->rating < $star): ?>
                                <i class="rating-symbol-background rating-icon far fa-star"></i>
                                <?php else: ?>
                                <i class="rating-icon fas fa-star rating-rated"></i>
                                <?php endif; ?>
                                <?php endfor; ?>
                              </div>
                              <p class="rating-text text-muted"><span class="bg-primary"><?=$hotel->rating.' / 5'?></span></p>
                            </div>
                            <h5><a href="#"><?= $hotel->company_name ?></a></h5>
                            <p class="location"><i class="fas fa-map-marker-alt text-primary"></i><?=$hotel->city_name?></p>
                          </div>
                          <div class=" ml-auto">
                            <div class="price">
                              <?php echo trans('0218');?> <?php echo trans('0273');?>
                              <span class="text-secondary"><?= $hotel->currencies ?> <?= $hotel->price ?></span>
                              <?php echo trans('0245');?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="content">
                        <p><?=strlen($hotel->description) > 250 ? substr($hotel->description,0,250)."..." : $hotel->description;?></p>
                      </div>
                      <div class="content-bottom mt-auto">
                        <div class="d-flex align-items-center">
                          <div class="rtl-mr-auto">
                            <ul class="list-icon-absolute list-inline-block">
                              <!-- <li><span class="icon-font"><i class="fas fa-check-circle text-primary"></i> </span> Breakfast Included</li>
                                <li><span class="icon-font"><i class="fas fa-check-circle text-primary"></i></span> Free Wifi in Room</li> -->
                            </ul>
                          </div>
                          <div class="ml-auto">
                            <form action='<?=base_url("thhotels/detail/{$url}")?>' method="post">
                              <input type="hidden" name="hotel_id" value='<?=$hotel->id?>'>
                              <input type="hidden" name="custom_payload" value='<?=json_encode($hotel->custom_payload)?>'>
                              <input type="hidden" name="search_form" value='<?=json_encode($searchForm)?>'>
                              <button type="submit" class="btn btn-primary">
                              <?php echo trans('0177');?>
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                      <?php  if(($hotel->price < $min_price) || ($min_price == 0) ){ $min_price = ceil($hotel->price);  }  if($hotel->price > $max_price ){  $max_price = ceil($hotel->price); if($max_price == 20) {dd($hotel);} }  ?>
              <?php endforeach;  ?>
              </li>
              <?php endif;   ?>
             </ul>
            <button id="loadMore" class="btn btn-block btn-primary btn-lg"><?=lang('0185')?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
</div>
<script>

    var main = $(".loadAll");
    var min_price= <?=$min_price?>;
    var max_price= <?=$max_price?>;

    function slider() {
        $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: min_price,
            max: max_price,
            from: min_price,
            to: max_price,
            grid: true,
            onChange: function (data) {
                min_price =  data.from;
                max_price = data.to;
                filter_price_func();
            }
        });
    }

    $('input[type="radio"]').click(function ()
    {
        filter_engine($(this).val());
    });

    $('.priceOrderAsc').click(function ()
    {
        if($(this).val() == "acs"){
            var temp_filter = main
            var byDate = temp_filter.slice(0);
            temp_filter =  byDate.sort(function(a,b) {
                var price_a = parseInt($(a).data('price'));
                var price_b = parseInt($(b).data('price'));
                return price_a - price_b;
            });
        }else{
            var temp_filter = main
            var byDate = temp_filter.slice(0);
            temp_filter =  byDate.sort(function(a,b) {
                var price_a = parseInt($(a).data('price'));
                var price_b = parseInt($(b).data('price'));
                return   price_b - price_a;
            });
        }
        $("#LIST").empty();
        $("#LIST").append(temp_filter);
    });
    function filter_engine(stars)
    {
        var temp_filter  = [];
        for(var i=0;i<main.length;i++){
            if($(main[i]).data('stars') == stars)
                temp_filter.push(main[i]);
            }
        $("#LIST").empty();
        $("#LIST").append(temp_filter);
    }

    function filter_price_func() {
        var temp_array = [];
        for(var i = 0; i < main.length; i++) {
            var price = parseInt($(main[i]).data('price') );
            if (price > min_price &&  price < max_price ) {
                temp_array.push(main[i]);
            }
        }
        $("#LIST").empty();
        $("#LIST").append(temp_array);
    }




    function in_array(needle, haystack) {
        for (var i in haystack) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 20; // For Safari
        document.documentElement.scrollTop = 20; // For Chrome, Firefox, IE and Opera
    }

</script>
<!-- <style>
  .table { margin-bottom: 5px; }
  .filter {
      background: #fff;
  }
  .filter label {
      color: #0f0f0f;
  }
  .filterstext span {
      padding: 5px 0px;
  }
  </style>
  <div class="search_head">
  <div class="container"><br>
      <div class="clearfix"></div>
  </div>
  </div>
  <div class="listingbg">
  <div class="container offset-0">
      <div class="clearfix"></div>
      <div class="row">
      <div class="col-md-3 hidden-sm hidden-xs filter">
          <!-- FILTERS -->
<!-- <form name="" action="#" method="POST" role="search">
  <div style="padding:10px 10px 10px 10px">
      <div class="textline">
          <span class="filterstext"><span><i class="icon_set_1_icon-95"></i><?=trans('0191')?></span></span>
      </div>
  </div>
  <div class="clearfix"></div> -->
<!-- Price range -->
<!-- <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#priceOrderFilter">
  <?=trans('0598')?> <span class="collapsearrow"></span>
  </button>
  <div id="priceOrderFilter" class="collapse in">
  <div class="panel-body">
      <div class="go-right"><input type="radio" id="priceOrderDes" name="priceOrder" value="des">&nbsp;&nbsp;<label class="go-left" for="priceOrderDes"><?=trans('0599')?></label></div>
      <div class="go-right"><input type="radio" id="priceOrderAsc" name="priceOrder" value="acs">&nbsp;&nbsp;<label class="go-left" for="priceOrderAsc"><?=trans('0600')?></label></div>
  </div>
  </div> -->
<!-- Star ratings -->
<!-- <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse1">
  <?php echo trans('0601');?> <span class="collapsearrow"></span>
  </button>
  <div id="collapse1" class="collapse in">
  <div class="hpadding20">
      <br>
      <?php for($radios = 0; $radios < 5; $radios++): ?>
          <?php $checked = ($radios+1 == $input->stars)?'checked':''; ?>
          <div class="rating" style="font-size: 14px;">
              <label class="rating-stars" for="<?=$radios+1?>" data-value="<?=$radios?>">
                  <div class="iradio_square-grey <?=$checked?>" style="position: relative;">
                      <input type="radio" <?=$checked?> id="<?=$radios+1?>" name="stars" class="go-right radio" value="<?=$radios+1?>" style="position: absolute; opacity: 0;">
                      <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins>
                  </div>
                  <i class="fa <?=($radios >= 0)?'star fa-star':'fa-star-o'?>"></i>
                  <i class="fa <?=($radios >= 1)?'star fa-star':'fa-star-o'?>"></i>
                  <i class="fa <?=($radios >= 2)?'star fa-star':'fa-star-o'?>"></i>
                  <i class="fa <?=($radios >= 3)?'star fa-star':'fa-star-o'?>"></i>
                  <i class="fa <?=($radios >= 4)?'star fa-star':'fa-star-o'?>"></i>
              </label>
          </div>
      <?php endfor; ?>
  </div>
  <div class="clearfix"></div>
  <br>
  </div> -->
<!-- End of Star ratings -->
<!-- Price Range -->
<!-- <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse2">
  <?php echo trans('0301');?> <span class="collapsearrow"></span>
  </button>
  <div id="collapse2" class="collapse in">
  <div class="panel-body text-center">
      <?php
    $selectedprice =  "10, 5000";
    $minprice = 10;
    $maxprice = 5000;
    $step = 500;
    ?>
      <input type="text" id="price-range-slider" name="price" class="col-md-12" value="<?=$selectedprice?>"
             data-slider-min="<?=$minprice?>"
             data-slider-max="<?=$maxprice?>"
             data-slider-step="<?=$step?>"
             data-slider-value="[<?=$selectedprice?>]">
  </div>
  </div> -->
<!-- End of Price Range -->
<!-- <br/>
  <button style="border-radius:0px;margin-bottom:0px;" type="button" class="btn btn-primary br25 btn-lg btn-block loader" id="searchform"></button>
  </form>
  </div>

  <div class="col-md-9 col-xs-12">
  <div class="itemscontainer">
  <table class="bgwhite table table-striped" id="listing">
      <?php if(isset($hotels) && ! empty($hotels)): ?>
          <?php foreach($hotels as $hotel):
    $url = preg_replace('/\s+|&/', '-', $hotel->company_name);
    ?>
              <tr data-price="<?=$hotel->price?>" data-stars="<?=$hotel->rating?>">
                  <td class="wow fadeIn p-10-0">
                      <div class="col-md-3 col-xs-5 go-right rtl_pic">
                          <div class="img_list">
                              <div class="review text-center size18 hidden-xs"><?=$hotel->rating.' / 5'?></div>
                              <a href='<?=base_url("thhotels/detail/{$url}")?>'>
                                  <img src="<?= $hotel->image ?>" class="center-block loader" alt="<?= $url ?>">
                                  <div class="short_info"></div>
                              </a>
                          </div>
                      </div>
                      <div class="col-md-6 col-xs-4 g0-left">
                          <div class="row">
                              <h4 class="RTL go-text-right mt0 list_title">
                                  <a href='<?=base_url("thhotels/detail/{$url}")?>'><b><?= $hotel->company_name ?></b></a>
                              </h4>
                              <a class="go-right ellipsisFIX go-text-right mob-fs14" href="javascript:void(0);" title="<?=$hotel->city_name?>">
                                  <i style="margin-left: -3px;" class="mob-fs14 icon-location-6 go-right"></i><?=$hotel->city_name?>  </a>
                              <?php for($star = 1; $star <= 5; $star++): ?>
                                  <?php if($hotel->rating < $star): ?>
                                      <i class="star star fa fa-star-o"></i>
                                  <?php else: ?>
                                      <i class="star fa fa-star"></i>
                                  <?php endif; ?>
                              <?php endfor; ?>

                              <p style="margin: 7px 0px 7px 0px;" class="grey RTL fs12 hidden-xs">
                                  <?=strlen($hotel->description) > 250 ? substr($hotel->description,0,250)."..." : $hotel->description;?>
                              </p>
                          </div>
                      </div>
                      <div class="col-md-3 col-xs-4 col-sm-4 go-left pull-right price_tab">
                          <div class="fs26 text-center"><small><?= $hotel->currencies ?></small> <strong><?= $hotel->price ?></strong></div>
                          <form action='<?=base_url("thhotels/detail/{$url}")?>' method="post">
                              <input type="hidden" name="hotel_id" value='<?=$hotel->id?>'>
                              <input type="hidden" name="custom_payload" value='<?=json_encode($hotel->custom_payload)?>'>
                              <input type="hidden" name="search_form" value='<?=json_encode($searchForm)?>'>
                              <button type="submit" class="btn btn-primary br25 loader loader btn-block">
                                  <?php echo trans('0177');?>
                              </button>
                          </form>
                      </div>
                  </td>
              </tr>
              <div class="clearfix"></div>
          <?php endforeach; ?>
      <?php endif; ?>
  </table>
  <div class="clearfix"></div>
  </div>
  </div>
  </div>
  </div>
  </div> -->
<!-- <script type="text/javascript">
  var rows = $('#listing').find('.product-long-item');

  $(function () {
      $( "#price_range" ).slider({
          range: true,
          min: 0,
          max: 500,
          values: [ 75, 300 ],
          slide: function( event, ui ) {
              console.log( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
          }
      });
  });

  // Sorting according to prices.
  $("[name^=priceOrder]").click(function() {
      var order = $(this).val();
      console.log(order)
      var tb = $('#listing');

      var rows = tb.find('.product-long-item');
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

  $("[class^=rating-stars]").click(function() {
      var star = $(this).data('value');
      alert(star)
      var tb = $('#listing');
      tb.empty(); // clear rows
      $.each(rows, function (index, row, rows) {
          console.log($(row).data('stars'), ' - ', star);
          if ($(row).data('stars') == star) {
              tb.append(row);
          }
      });
  });

  $("form[name=fFilters]").on("submit", function(e) {

  });
</script> -->