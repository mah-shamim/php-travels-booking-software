<?php
$hotel_data = $all_hotels['segments'][$current_hotel];
$rooms = $hotel_data['room_data'];
//dd($rooms);
?>
<section id="ROOMS">
    <div class="panel panel-default">
        <div class="panel-heading go-text-right panel-default ttu"><?php echo trans('0372');?></div>
        <form action="<?=site_url('juniper/booking');?>" method="POST" class="form-inline">
            <input type="hidden" name="juniper_city" value="<?php echo $search_param['city']?>">
            <input type="hidden" name="type" value="<?=$search_param['room_type']?>">
            <input type="hidden" name="juniper_nationality" value="<?=$search_param['nationality']?>">
            <input type="hidden" name="juniper_city" value="<?php echo $search_param['city']?>">
            <input type="hidden" name="juniper_checkin_date" value="<?=$search_param['checkin_date']?>">
            <input type="hidden" name="juniper_checkout_date" value="<?=$search_param['checkout_date']?>">
            <input type="hidden" name="required" value="<?=$search_param['room_required']?>">
            <input type="hidden" name="hotel_name" value="<?=$hotel_data['hotel_name'];?>">
            <input type="hidden" name="hotel_address" value="<?=$hotel_data['hotel_address'];?>">
            <input type="hidden" name="hotel_code" value="<?=$hotel_data['hotel_code']?>">
            <input type="hidden" name="hotel_currency" value="<?=$hotel_data['hotel_currency']?>">
            <input type="hidden" id="hotel_total" name="hotel_total">
            <input type="hidden" id="hotel_booking_id" name="hotel_booking_id" value="">
            <table class="bgwhite table table-striped">
                <?php if(!empty($rooms)){
                    $i = 1;
                    foreach ($rooms as $room) { ?>
                        <tr>
                            <td class="wow fadeIn p-10-0">
                                <div class="col-md-2 col-xs-5 go-right rtl_pic">
                                    <div class="img_list_rooms">
                                        <div class="zoom-gallery<?php echo $r->id; ?>">
                                            <a href="<?php echo base_url('uploads/images/hotels/slider/thumbs/1.jpg');?>" data-source="<?php echo base_url('uploads/images/hotels/slider/thumbs/1.jpg');?>" title="<?=$room['hotel_room_type']?>">
                                                <img style="max-height:180px" class="img-responsive" src="<?php echo base_url('uploads/images/hotels/slider/thumbs/1.jpg');?>">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10 col-xs-7 g0-left">
                                    <div class="col-md-4 go-right" style="margin-top: 15px;">
                                        <div class="row">
                                            <h4 class="RTL go-text-right mt0 list_title ttu">
                                                <a href="javascript:void(0)">
                                                    <b><?php echo $room['hotel_room_type'];?></b>
                                                    <div class="clearfix"></div>
                                                    <small>
                                                        <strong><?php echo trans('010');?></strong> <?php echo $room['hotel_room_occupancy'];?><br>
                                                        <strong><?php echo trans('011');?></strong> <?php echo $room['hotel_room_occupancyChild'];?></small>
                                                    </a>
                                                    <!--<a href=""><b><?php echo trans('070');?> <?php echo $modulelib->stay; ?> <?php echo trans('0122');?></b></a>-->
                                                </h4>
                                                <!--<div style="margin: 7px 0px 7px 0px;" class="grey RTL fs12 hidden-xs"><?php echo character_limiter($r->desc, 230);?></div>-->
                                            </div>
                                        </div>
                                        <div class="col-md-8 book_area go-left">
                                            <div class="row">
                                                <div class="col-md-5 book_buttons hidden-xs hidden-sm go-right">
                                                    <br>
                                                    <button data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-default btn-block btn-sm"  href="#details<?=$i?>"><?php echo trans('052');?></button>
                                                </button>
                                            </div>
                                            <div class="col-md-4 go-right">
                                                <h2 class="book_price text-center mob-fs18 rooms-book-button go-right">
                                                 <strong><?php echo $hotel_data['hotel_currency']; ?><?php echo calculate_commission($room['hotel_room_gross'],$commission); ?></strong>
                                             </h2>
                                         </div>
                                         <div class="col-md-3 go-right pull-right">
                                            <div class="row">
                                                <br>
                                                <?php if($room['hotel_available'] == 'true'){ ?>
                                                    <br><br>
                                                    <label data-toggle="collapse" data-target="#<?php echo $r->price; ?>" aria-expanded="false" aria-controls="<?php echo $r->price; ?>" class="control control--checkbox ellipsis fs14">
                                                        <!--<?php echo $r->price; ?> --> &nbsp;
                                                        <input type="radio" name="rooms" onclick="total('<?php echo calculate_commission($room['hotel_room_gross'],$commission); ?>','<?php echo $room['hotel_booking_id']; ?>')" value="<?=$room['hotel_booking_id']?>" id="roomsCheckbox"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                <?php } else { ?>
                                                    <div class="alert alert-danger">
                                                        Room Not Available.
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <br>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div id="details<?php echo $i;?>" class="collapse">
                                   <div class="panel panel-default">
                                    <div class="panel-body">
                                        <p class="RTL"><strong><?php echo trans('055');?> : </strong></p>
                                        <div class="col-md-3">
                                            <ul class="list_ok RTL">
                                                <li><?php echo abbreviation($room['hotel_room_basis']);?></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list_ok RTL">
                                                <li><?php echo abbreviation($room['hotel_meal_basis']);?></li>
                                            </ul>
                                        </div>

                                        <div class="col-md-3">
                                            <ul class="list_ok RTL">
                                                <li>Adult Occupancy: <?php echo ($room['hotel_room_occupancy']);?></li>
                                            </ul>
                                        </div>

                                        <div class="col-md-3">
                                            <ul class="list_ok RTL">
                                                <li>Child Occupancy: <?php echo ($room['hotel_room_occupancyChild']);?></li>
                                            </ul>
                                        </div>

                                        <div class="col-md-3">
                                            <ul class="list_ok RTL">
                                                <li>Infant Occupancy: <?php echo ($room['hotel_room_occupancyInfant']);?></li>
                                            </ul>
                                        </div>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                    <?php $i++; 
                }
            }
            ?>
        </table>
    </div>
    <button type="submit" class="book_button btn btn-md btn-success btn-block btn-block chk mob-fs10 loader" disabled>
        <?php echo trans('0142');?>
    </button>
</form>
</div>
</section>
<script>
    $("[name^=rooms").on('click', function () {
        if ($('[name="rooms"]:checked').length > 0) {
            $('[type=submit]').prop('disabled', false);
        } else {
            $('[type=submit]').prop('disabled', true);
        }
    });

    function total(amount,agreement){
        document.getElementById('hotel_total').value = amount;
         document.getElementById('hotel_booking_id').value = agreement;
    }
</script>