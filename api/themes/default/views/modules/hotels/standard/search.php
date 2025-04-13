<div class="tab-inner menu-horizontal-content">
<div class="form-search-main-01">
<form name="fCustomHotelSearch" autocomplete="off" action="<?=base_url($module.'/search')?>" method="GET" role="search">
    <div class="form-inner">
        <div class="row gap-10 mb-15 align-items-end">
            <div class="col-md-3 col-xs-12 o4">
                <div class="form-group">
                    <label class="fr"><?=lang('0120')?></label>
                    <div class="clear"></div>
                    <div class="form-icon-left typeahead__container">
                        <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                        <input class="form-control hotelsearch locationlist<?=$module?>" name="hotel_s2_text" type="search" autocomplete="off" value="<?=$_SESSION['hotel_select2']['id']?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 o3">
                <div class="col-inner">
                    <div id="airDatepickerRange-hotel" class="row gap-10 mb-15">
                        <div class="col-6 o2">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('07'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                    <input type="text" id="DateStartHotel" class="form-control form-readonly-control" name="checkin" placeholder="dd/mm/yyyy" value="<?=$_SESSION['hotel_checkin']?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-6 o1">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('09'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                    <input type="text" id="DateEndHotel" class="form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=$_SESSION['hotel_checkout']?>" name="checkout">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 o2">
                <div class="col-inner">
                    <div class="row gap-10 mb-15">
                        <div class="col-12">
                            <div class="col-inner">
                                <div class="form-people-thread">
                                    <div class="row gap-5 align-items-center">
                                        <div class="col o2">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('010');?> <small class=" text-muted font10 line-1">(12-75)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="adults" readonly value="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'2'?>" placeholder="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'2'?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col 01">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="child"  readonly value="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>" placeholder="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 o1">
            <input type="hidden" name="module_type"/>
            <input type="hidden" name="slug"/>
            <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i>
             <?php echo trans('012'); ?>
            </button>
            </div>
        </div>
    </div>
</form>
</div>
</div>


