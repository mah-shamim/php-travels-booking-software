<div class="header-mob hidden-xs">
    <div class="container">
        <div class="col-xs-2 text-leftt">
            <a data-toggle="tooltip" data-placement="right" title="<?php echo trans('0533'); ?>"
                class="icon-angle-left pull-left mob-back" onclick="goBack()"></a>
            </div>
            <div class="col-xs-1 text-center pull-right hidden-xs ttu hidden-lg">
                <div class="row">
                    <a class="btn btn-success btn-xs btn-block" data-toggle="collapse" data-target="#modify"
                    aria-expanded="false" aria-controls="modify">
                    <i class="icon-filter mob-filter"></i>
                    <span><?php echo trans('0106'); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="search_head" style="padding: 80px 0px;">
    <?php echo searchForm("Juniper", $search_param); ?>
</div>
<br>
<div class="container">
    <?php  //dd($search_param); ?>
        <div class="row">
            <div class="col-md-3">
                <div style="padding:10px">
                    <div class="textline">
                        <span class="filterstext"><span><i class="icon_set_1_icon-95"></i><?=trans('0191')?></span></span>
                    </div>
                </div>

                <br>
                <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse1">
                    <?php echo trans('0137');?> <?php echo trans('069');?> <span class="collapsearrow"></span>
                </button>
                <div id="collapse1" class="collapse in">
                    <div class="hpadding20">
                        <br>
                        <?php for($radios = 0; $radios < 5; $radios++): ?>
                            <?php $checked = ($radios+1 == $search_param['stars'])?'checked':''; ?>
                            <div class="rating" style="font-size: 14px;">
                                <div class="go-right">
                                    <label class="go-left" for="<?=$radios+1?>">
                                        <div class="iradio_square-grey" style="position: relative;">
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
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <br>
                <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse2">
                    <?php echo trans('0221');?> <span class="collapsearrow"></span>
                </button>
                <?php 
                $category = array('T' => 'touristic', 'ST' => 'superior touristic' , 'F' => 'first category' , 'SF' => 'superior first category' , 'D'=>'deluxe');
                ?>
                <div id="collapse2" class="collapse in">
                    <div class="hpadding20">
                        <br>
                        <?php foreach ($category as $key => $value) { ?>
                            <?php $checked = ($key == $search_param['category'])?'checked':''; ?>
                            <div class="rating" style="font-size: 14px;">
                                <div class="go-right">
                                    <label class="go-left" for="<?=$key?>">
                                        <div class="iradio_square-grey" style="position: relative;">
                                            <input type="radio" <?=$checked?> id="<?=$key?>" name="category" class="go-right radio" value="<?=$key?>" style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins>
                                        </div>
                                        <?=ucwords($value)?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <br>
<!-- <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse3">
<?php echo trans('0249');?> <span class="collapsearrow"></span>
</button>
<?php $facilities = array('AVAILONLY' => 'Available Only' , 'BESTPRICE' => 'Best Price' ,'BESTARRANGMENT' => 'Best Arrangement'); ?>
<div id="collapse3" class="collapse in">
<div class="hpadding20">
<br>
<?php foreach($facilities as $key => $facilitie): ?>
<div class="go-right">
<label for="all">
<input type="checkbox" <?=$checked?> name="<?=$key?>" value="<?=$key?>" class="checkbox"/>
<?=$facilitie?>
</label>
</div>
<?php endforeach; ?>
</div>
</div>
<br> -->
<button type="submit" class="btn btn-primary br25 btn-block loader"><?=trans('012')?></button>
</form>
</div>
<div class="col-md-9">
    <table class="bgwhite table table-striped">
        <tbody>
            <?php 
            if (empty($hotel_data[0]['errors'])) {
                foreach ($hotel_data as $data) { ?>
                    <tr>
                        <td class="wow fadeIn p-10-0 animated" style="visibility: visible; animation-name: fadeIn;">
                            <div class="col-md-3 col-xs-4 go-right rtl_pic">
                                <span class="hidden-xs">
                                    <div title="" data-toggle="tooltip" data-placement="left" id="32" data-module="hotels" class="wishlist wishlistcheck hotelswishtext32" data-original-title="Add to wishlist"><a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"></a></div>
                                </span>
                                <div class="img_list">
                                    <a href="#">
                                        <img src="http://localhost/app/uploads/images/hotels/slider/thumbs/731415_8.jpg" class="center-block loader" data-lazy="http://localhost/app/uploads/images/hotels/slider/thumbs/731415_8.jpg" alt="<?php echo $data['hotel_name']; ?>">
                                        <div class="short_info"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>
                                            <a href="http://localhost/Dropbox/v6/hotels/detail/dubai/jumeirah-beach-hotel/27-10-2018/29-10-2018/2/0">
                                                <b><?php echo $data['hotel_name']; ?></b><br>
                                                <small><?php echo $data['hotel_address'];  ?></small>
                                            </a>
                                            <span class="pull-right" style="margin-top: -10px;">
                                            <?php $stars_count = $data['hotel_stars'];
                                            for ($i=0; $i < $stars_count ; $i++) {
                                                ?>
                                                <i class="star fa fa-star"></i>
                                            <?php  } ?>
                                            </span>
                                        </h4>    
                                    </div>
                                    <div class="col-md-12">
                                        <ul> 
                                            <li><?=trans('0246')?>: <?=abbreviation($data['hotel_room_basis'])?></li>
                                            <li>Meal Type: <?=abbreviation($data['hotel_meal_basis'])?></li>
                                            <li><?=trans('0405')?> <?=trans('032')?>: <?=abbreviation($data['hotel_location'])?></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php // dd($data); ?>
                            </div>
                            <div class="col-md-3 col-xs-4 col-sm-4 pull-right ">
                                <ul style="text-align: right;"> 
                                    <li><?=trans('010')?> Occupancy : <?=$data['hotel_room_occupancy']?></li>
                                    <li><?=trans('011')?> Occupancy : <?=$data['hotel_room_occupancyChild']?></li>
                                    <li><?=trans('0282')?> Occupancy : <?=$data['hotel_room_occupancyInfant']?></li>
                                </ul> 
                                <h3 style="text-align: right;">
                                    <small><?php  echo $data['hotel_currency']; ?></small> <b><?php  echo calculate_commission($data['hotel_total'],$commission); ?></b><br>
                                    <a class="btn btn-primary btn-sm" style="float: right;" href="<?php echo site_url('juniper/details/'.$data['hotel_code']); ?>"><?php echo trans('0177');  ?>
                                </a>
                                <form action="<?=site_url('juniper/booking');?>" method="POST" class="form-inline" style="margin-top: -1px">
                                    <input type="hidden" name="juniper_city" value="<?php echo $search_param['city']?>">
                                    <input type="hidden" name="hotel_name" value="<?=$data['hotel_name'];?>">
                                    <input type="hidden" name="hotel_address" value="<?=$data['hotel_address'];?>">
                                    <input type="hidden" name="juniper_nationality" value="<?=$search_param['nationality']?>">
                                    <input type="hidden" name="juniper_city" value="<?php echo $search_param['city']?>">
                                    <input type="hidden" name="juniper_checkin_date" value="<?=$search_param['checkin_date']?>">
                                    <input type="hidden" name="juniper_checkout_date" value="<?=$search_param['checkout_date']?>">
                                    <input type="hidden" name="type" value="<?=$search_param['room_type']?>">
                                    <input type="hidden" name="hotel_code" value="<?=$data['hotel_code']?>">
                                    <input type="hidden" name="hotel_currency" value="<?=$data['hotel_currency']?>">
                                    <input type="hidden" name="hotel_total" value="<?=$data['hotel_total']?>">
                                    <input type="hidden" name="required" value="<?=$search_param['room_required']?>">
                                    <input type="hidden" name="hotel_booking_id" value="<?php echo $data['hotel_booking_id']; ?>">
                                    <input type="submit" class="btn-sm btn btn-success" value="Book Now">
                                </form>
                            </h3>
                        </div>
                    </td>
                </tr>
            <?php }
        } if (!empty($pagination_count)) {
            ?>
            <tr>
                <td>
                    <div class="pull-right">
                        <?php echo $pagination; ?>
                    </div>
                    <div class="pull-left" style="padding-top: 5px;">
                        <?php echo $pagination_count; ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php if(empty($pagination_count)) { ?>
    <div class="alert alert-danger">
        No Hotel Found.
    </div>
<?php } ?>
</div>
</div>
</div>
